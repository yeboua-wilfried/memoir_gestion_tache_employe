<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RelanceDemandes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:relance-demandes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $attenteDemandes = Disponibilite::where('etat_disponibilite', 'en attente')
            ->whereDate('created_at', '<=', now()->subDays(2))
            ->get();

        $rhs = User::where('poste_id', 'rh')->get();

        foreach ($attenteDemandes as $demande) {
            foreach ($rhs as $rh) {
                Notification::create([
                    'user_id' => $rh->id,
                    'type' => 'relance',
                    'message' => "Relance : la demande de {$demande->userDemande->name} n’a pas été traitée.",
                    'sent_at' => now(),
                ]);
            }
        }

        $this->info('Relances envoyées');
    }
}
