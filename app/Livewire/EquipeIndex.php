<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Departement;
use App\Models\Equipe;

class EquipeIndex extends Component
{
    public $departementId = '';

    public function render()
    {
        $departements = Departement::all();

        $equipes = Equipe::with('departement')
            ->when($this->departementId, function ($query) {
                $query->where('departement_id', $this->departementId);
            })
            ->get();

        return view('livewire.equipe-index', [
            'equipes' => $equipes,
            'departements' => $departements,
        ]);
    }

    public $showUsers = [];

    public function toggleUsers($equipeId)
    {
        $this->showUsers[$equipeId] = !($this->showUsers[$equipeId] ?? false);
    }

    public function confirmDelete($equipeId)
    {
        // logiquement, tu affiches une modale de confirmation avant de supprimer
        $equipe = Equipe::find($equipeId);
        $equipe->delete();

        session()->flash('message', 'Équipe supprimée avec succès.');
    }

}
