<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Equipe;

class EmployeTable extends Component
{
    public $search = '';
    public $equipe = '';

    public function render()
    {
        $equipes = Equipe::all();

        $employes = User::with(['poste', 'equipe'])
            ->when($this->search, fn($query) =>
                $query->where('name', 'like', '%'.$this->search.'%')
            )
            ->when($this->equipe, fn($query) =>
                $query->where('equipe_id', $this->equipe)
            )
            ->get();

        return view('livewire.employe-table', [
            'employes' => $employes,
            'equipes' => $equipes,
        ]);
    }
}
