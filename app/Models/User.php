<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Poste;
use App\Models\Equipe;
use App\Models\Tache;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'prenom',
        'email',
        'password',
        'date_naissance',
        'lieu_naissance',
        'nationalite',
        'situation_matrimoniale',
        'nombre_enfants',
        'adresse',
        'telephone',
        'sexe',
        'cni',
        'salaire',
        'date_debut_contrat',
        'date_fin_contrat',
        'poste_id',
        'equipe_id',
        'disponibilite_user',
        'presence_absence',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Un employé appartient à un seul poste.
     */
    public function poste(): BelongsTo
    {
        return $this->belongsTo(Poste::class, 'poste_id');
    }

    /**
     * Un employé appartient à une seule équipe.
     */
    public function equipe(): BelongsTo
    {
        return $this->belongsTo(Equipe::class, 'equipe_id');
    }

    /**
     * Un utilisateur (directeur) peut créer plusieurs tâches.
     */
    public function tachesCrees(): HasMany
    {
        return $this->hasMany(Tache::class, 'user_id');
    }

    /**
     * Un employé peut être assigné à plusieurs tâches.
     */
    public function tacheRealiserUsers(): BelongsToMany
    {
        return $this->belongsToMany(Tache::class, 'tache_users', 'user_id', 'tache_id');
    }

    // Correction du nom de clé étrangère (demende -> demande)
    public function demandes(): HasMany
    {
        return $this->hasMany(Demande::class, 'user_id'); // Correction de 'demende' à 'demande'
    }

    /**
     * The demandeValide that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function demandeValide(): BelongsToMany
    {
        return $this->belongsToMany(Demande::class, 'demande_users', 'user_id', 'demande_id');
    }

    /**
     * Get all of the notification for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notification(): HasMany
    {
        return $this->hasMany(Notification::class);
    }
}
