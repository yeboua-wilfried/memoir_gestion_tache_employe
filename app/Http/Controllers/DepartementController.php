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
        // Récupérer tous les départements avec leurs équipes et les utilisateurs de ces équipes
        $departements = Departement::with('equipes.users.poste')->get();

        // Ajouter le chef pour chaque département
        $departementsAvecChef = $departements->map(function ($departement) {
            // Rechercher un utilisateur ayant un poste avec un rôle spécifique
            $chef = $departement->equipes
                ->flatMap->users
                ->first(function ($user) {
                    return in_array(optional($user->poste)->role, [
                        'super_employe',
                        'super_employe_rh',
                        'super_employe_info'
                    ]);
                });

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

        return redirect()->route('departements.index')->with('success', 'Département ajouté avec succès.');
    }

    public function edit($id)
    {
        $departement = Departement::findOrFail($id);
        return view('departements.edit', compact('departement'));
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $departement = Departement::findOrFail($id);
        $departement->update($validated);

        return redirect()->route('departements.index')->with('success', 'Département mis à jour avec succès.');
    }
    public function destroy($id)
    {
        $departement = Departement::findOrFail($id);
        $departement->delete();

        return redirect()->route('departements.index')->with('success', 'Département supprimé avec succès.');
    }
}
