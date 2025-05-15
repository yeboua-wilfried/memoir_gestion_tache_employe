<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Equipe;

class Departement extends Model
{
    Use HasFactory;

    protected $fillable = ['nom', 'description'];

    /**
     * Get all of the equipes for the Departement
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function equipes(): HasMany
    {
        return $this->hasMany(Equipe::class, 'departement_id');
    }
}
