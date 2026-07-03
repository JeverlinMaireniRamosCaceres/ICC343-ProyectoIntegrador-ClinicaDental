<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\EnviarCorreosAutomaticos;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('appointments:reminders')->hourly();

// para enviar los correos automaticos de cumpleaños y recordatorio de citas
Schedule::job(new EnviarCorreosAutomaticos)
    ->dailyAt('08:00')
    ->withoutOverlapping();