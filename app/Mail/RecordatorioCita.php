<?php

namespace App\Mail;

use App\Models\Cita;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class RecordatorioCita extends Mailable
{
    use Queueable, SerializesModels;

    public Cita $cita;

    public function __construct(Cita $cita)
    {
        $this->cita = $cita;
    }

    public function build()
    {
        $urlConfirmar = URL::temporarySignedRoute(
            'citas.confirmar.publico',
            now()->addDays(2), 
            ['cita' => $this->cita->idCita]
        );

        $urlCancelar = URL::temporarySignedRoute(
            'citas.cancelar.publico',
            now()->addDays(2),
            ['cita' => $this->cita->idCita]
        );

        return $this->view('emails.recordatorio-cita')
            ->with([
                'cita' => $this->cita,
                'urlConfirmar' => $urlConfirmar,
                'urlCancelar' => $urlCancelar,
            ]);
    }


}