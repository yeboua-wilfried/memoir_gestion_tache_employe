<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Poste;
use App\Models\Equipe;

class EmployeController extends Controller
{
    function index()
    {
        $employes = User::all();
        $equipes = Equipe::all();
        $postes = Poste::all();
        $employes = User::with(['poste', 'equipe'])->get();
        return view('employes.index', compact('employes'));
    }

    function create()
    {
        $postes = Poste::all();
        $equipes = Equipe::all();

        return view('auth.register', [
            'postes' => $postes,
            'equipes' => $equipes,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'prenom' => ['required','string','max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string',
            'nationalite' => 'required|string',
            'situation_matrimoniale' => 'required|string',
            'nombre_enfants' => 'required|integer',
            'adresse' => 'required|string',
            'telephone' => 'required|string',
            'sexe' => 'required|string',
            'cni' => 'required|string',
            'salaire' => 'required|numeric',
            'date_debut_contrat' => 'required|date',
            'date_fin_contrat' => 'nullable|date',
            'poste_id' => 'required|integer|exists:postes,id',
            'equipe_id' => 'required|integer|exists:equipes,id',
        ]);

        $poste = Poste::find($request->poste_id);
        $equipe = Equipe::find($request->equipe_id);

        // Règle 1 : Un seul chef par équipe
        if ($poste->isMediumEmploye()) {
            $chefEquipeExiste = User::where('poste_id', $poste->id)->where('equipe_id', $equipe->id)>exists();

            if ($chefEquipeExiste) {
                return back()->withErrors(['equipe_id' => 'Cette équipe a déjà un chef d\'équipe.'])->withInput();
            }
        }

        // Règle 2 : Un seul chef de département par département
        if ($poste->isSuperEmploye() || $poste->isSuperEmployeRh() || $poste->isSuperEmployeInfo()) {
            $chefDepartementExiste = User::where('poste_id', $poste->id)->whereHas('equipe', function ($query) use ($equipe) {
                    $query->where('departement_id', $equipe->departement_id);
                })
                ->exists();

            if ($chefDepartementExiste) {
                return back()->withErrors(['equipe_id' => 'Ce département a déjà un chef de département.'])->withInput();
            }
        }

        if ($poste-> ispdg()) {
            $chefPdgExiste = User::where($poste->$role, 'pdg')->exists();

            if ($chefPdgExiste) {
                return back()->withErrors(['poste_id' => 'Il y a déjà un PDG.'])->withInput();
            }
        }

        $user = User::create([
            'name' => $request->name,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'date_naissance' => $request->date_naissance,
            'lieu_naissance' => $request->lieu_naissance,
            'nationalite' => $request->nationalite,
            'situation_matrimoniale' => $request->situation_matrimoniale,
            'nombre_enfants' => $request->nombre_enfants,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone,
            'sexe' => $request->sexe,
            'cni' => $request->cni,
            'salaire' => $request->salaire,
            'date_debut_contrat' => $request->date_debut_contrat,
            'date_fin_contrat' => $request->date_fin_contrat,
            'poste_id' => $request->poste_id,
            'equipe_id' => $request->equipe_id,
        ]);

        return redirect('liste_employe')->with('success', 'Employé ajouté avec succès.');
    }

    function show($id)
    {
        // Logique pour afficher les détails d'un employé
    }
    function edit($id)
    {
        return view('employes.edit', [
            'employe' => User::findOrFail($id),
            'postes' => Poste::all(),
            'equipes' => Equipe::all(),
        ]);
    }
    function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string',
            'nationalite' => 'required|string',
            'situation_matrimoniale' => 'required|string',
            'nombre_enfants' => 'required|integer',
            'adresse' => 'required|string',
            'telephone' => 'required|string',
            'sexe' => 'required|string',
            'cni' => 'required|string',
            'salaire' => 'required|numeric',
            'date_debut_contrat' => 'required|date',
            'date_fin_contrat' => 'nullable|date',
            'poste_id' => 'required|integer|exists:postes,id',
            'equipe_id' => 'required|integer|exists:equipes,id',
        ]);

        $poste = Poste::find($request->poste_id);
        $equipe = Equipe::find($request->equipe_id);

        // Règle 1 : Un seul chef par équipe
        if ($poste->isMediumEmploye()) {
            $chefEquipeExiste = User::where('poste_id', $poste->id)
                ->where('equipe_id', $equipe->id)
                ->exists();

            if ($chefEquipeExiste) {
                return back()->withErrors(['equipe_id' => 'Cette équipe a déjà un chef d\'équipe.'])->withInput();
            }
        }

        // Règle 2 : Un seul chef de département par département
        if ($poste->isSuperEmploye() || $poste->isSuperEmployeRh() || $poste->isSuperEmployeInfo()) {
            $chefDepartementExiste = User::where('poste_id', $poste->id)
                ->whereHas('equipe', function ($query) use ($equipe) {
                    $query->where('departement_id', $equipe->departement_id);
                })
                ->exists();

            if ($chefDepartementExiste) {
                return back()->withErrors(['equipe_id' => 'Ce département a déjà un chef de département.'])->withInput();
            }
        }

        if ($poste-> ispdg()) {
            $chefPdgExiste = User::where($poste->$role, 'pdg')->exists();

            if ($chefPdgExiste) {
                return back()->withErrors(['poste_id' => 'Il y a déjà un PDG.'])->withInput();
            }
        }

        $user = User::findOrFail($id);
        $user->update($request->all());

        return redirect()->route('employes.index')->with('success', 'Utilisateur mis à jour.');
    }

    function destroy($id)
    {
        // Récupère l'utilisateur
        $user = User::findOrFail($id);

        // Supprime l'utilisateur
        $user->delete();

        // Redirige avec un message de succès
        return redirect()->route('employes.index')->with('success', 'Utilisateur supprimé avec succès.');

    }
}
