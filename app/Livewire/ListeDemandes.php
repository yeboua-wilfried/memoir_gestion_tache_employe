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
            $employeIds = User::where('equipe_id', $user->equipe_id)->where('id', '!=', $user->id)->pluck('id');
        } elseif ($role === 'super_employe') {
            // Membres des équipes du même département
            $equipeIds = Equipe::where('departement_id', $user->equipe->departement_id)->pluck('id');
            $employeIds = User::whereIn('equipe_id', $equipeIds)->where('id', '!=', $user->id)->pluck('id');
        } elseif($role === 'super_employe_rh'){
            // RH, accès à tous les employés
            $employeIds = User::where('id', '!=', $user->id)->pluck('id');
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
            'etat' => 1
        ]);

        $demande = Demande::find($id);
        if (!$demande) {
            session()->flash('error', 'Demande introuvable.');
            return;
        }

        // Récupération de toutes les validations liées à cette demande
        $validations = DemandeUser::where('demande_id', $id)->get();

        if ($validations->count() >= 2) {
            // Vérifie s'il existe au moins un refus
            if ($validations->contains('etat', 0)) {
                $demande->etat_demande = 'refusée';
            } else {
                $demande->etat_demande = 'validée';
            }
        } else {
            $demande->etat_demande = 'en attente';
        }

        $demande->save();

        session()->flash('success', 'Votre validation a été enregistrée.');
    }
}