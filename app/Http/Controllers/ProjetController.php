<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tache;
use App\Models\Projet;
use App\Models\TacheUser;
use Illuminate\Support\Facades\DB;

class ProjetController extends Controller
{
    public function index()
    {
        return view('projets.index');
    }

    public function create()
    {
        $users = User::all();
        return view('projets.create', compact('users'));

    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Création du projet
            $projet = Projet::create([
                'nom' => $request->nom,
                'description' => $request->description,
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
                'etat' => 'en_cours',
            ]);

            // Création des tâches liées au projet
            foreach ($request->taches ?? [] as $tacheData) {
                $tache = new Tache([
                    'nom' => $tacheData['nom'],
                    'description' => $tacheData['description'],
                    'date_debut' => $tacheData['date_debut'],
                    'date_fin' => $tacheData['date_fin'],
                    'etat' => 'en_cours',
                    'user_id' => auth()->id(), // créateur de la tâche
                    'projet_id' => $projet->id,
                ]);
                $tache->save();

                // Enregistrement des utilisateurs assignés
                if (!empty($tacheData['users'])) {
                    foreach ($tacheData['users'] as $userId) {
                        TacheUser::create([
                            'user_id' => $userId,
                            'tache_id' => $tache->id,
                        ]);
                    }
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
        return view('projet.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Logic to update the project
        return redirect()->route('projet.index');
    }

    public function destroy($id)
    {
        // Logic to delete the project
        return redirect()->route('projet.index');
    }
}
