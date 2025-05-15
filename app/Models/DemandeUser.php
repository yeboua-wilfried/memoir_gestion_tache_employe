<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;
use App\Models\Demande;

class DemandeUser extends Model
{
    protected $table = 'demande_users'; // Nom de la table de liaison

    protected $fillable = [
        'user_id',
        'demande_id',
        'etat_demande',
        'date_reponce_demande',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function demande()
    {
        return $this->belongsTo(Demande::class, 'demande_id');
    }
}
