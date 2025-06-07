<?php

namespace App\Livewire;

// App\Livewire\EmployeTable.php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Equipe;

class EmployeTable extends Component
{
    public $search = '';
    public $equipe = '';
    public $afficherAnciens = false;

    public function mount()
    {
        // Met à jour les disponibilités expirées à chaque chargement
        User::updateDisponibiliteContratExpiré();
    }

    public function toggleAnciens()
    {
        $this->afficherAnciens = !$this->afficherAnciens;
    }

    public function render()
    {
        $equipes = Equipe::all();

        $employes = User::with(['poste', 'equipe'])
            ->when(!$this->afficherAnciens, fn($query) =>
                $query->where('disponibilite_user', ['disponible', 'Indisponible'])
            )
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
