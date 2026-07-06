<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\EnviarCorreosCumpleanos;
use App\Jobs\EnviarRecordatoriosCitas;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('appointments:reminders')->hourly();

// cumpleaños una sola vez al día
Schedule::job(new EnviarCorreosCumpleanos)
    ->dailyAt('08:00')
    ->withoutOverlapping();

// recordatorios de cita cada una hora
Schedule::job(new EnviarRecordatoriosCitas)
    ->hourly()
    ->withoutOverlapping();