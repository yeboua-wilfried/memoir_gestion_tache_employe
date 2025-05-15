<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Demande;
use App\Models\DemandeUser;
use App\Models\User;

class ListeDemandes extends Component
{
    public $search = '';

    public function render()
    {
        $demandes = Demande::with(['userDemande', 'userValide'])
            ->whereHas('userDemande', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->get();

        return view('livewire.liste-demandes', compact('demandes'));
    }
}
