<?php

namespace App\Mail;

use App\Models\Pago;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;

class ReciboMail extends Mailable
{
    use Queueable, SerializesModels;

    public Pago $pago;

    public function __construct(Pago $pago)
    {
        $this->pago = $pago;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recibo REC-' . str_pad($this->pago->idPago, 6, '0', STR_PAD_LEFT),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.recibo',
        );
    }

    public function build()
    {
        $pagos = Pago::with([
            'factura.consulta.paciente.persona',
            'factura.consulta.odontologo.persona',
            'metodoPago',
            'usuario.persona',
        ])
        ->where('codigoRecibo', $this->pago->codigoRecibo)
        ->orderBy('numeroCuota')
        ->get();

        $factura = $pagos->first()->factura;

        $pdf = Pdf::loadView('pagos.pdf', compact(
            'pagos',
            'factura'
        ));

        $pdf->setPaper([0, 0, 612, 396]);

        return $this
            ->subject('Recibo REC-' . str_pad($this->pago->idPago, 6, '0', STR_PAD_LEFT))
            ->view('emails.recibo')
            ->attachData(
                $pdf->output(),
                'REC-' . str_pad($this->pago->idPago, 6, '0', STR_PAD_LEFT) . '.pdf',
                [
                    'mime' => 'application/pdf',
                ]
            );
    }
}
