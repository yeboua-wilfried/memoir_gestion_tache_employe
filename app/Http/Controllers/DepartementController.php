<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departement;
use App\Models\User;
use App\Models\Poste;

class DepartementController extends Controller
{
    public function index()
    {
        // Récupérer tous les départements avec leurs équipes et leurs chefs
        $departements = Departement::with('equipes.users')->get();

        // Ajouter le chef pour chaque département
        $departementsAvecChef = $departements->map(function ($departement) {
            // Filtrer les utilisateurs dont le poste_id est 6 et qui sont dans une équipe de ce département
            $chef = $departement->equipes->flatMap->users
                ->firstWhere('poste_id', 6);

            return [
                'id' => $departement->id,
                'nom' => $departement->nom,
                'description' => $departement->description,
                'chef' => $chef,
            ];
        });

        return view('departements.index', compact('departementsAvecChef'));
    }

    public function create()
    {
        return view('departements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        Departement::create($validated);

        return redirect()->route('departement.index')->with('success', 'Département ajouté avec succès.');
    }
}
