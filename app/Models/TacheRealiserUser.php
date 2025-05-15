<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Tache;

class TacheRealiserUser extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'user_id',
        'tache_id',
    ];

    /**
     * Get the tache associated with the TacheRealiserUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tache()
    {
        return $this->belongsTo(Tache::class, 'tache_id');
    }
    /**
     * Get the user associated with the TacheRealiserUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
