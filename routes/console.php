<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\RelanceDemandes;

Schedule::command(RelanceDemandes::class)->daily(); // ou ->everySixHours(), ->hourly(), etc.

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();
