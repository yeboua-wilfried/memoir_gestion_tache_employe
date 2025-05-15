<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Poste;
use App\Models\Equipe;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $postes = Poste::all();
        $equipes = Equipe::all();

        return view('auth.register', [
            'postes' => $postes,
            'equipes' => $equipes,
        ]);
    }


    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
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
            //'disponibilite_user' => 'required|string',
            //'presence_absence' => 'required|string',
        ]);

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
            //'disponibilite_user' => $request->disponibilite_user,
            //'presence_absence' => $request->presence_absence,
        ]);


        event(new Registered($user));

        Auth::login($user);

        Log::info($request->all());

        return redirect(route('dashboard', absolute: false));
    }
}
