<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Annexe;
use App\Models\TacheUser;
use App\Models\Projet;
use App\Models\Tache;

class Tache extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'date_debut',
        'date_fin',
        'etat',
        'user_id',//l'utilisateur qui est entrain de creer la tache
        'projet_id',
    ];

    /**
     * La tâche appartient à un seul utilisateur (directeur qui l'a créée).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * La tâche peut être réalisée par plusieurs employés.
     */
    public function tacheRealiserUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tache_users', 'tache_id', 'user_id');
    }

    /**
     * La tâche appartient à un seul projet.
     */
    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class, 'projet_id');
    }

    /**
     * Get all of the annexes for the Tache
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function annexes(): HasMany
    {
        return $this->hasMany(Annexe::class);
    }
}
