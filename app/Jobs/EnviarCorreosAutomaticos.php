<?php

namespace App\Jobs;

use App\Mail\CorreoCumpleanos;
use App\Mail\RecordatorioCita;
use App\Models\Cita;
use App\Models\Persona;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EnviarCorreosAutomaticos implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $hoy = Carbon::now();


        // CUMPLEAÑOS

        Persona::whereMonth('fechaNacimiento', $hoy->month)
            ->whereDay('fechaNacimiento', $hoy->day)
            ->whereNotNull('correo')
            ->each(function ($persona) {

                Mail::to($persona->correo)
                    ->send(new CorreoCumpleanos($persona));
            });


        // RECORDATORIO DE CITAS (24 HORAS ANTES APROXIMADO)


        $inicio = Carbon::now()->addHours(24);
        $fin = Carbon::now()->addHours(25);

        $inicioStr = $inicio->format('Y-m-d H:i:s');
        $finStr = $fin->format('Y-m-d H:i:s');

        Cita::with('odontologo.persona')
            ->whereNull('recordatorioCorreoEnviadoAt')
            ->get()
            ->filter(function ($cita) {

                $fechaHora = Carbon::parse($cita->fecha . ' ' . $cita->hora);

                return $fechaHora->between(
                    now()->addHours(24),
                    now()->addHours(25)
                );
            })
            ->each(function ($cita) {

                Mail::to($cita->correo)
                    ->send(new RecordatorioCita($cita));

                $cita->recordatorioCorreoEnviadoAt = now();
                $cita->save();
            });

    }
}