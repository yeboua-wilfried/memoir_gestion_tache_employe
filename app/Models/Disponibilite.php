<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\MotifAbsence;
use App\Models\User;

class Disponibilite extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'date_demande',
        'etat_demande',
        'date_reponce_demande',

        'date_debut',
        'date_fin',
        'etat_disponibilite',
        'motif_abs_id',
        'user_demande_id',
    ];

    // Correction du type de relation et de la documentation
    public function motifAbsence(): BelongsTo
    {
        return $this->belongsTo(MotifAbsence::class, 'motif_abs_id');
    }

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
        return $this->belongsToMany(User::class, 'demande_user_table', 'user_id', 'disponibilite_id');
    }

    public function isExpired()
    {
        return $this->date_debut && now()->greaterThanOrEqualTo($this->date_debut);
    }

}
