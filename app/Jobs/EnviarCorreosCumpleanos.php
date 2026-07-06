<?php

namespace App\Jobs;

use App\Mail\CorreoCumpleanos;
use App\Models\Persona;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EnviarCorreosCumpleanos implements ShouldQueue
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
        $hoy = Carbon::now();

        Persona::whereMonth('fechaNacimiento', $hoy->month)
            ->whereDay('fechaNacimiento', $hoy->day)
            ->whereNotNull('correo')
            ->each(function ($persona) {

                Mail::to($persona->correo)
                    ->send(new CorreoCumpleanos($persona));
            });
    }
}