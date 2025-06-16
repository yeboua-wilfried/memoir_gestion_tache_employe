<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\RelanceDemandes;

use App\Console\Commands\MettreUtilisateursAbsent;
use Illuminate\Support\Facades\Schedule;

Schedule::command(RelanceDemandes::class)->daily(); // ou ->everySixHours(), ->hourly(), etc.

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Schedule::command(MettreUtilisateursAbsent::class)->everyFifteenMinutes(); // ou ->hourly() si tu préfères
