<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tache;
use App\Models\Projet;

class ProjetTaches extends Component
{
    public $search = '';

    public function render()
    {
        $tachesSimples = Tache::whereNull('projet_id')
            ->where('nom', 'like', '%'.$this->search.'%')
            ->latest()
            ->get();

            $projets = Projet::with(['taches' => function($query) {
                $query->orderBy('created_at', 'desc')->with('tacheRealiserUsers');
            }])
            ->where('nom', 'like', '%'.$this->search.'%')
            ->latest()
            ->get();

        return view('livewire.projet-taches', [
            'tachesSimples' => $tachesSimples,
            'projets' => $projets,
        ]);
    }
}
