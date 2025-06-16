<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Tache;
use App\Models\Projet;
use App\Models\Equipe;

class ProjetTaches extends Component
{
    protected $listeners = ['deleteProjetWithTaches', 'deleteProjetOnly'];

    public $search = '';

    public function render()
    {
        $user = Auth::user();
        $role = $user->poste->role;

        // Récupération des IDs des employés accessibles selon le poste
        if ($role === 'medium_employe') {
            // Membres de la même équipe
            $employeIds = User::where('equipe_id', $user->equipe_id)->pluck('id');
        } elseif ($role === 'super_employe') {
            // Membres des équipes du même département
            $equipeIds = Equipe::where('departement_id', $user->equipe->departement_id)->pluck('id');
            $employeIds = User::whereIn('equipe_id', $equipeIds)->pluck('id');
        } elseif ($role === 'pdg' || $role === 'admin') {
            // Tous les utilisateurs
            $employeIds = User::pluck('id');
        } else {
            // Accès interdit
            $employeIds = collect(); // Liste vide
        }

        // Tâches simples (sans projet) assignées aux employés autorisés
        $tachesSimples = Tache::whereNull('projet_id')->whereIn('user_id', $employeIds)->where('nom', 'like', '%'.$this->search.'%')->latest()->get();

        // Projets avec leurs tâches dont les utilisateurs sont dans la liste
        $projets = Projet::where('nom', 'like', '%'.$this->search.'%')->whereHas('taches', function ($query) use ($employeIds) {
                $query->whereIn('user_id', $employeIds);
            })->with(['taches' => function($query) use ($employeIds) {
                $query->whereIn('user_id', $employeIds)->orderBy('created_at', 'desc')->with('tacheRealiserUsers');
            }])->latest()->get();

        return view('livewire.projet-taches', [
            'tachesSimples' => $tachesSimples,
            'projets' => $projets,
        ]);
    }

    public function deleteProjetWithTaches($id)
    {
        $projet = Projet::findOrFail($id);
        DB::transaction(function () use ($projet) {
            $projet->taches()->delete(); // supprime les tâches
            $projet->delete(); // supprime le projet
        });
    }

    public function deleteProjetOnly($id)
    {
        $projet = Projet::findOrFail($id);
        DB::transaction(function () use ($projet) {
            $projet->taches()->update(['projet_id' => null]);
            $projet->delete();
        });
    }

}
