<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poste;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PosteController extends Controller
{
    public function index()
    {
        $postes = Poste::all();
        return view('postes.index', compact('postes'));
    }

    public function create()
    {
        return view('postes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_poste' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'role' => 'required|in:admin,pdg,super_employe,super_employe_rh,medium_employe,bottom_employe',
        ]);

        Poste::create($validated);

        return redirect()->route('postes.index')->with('success', 'Poste ajouté avec succès.');
    }

    public function edit(Poste $poste)
    {
        return view('postes.edit', compact('poste'));
    }

    public function update(Request $request, Poste $poste)
    {
        $validated = $request->validate([
            'nom_poste' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'role' => 'required|in:admin,super_employe,medium_employe,bottom_employe',
        ]);

        $poste->update($validated);

        return redirect()->route('postes.index')->with('success', 'Poste mis à jour avec succès.');
    }
}
