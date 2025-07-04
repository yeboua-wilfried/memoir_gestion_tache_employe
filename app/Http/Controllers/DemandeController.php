<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande;
use App\Models\DemandeUser;

class DemandeController extends Controller
{
    public function index()
    {
        $demandes = Demande::where('user_id', auth()->id())->get();

        foreach ($demandes as $demande) {
            if ($demande->etat_demande != 'expirée' && $demande->isExpired()) {
                $demande->etat_demande = 'expirée';
                $demande->save();
            }
        }

        return view('demandes.index', compact('demandes'));
    }

    public function indexUser()
    {
        $demandes = Demande::where('user_id', auth()->id())->get();

        foreach ($demandes as $demande) {
            if ($demande->etat_demande != 'expirée' && $demande->isExpired()) {
                $demande->etat_demande = 'expirée';
                $demande->save();
            }
        }
        
        $user = auth()->user();
        $demandeUsers = DemandeUser::all();
        $demandes = Demande::where('user_id', $user->id)->get();

        return view('demandes.user.index', compact('demandes'));
    }

    public function create()
    {
        return view('demandes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            //'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'motif_abs' => 'required|string|max:255',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
        ]);

        Demande::create([
            'nom' => 'Demande de ' . $request->motif_abs . ' de ' . auth()->user()->name,
            'description' => $request->description,
            'date_demande' => now(),
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'etat_demande' => 'en attente',
            'motif_absence' => $request->motif_abs,
            'user_id' => auth()->id(),
        ]);


        // Récupération des supérieurs
        /*$user = auth()->user();
        $equipe = $user->equipe;
        $departement = $equipe->departement ?? null;

        $chefs = collect();

        if ($equipe) {
            $chefEquipe = $equipe->users()->where('poste_id', 5)->first();
            if ($chefEquipe) $chefs->push($chefEquipe);
        }

        if ($departement) {
            $chefDept = $departement->users()->where('poste_id', 6)->first();
            if ($chefDept) $chefs->push($chefDept);
        }

        // Ajouter les RHs (poste_id == rh par exemple)
        $rhs = User::where('poste_id', 6)->where('equipe_id', 7)->get();

        $chefs = $chefs->merge($rhs);

        // Envoyer la notification
        foreach ($chefs as $superieur) {
            DemandeUser::create([
                'user_id' => $superieur->id,
                'type' => 'demande',
                'message' => 'Nouvelle demande d\'indisponibilité de ' . $user->name,
                'sent_at' => now(),
            ]);
        }*/

        return redirect()->route('demande.user.index', auth()->id())->with('success', 'Demande envoyée avec succès.');
    }

    public function show($id)
    {
        // Logic to display a specific demande
        return view('demandes.show', compact('id'));
    }

    public function edit($id)
    {
        // Logic to show the form for editing a specific demande
        return view('demandes.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Logic to update a specific demande
        // Validate and update the demande data
        return redirect()->route('demandes.index')->with('success', 'Demande updated successfully.');
    }

    public function destroy($id)
    {
        // Logic to delete a specific demande
        return redirect()->route('demandes.index')->with('success', 'Demande deleted successfully.');
    }
}
