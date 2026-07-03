<?php

namespace App\Mail;

use App\Models\Persona;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CorreoCumpleanos extends Mailable
{
    use Queueable, SerializesModels;

    public Persona $persona;

    public function __construct(Persona $persona)
    {
        $this->persona = $persona;
    }

    public function build()
    {
        return $this->subject('🎂 ¡Feliz cumpleaños!')
                    ->view('emails.cumpleanos');
    }
}