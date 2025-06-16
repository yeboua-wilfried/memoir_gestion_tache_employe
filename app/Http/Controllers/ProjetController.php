<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tache;
use App\Models\Projet;
use App\Models\TacheUser;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProjetController extends Controller
{
    public function index()
    {
        return view('projets.index');
    }

    public function create()
    {
        $user = auth()->user();
        $role = $user->poste->role;
        $users = collect(); // Valeur par défaut

        if ($role === 'medium_employe') {
            // Chef d'équipe
            $users = User::withCount('tacheRealiserUsers')->where('equipe_id', $user->equipe_id)->where('disponibilite_user', '!=', 'départ')->get();

        } elseif ($role === 'super_employe') {
            // Chef de département
            $users = User::whereHas('equipe', function ($query) use ($user) {
                    $query->where('departement_id', $user->equipe->departement_id);
                })->where('disponibilite_user', '!=', 'départ')->withCount('tacheRealiserUsers')->get();

        } elseif ($role === 'pdg' || $role === 'admin') {
            // Admins ou DG
            $users = User::withCount('tacheRealiserUsers')->where('disponibilite_user', '!=', 'départ')->get();

        } else {
            return redirect()->route('home')->with('error', 'Vous n\'êtes pas autorisé à créer un projet.');
        }

        return view('projets.create', compact('users'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'nom' => 'required|string|max:255',
                'description' => 'required|string',
                'date_debut' => 'required|date',
                'date_fin' => 'required|date|after_or_equal:date_debut',
                'taches.*.nom' => 'nullable|string|max:255',
                'taches.*.description' => 'nullable|string',
                'taches.*.date_debut' => 'nullable|date',
                'taches.*.date_fin' => 'nullable|date|after_or_equal:taches.*.date_debut',
            ]);

            // Création du projet
            Log::debug('Debut Création du projet', ['request' => $request->all()]);

            $projet = Projet::create([
                'nom' => $request->nom,
                'description' => $request->description,
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
                //'etat' => 'en_cours',
            ]);

            Log::debug('Projet créé avec succès', ['projet_id' => $projet->id]);

            // Création des tâches liées au projet
            Log::debug('Début de la création des tâches', ['taches' => $request->taches]);
            $tch = 0;
            foreach ($request->taches ?? [] as $tacheData) {
                $tch++;
                Log::debug('DebutCréation de la tâche ', ['tache_index' => $tch]);

                $tache = new Tache([
                    'nom' => $tacheData['nom'],
                    'description' => $tacheData['description'],
                    'date_debut' => $tacheData['date_debut'],
                    'date_fin' => $tacheData['date_fin'],
                    //'etat' => 'en_cours',
                    'user_id' => auth()->id(), // créateur de la tâche
                    'projet_id' => $projet->id,
                ]);
                $tache->save();
                Log::debug('Tâche créée avec succès ', ['tache_index' => $tch]);

                // Enregistrement des utilisateurs assignés
                Log::debug('Assignation des utilisateurs à la tâche', ['tache_index' => $tch]);
                if (!empty($tacheData['users'])) {
                    foreach ($tacheData['users'] as $userId) {
                        TacheUser::create([
                            'user_id' => $userId,
                            'tache_id' => $tache->id,
                        ]);

                        // Vérification du nombre de tâches assignées à l'utilisateur
                        $nbTaches = DB::table('tache_users')->where('user_id', $userId)->count();

                        // Mise à jour de la disponibilité
                        $disponibilite = $nbTaches >= 3 ? 'surchargé' : 'disponible';

                        DB::table('users')->where('id', $userId)->update(['disponibilite_user' => $disponibilite]);
                    }
                    Log::debug('Utilisateurs assignés à la tâche', ['tache_index' => $tch]);
                }
            }

            DB::commit();
            return redirect()->route('taches.index')->with('success', 'Projet créé avec succès !');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Erreur lors de la création du projet : ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        return view('projet.show', compact('id'));
    }

    public function edit($id)
    {
        $user = auth()->user();
        $role = $user->poste->role;

        if (!in_array($role, ['medium_employe', 'super_employe_rh', 'super_employe', 'pdg', 'admin'])) {
            return redirect()->route('home')->with('error', 'Vous n\'êtes pas autorisé à modifier ce projet.');
        }

        // Récupération du projet
        $projet = Projet::findOrFail($id); // <-- Cette ligne manquait

        // Chargement des relations tâches + utilisateurs
        $projet->load('taches.tacheRealiserUsers');

        $users = collect(); // Valeur par défaut

        if ($role === 'medium_employe') {
            // Chef d'équipe
            $users = User::withCount('tacheRealiserUsers')->where('equipe_id', $user->equipe_id)->where('disponibilite_user', '!=', 'départ')->get();

        } elseif ($role === 'super_employe') {
            // Chef de département
            $users = User::whereHas('equipe', function ($query) use ($user) {
                    $query->where('departement_id', $user->equipe->departement_id);
                })->where('disponibilite_user', '!=', 'départ')->withCount('tacheRealiserUsers')->get();

        } elseif ($role === 'pdg' || $role === 'admin') {
            // Admins ou DG
            $users = User::withCount('tacheRealiserUsers')->where('disponibilite_user', '!=', 'départ')->get();

        } else {
            return redirect()->route('home')->with('error', 'Vous n\'êtes pas autorisé à créer un projet.');
        }

        // Récupération des utilisateurs disponibles

        return view('projets.edit', compact('projet', 'users'));
    }


    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        //dd($request->all());

        try {
            Log::info("Début de la mise à jour du projet ID: $id");

            $projet = Projet::findOrFail($id);

            Log::info("Projet trouvé : " . $projet->nom);

            $request->validate([
                'nom' => 'required|string|max:255',
                'description' => 'required|string',
                'date_debut' => 'required|date',
                'date_fin' => 'required|date|after_or_equal:date_debut',
                'taches.*.id' => 'nullable|integer|exists:taches,id',
                'taches.*.nom' => 'nullable|string|max:255',
                'taches.*.description' => 'nullable|string',
                'taches.*.date_debut' => 'nullable|date',
                'taches.*.date_fin' => 'nullable|date|after_or_equal:taches.*.date_debut',
            ]);

            $projet->update([
                'nom' => $request->nom,
                'description' => $request->description,
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
            ]);
            Log::info("Projet mis à jour avec succès");
            $tacheIdsEnvoyes = [];
            $tachesReçues = $request->input('taches', []);
            Log::info("Nombre de tâches reçues : " . count($tachesReçues));

            foreach ($tachesReçues as $tacheData) {
                if (!empty($tacheData['nom'])) {
                    if (!empty($tacheData['id'])) {
                        $tache = Tache::find($tacheData['id']);
                        if ($tache && $tache->projet_id == $projet->id) {
                            $tache->update([
                                'nom' => $tacheData['nom'],
                                'description' => $tacheData['description'],
                                'date_debut' => $tacheData['date_debut'],
                                'date_fin' => $tacheData['date_fin'],
                            ]);
                            $tacheIdsEnvoyes[] = $tache->id;

                            Log::info("Tâche mise à jour : ID " . $tache->id);

                            if (!empty($tacheData['users'])) {
                                $tache->tacheRealiserUsers()->sync($tacheData['users']);
                            }
                        }
                    } else {
                        Log::info("Début de creation de tâche");
                        $nouvelleTache = new Tache([
                            'nom' => $tacheData['nom'],
                            'description' => $tacheData['description'],
                            'date_debut' => $tacheData['date_debut'],
                            'date_fin' => $tacheData['date_fin'],
                            'etat' => 'en cours',
                            'user_id' => auth()->id(), // créateur de la tâche
                            'projet_id' => $projet->id,
                        ]);
                        $nouvelleTache->save();

                        Log::info("Tâche créée avec ID : {$nouvelleTache->id} et projet_id : {$nouvelleTache->projet_id}");
                        $tacheIdsEnvoyes[] = $nouvelleTache->id;

                        if (!empty($tacheData['users'])) {
                            $nouvelleTache->tacheRealiserUsers()->sync($tacheData['users']);
                        }
                    }
                }
            }

            DB::commit();
            Log::info("Transaction complétée pour le projet ID: $id");

            return redirect()->route('taches.index')->with('success', 'Projet mis à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour : ' . $e->getMessage());
        }
    }



    public function destroy($id)
    {
        // Logic to delete the project
        return redirect()->route('projet.index');
    }
}
