<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class MettreUtilisateursAbsent extends Command
{
    protected $signature = 'utilisateurs:mettre-absents';
    protected $description = 'Met tous les utilisateurs à absent entre 19h et 4h';

    public function handle()
    {
        $heure = now()->format('H');

        if ($heure >= 19 || $heure < 4) {
            User::query()->update(['presence_absence' => 'absent']);
            $this->info('Tous les utilisateurs ont été mis à absent.');
        } else {
            $this->info('Hors horaire. Aucune action.');
        }
    }
}
