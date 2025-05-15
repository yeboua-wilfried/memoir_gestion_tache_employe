<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipe;
use App\Models\Departement;

class EquipeController extends Controller
{
    public function index()
    {
        $equipes = Equipe::all();
        return view('equipes.index', compact('equipes'));
    }

    public function create()
    {
        $departements = Departement::all();
        return view('equipes.create', compact('departements'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'departement_id' => 'required|exists:departements,id',
        ]);

        Equipe::create($validated);

        return redirect()->route('equipes.index')->with('success', 'Équipe ajoutée avec succès.');
    }
}
