<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Demande extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'date_demande',

        'date_debut',
        'date_fin',
        'etat_disponibilite',
        'motif_absence',
        'user_id',
    ];

    // Correction du type de retour et de la documentation
    public function userDemande(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id'); // Correction du nom de clé
    }

    /**
     * The userVlide that belong to the Disponibilite
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userValide(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'demande_users', 'user_id', 'demande_id');
    }

    public function isExpired()
    {
        return $this->date_debut && now()->greaterThanOrEqualTo($this->date_debut);
    }
}
