<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TacheUser;
use App\Models\Tache;
use App\Models\User;
use App\Models\Equipe;


class TacheController extends Controller
{
    function index()
    {
        $user = Auth::user();
        $role = $user->poste->role;

        if ($role === 'medium_employe') {
            // Récupérer les utilisateurs de la même équipe
            $employes = User::where('equipe_id', $user->equipe_id)->pluck('id');
        } elseif ($role === 'super_employe') {
            // Récupérer les IDs des équipes du même département
            $equipeIds = Equipe::where('departement_id', $user->equipe->departement_id)->pluck('id');

            // Récupérer les utilisateurs appartenant à ces équipes
            $employes = User::whereIn('equipe_id', $equipeIds)->pluck('id');
        } elseif ($role === 'pdg' || $role === 'admin'){
            $employes = User::pluck('id');
        } else {
            // Si ce n'est ni l'un ni l'autre, rediriger ou afficher rien
            return redirect()->back()->with('error', "Accès non autorisé.");
        }

        // Récupérer les tâches assignées à ces employés
        $tacheIds = TacheUser::whereIn('user_id', $employes)->pluck('tache_id');
        $taches = Tache::with('user')->whereIn('id', $tacheIds)->get();

        return view('taches.index', compact('taches'));
    }

    function indexUser()
    {
        $user = Auth::user();

        // On récupère tous les liens entre l'utilisateur et ses tâches
        $tacheUsers = TacheUser::where('user_id', $user->id)->get();

        // On extrait tous les IDs des tâches
        $tacheIds = $tacheUsers->pluck('tache_id');

        // On récupère toutes les tâches correspondant à ces IDs
        $taches = Tache::whereIn('id', $tacheIds)->get();

        return view('taches.user.index')->with([
            'taches' => $taches,
            'user' => $user,
            'tacheUsers' => $tacheUsers,
        ]);
    }

    function create()
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

        return view('taches.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->input('taches');

        foreach ($data as $tacheData) {
            // Création de la tâche
            $tache = new Tache();
            $tache->nom = $tacheData['nom'];
            $tache->description = $tacheData['description'];
            $tache->date_debut = $tacheData['date_debut'];
            $tache->date_fin = $tacheData['date_fin'];
            $tache->projet_id = null; // tâche principale
            $tache->user_id = auth()->id();
            $tache->save();

            // Affectation des utilisateurs (via la table pivot tache_user)
            if (!empty($tacheData['users'])) {
                $tache->tacheRealiserUsers()->attach($tacheData['users']);
            }
        }
        return redirect()->route('taches.index')->with('success', 'Tâche créée avec succès.');
    }

    function show($id)
    {
        $tache = Tache::with('annexes')->findOrFail($id);
        return view('taches.show', compact('tache'));
    }

    public function travail($id)
    {
        $tache = Tache::findOrFail($id);
        return view('taches.travail', compact('tache'));
    }

    function edit($id)
    {
        $user = auth()->user();
        $role = $user->poste->role;

        if (!in_array($role, ['medium_employe', 'super_employe_rh', 'super_employe', 'pdg', 'admin'])) {
            return redirect()->route('home')->with('error', 'Vous n\'êtes pas autorisé à modifier ce projet.');
        }

        // Récupération du projet
        $tache = Tache::findOrFail($id);

        // Chargement des relations tâches + utilisateurs
        $tache->load('tacheRealiserUsers');

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
            return redirect()->route('home')->with('error', 'Vous n\'êtes pas autorisé à créer un tache.');
        }

        // Récupération des utilisateurs disponibles

        return view('taches.edit', compact('tache', 'users'));
    }
    public function update(Request $request, $id)
    {
        $tache = Tache::findOrFail($id);

        // Validation (optionnelle mais recommandée)
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        // Mise à jour des champs
        $tache->nom = $request->input('nom');
        $tache->description = $request->input('description');
        $tache->date_debut = $request->input('date_debut');
        $tache->date_fin = $request->input('date_fin');
        $tache->save();

        // Mise à jour des utilisateurs assignés
        // On récupère les utilisateurs sélectionnés depuis le formulaire
        $users = $request->input('taches.0.users', []);
        $tache->tacheRealiserUsers()->sync($users);

        return redirect()->route('taches.index')->with('success', 'Tâche modifiée avec succès.');
    }

    public function destroy($id)
    {
        $tache = Tache::findOrFail($id);

        // Détacher les relations avec les utilisateurs si la table pivot est utilisée
        $tache->tacheRealiserUsers()->detach();

        // Supprimer la tâche
        $tache->delete();

        return redirect()->route('taches.index')->with('success', 'Tâche supprimée avec succès.');
    }


    public function valider(Tache $tache)
    {
        // Met à jour l'état de la tâche
        $tache->etat = 'terminee';
        $tache->save();

        // Vérifie si toutes les tâches du projet sont terminées
        if ($tache->projet) {
            $toutesTerminees = $tache->projet->taches()->where('etat', '!=', 'terminee')->doesntExist();

            //dd($toutesTerminees);

            if ($toutesTerminees) {
                $tache->projet->etat = 'terminee';
                $tache->projet->save();
            }
        }

        return redirect()->route('taches.user.index')->with('success', 'Tâche validée avec succès.');
    }
}
