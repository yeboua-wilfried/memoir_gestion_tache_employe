<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Departement;

class Equipe extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'description', 'departement_id'];

    /**
     * Une équipe peut avoir plusieurs utilisateurs.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'equipe_id');
    }

    /**
     * Get the departement that owns the equipe
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function departement(): BelongsTo
    {
        return $this->belongsTo(Departement::class, 'departement_id');
    }
}
