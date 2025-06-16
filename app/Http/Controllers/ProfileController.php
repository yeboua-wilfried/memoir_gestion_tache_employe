<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */


    public function edit(Request $request): View
    {
        $user = $request->user();
        $role = $user->poste->role ?? null;
        $superieurs = collect();

        if ($role === 'bottom_employe') {
            // PDG
            $pdg = User::whereHas('poste', fn($q) => $q->where('role', 'pdg'))->first();
            if ($pdg) {
                $superieurs->push($pdg);
            }

            // Chef de département
            $departementId = $user->equipe->departement_id ?? null;
            $chefDept = User::whereHas('poste', fn($q) => $q->whereIn('role', ['super_employe', 'super_employe_rh']))
                ->whereHas('equipe', fn($q) => $q->where('departement_id', $departementId))
                ->first();

            if ($chefDept) {
                $superieurs->push($chefDept);
            }

            // Chef d’équipe
            $chefEquipe = User::whereHas('poste', fn($q) => $q->where('role', 'medium_employe'))
                ->where('equipe_id', $user->equipe_id)
                ->first();

            if ($chefEquipe) {
                $superieurs->push($chefEquipe);
            }

        } elseif ($role === 'medium_employe') {
            // PDG
            $pdg = User::whereHas('poste', fn($q) => $q->where('role', 'pdg'))->first();
            if ($pdg) {
                $superieurs->push($pdg);
            }

            // Chef de département
            $departementId = $user->equipe->departement_id ?? null;
            $chefDept = User::whereHas('poste', fn($q) => $q->whereIn('role', ['super_employe', 'super_employe_rh']))
                ->whereHas('equipe', fn($q) => $q->where('departement_id', $departementId))
                ->first();

            if ($chefDept) {
                $superieurs->push($chefDept);
            }

        } elseif (in_array($role, ['super_employe', 'super_employe_rh'])) {
            // PDG
            $pdg = User::whereHas('poste', fn($q) => $q->where('role', 'pdg'))->first();
            if ($pdg) {
                $superieurs->push($pdg);
            }
        }

        return view('profile.edit', [
            'user' => $user,
            'superieurs' => $superieurs,
        ]);
    }


    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
