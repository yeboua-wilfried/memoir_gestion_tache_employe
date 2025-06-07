<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Departement;
use App\Models\Equipe;
use App\Models\User;

class EquipeIndex extends Component
{
    public $departementId = '';
    public $showUsers = [];

    public function render()
    {
        $user = Auth::user();
        $poste = $user->poste_id;

        // On limite les équipes visibles selon le rôle de l'utilisateur
        if ($poste === 5) {
            // Équipe de l'utilisateur seulement
            $equipes = Equipe::where('id', $user->equipe_id);
        } elseif ($poste === 6) {
            // Équipes du même département
            $equipes = Equipe::where('departement_id', $user->equipe->departement_id);
        } elseif (in_array($poste, [1, 2])) {
            // Toutes les équipes
            $equipes = Equipe::query();
        } else {
            // Accès non autorisé
            return view('livewire.equipe-index', [
                'equipes' => collect(),
                'departements' => Departement::all(),
            ]);
        }

        // Si un département est sélectionné, filtrer par celui-ci
        if (!empty($this->departementId)) {
            $equipes->where('departement_id', $this->departementId);
        }

        $equipes = $equipes->with(['users' => function ($query) {
            // Exclure les utilisateurs ayant quitté l'équipe
            $query->where('disponibilite_user', '!=', 'départ');
        }, 'departement'])->get();

        return view('livewire.equipe-index', [
            'equipes' => $equipes,
            'departements' => Departement::all(),
        ]);
    }

    public function toggleUsers($equipeId)
    {
        $this->showUsers[$equipeId] = !($this->showUsers[$equipeId] ?? false);
    }

    public function confirmDelete($equipeId)
    {
        $equipe = Equipe::find($equipeId);
        $equipe->delete();
        session()->flash('message', 'Équipe supprimée avec succès.');
    }
}
