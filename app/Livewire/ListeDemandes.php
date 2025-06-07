<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\DemandeUser;
use App\Models\Demande;
use App\Models\User;
use App\Models\Equipe;

class ListeDemandes extends Component
{
    public $search = '';
    public $all = false;

    public function render()
    {
        $user = Auth::user();
        $role = $user->poste->role;

        // Récupération des IDs des utilisateurs accessibles selon le poste
        if ($role === 'medium_employe') {
            // Membres de la même équipe
            $employeIds = User::where('equipe_id', $user->equipe_id)->pluck('id');
        } elseif ($role === 'super_employe' || $role === 'super_employe_rh') {
            // Membres des équipes du même département
            $equipeIds = Equipe::where('departement_id', $user->equipe->departement_id)->pluck('id');
            $employeIds = User::whereIn('equipe_id', $equipeIds)->pluck('id');
        } elseif ($role === 'pdg') {
            if ($this->all) {
                // Afficher toutes les demandes
                $employeIds = User::pluck('id');
            } else {
                // Seulement les super_employe (chefs de département)
                $employeIds = User::whereHas('poste', function ($query) {
                    $query->where('role', 'super_employe');
                })->pluck('id');
            }
        } elseif ($role === 'admin') {
            $employeIds = User::pluck('id');
        }else {
            // Aucun utilisateur accessible
            $employeIds = collect();
        }

        // Récupération des demandes faites par les utilisateurs autorisés
        $demandes = Demande::with(['userDemande', 'userValide'])
            ->whereIn('user_id', $employeIds)
            ->whereHas('userDemande', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->get();

        return view('livewire.liste-demandes', compact('demandes'));
    }
    public function toggleAllDemandes()
    {
        $this->all = !$this->all;
    }

    public function validerDemande($id)
    {
        $userId = auth()->id();

        // Vérifie si l'utilisateur a déjà validé cette demande
        $exists = DemandeUser::where('user_id', $userId)
            ->where('demande_id', $id)
            ->exists();

        if ($exists) {
            session()->flash('error', 'Vous avez déjà validé cette demande.');
            return;
        }

        // Enregistre la validation dans la table pivot
        DemandeUser::create([
            'user_id' => $userId,
            'demande_id' => $id,
            'etat'=> 1
        ]);

        // Nombre total de validations pour cette demande
        $validationCount = DemandeUser::where('demande_id', $id)->count();

        $demande = Demande::find($id);
        if (!$demande) {
            session()->flash('error', 'Demande introuvable.');
            return;
        }

        // Mise à jour de l'état selon le nombre de validations
        if ($validationCount >= 2) {
            $demande->etat_demande = 'validée';
        } else {
            $demande->etat_demande = 'en attente de la validation RH';
        }

        $demande->save();

        session()->flash('success', 'Votre validation a été enregistrée.');
    }

    public function refuserDemande(){
        $userId = auth()->id();

        // Vérifie si l'utilisateur a déjà refusé cette demande
        $exists = DemandeUser::where('user_id', $userId)
            ->where('demande_id', $id)
            ->exists();

        if ($exists) {
            session()->flash('error', 'Vous avez déjà refusé cette demande.');
            return;
        }

        // Enregistre le refus dans la table pivot
        DemandeUser::create([
            'user_id' => $userId,
            'demande_id' => $id,
            'etat' => 0
        ]);

        // Mise à jour de l'état de la demande
        $demande = Demande::find($id);
        if (!$demande) {
            session()->flash('error', 'Demande introuvable.');
            return;
        }

        $demande->etat_demande = 'en attente de la validation RH';
        $demande->save();

        session()->flash('success', 'Votre refus a été enregistré.');
    }
}
