<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Poste extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_poste',
        'description',
        'role',
    ];

    /**
     * Get the users associated with the poste.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }


    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isSuperEmploye()
    {
        return $this->role === 'super_employe';
    }

    public function isMediumEmploye()
    {
        return $this->role === 'medium_employe';
    }

    public function isBottomEmploye()
    {
        return $this->role === 'bottom_employe';
    }
}
