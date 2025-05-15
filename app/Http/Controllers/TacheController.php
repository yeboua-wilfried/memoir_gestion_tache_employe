<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TacheUser;
use App\Models\Tache;
use App\Models\User;


class TacheController extends Controller
{
    function index()
    {
        $users = User::all();
        $taches = Tache::with('user')->get();
        return view('taches.index')->with([
            'taches' => $taches,
            'users' => $users,
        ]);
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
        $typesTache = TypeTache::all();
        $users = Auth::user();
        return view('taches.create')->with([
            'typesTache' => $typesTache,
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'etat' => 'required|in:en_cours,terminee,annulee',
            'user_id' => 'required|exists:users,id',
            'type_tache_id' => 'required|exists:type_taches,id',
        ]);

        // 1. Création de la tâche principale
        $tache = Tache::create($request->all());

        // 2. Si le type de tâche est 1, enregistrer les sous-tâches
        if ((int)$request->type_tache_id === 2 && $request->has('sous_taches')) {
            foreach ($request->sous_taches as $sousTacheData) {
                $request->validate([
                    "sous_taches.*.nom" => "required|string|max:255",
                    "sous_taches.*.description" => "required|string|max:1000",
                    "sous_taches.*.date_debut" => "required|date",
                    "sous_taches.*.date_fin" => "required|date|after_or_equal:sous_taches.*.date_debut",
                    "sous_taches.*.etat" => "required|in:en_attente,en_cours,terminee"
                ]);

                SousTache::create([
                    'nom' => $sousTacheData['nom'],
                    'description' => $sousTacheData['description'],
                    'date_debut' => $sousTacheData['date_debut'],
                    'date_fin' => $sousTacheData['date_fin'],
                    'etat' => $sousTacheData['etat'],
                    'tache_id' => $tache->id
                ]);
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
        // Logique pour afficher le formulaire d'édition d'une tâche
    }
    function update(Request $request, $id)
    {
        // Logique pour mettre à jour une tâche existante
    }
    function destroy($id)
    {
        // Logique pour supprimer une tâche
    }

    public function valider(Tache $tache)
    {
        $tache->etat = 'terminer';
        $tache->save();

        return redirect()->back()->with('success', 'Tâche validée avec succès.');
    }

}
