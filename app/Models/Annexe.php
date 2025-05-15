<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Tache;

class Annexe extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'description', 'repertoire', 'type', 'taille', 'tache_id'];

    public function tache()
    {
        return $this->belongsTo(Tache::class, 'tache_id');
    }
}
