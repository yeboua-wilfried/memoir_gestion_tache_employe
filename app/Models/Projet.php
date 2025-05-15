<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Tache;
use App\Models\User;
use App\Models\TacheUser;
use App\Models\Projet;

class Projet extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'date_debut',
        'date_fin',
        'etat',
    ];

    /**
     * Le projet peut avoir plusieurs tâches.
     */
    public function taches()
    {
        return $this->hasMany(Tache::class);
    }
}
