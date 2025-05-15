<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Tache;

class TypeTache extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
    ];
    /**
     * Get all of the taches for the TypeTache
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function taches()
    {
        return $this->hasMany(Tache::class);
    }
}
