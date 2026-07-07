<?php

namespace App\Jobs;

use App\Mail\RecordatorioCita;
use App\Models\Cita;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EnviarRecordatoriosCitas implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
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