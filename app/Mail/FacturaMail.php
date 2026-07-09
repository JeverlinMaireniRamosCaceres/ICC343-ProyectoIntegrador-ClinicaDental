<?php

namespace App\Mail;

use App\Models\Factura;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class FacturaMail extends Mailable
{
    use Queueable, SerializesModels;

    public Factura $factura;

    public function __construct(Factura $factura)
    {
        $this->factura = $factura;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Factura FAC-' . str_pad($this->factura->idFactura, 6, '0', STR_PAD_LEFT),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.factura',
        );
    }

    public function build()
    {
        $this->factura->load([
            'consulta.paciente.persona',
            'consulta.odontologo.persona',
            'consulta.detalles.procedimiento',
            'pagos.metodoPago',
            'pagos.usuario.persona',
        ]);

        $pdf = Pdf::loadView('facturacion.pdf', [
            'factura' => $this->factura,
        ])->setPaper('letter');

        return $this
            ->subject('Factura FAC-' . str_pad($this->factura->idFactura, 6, '0', STR_PAD_LEFT))
            ->view('emails.factura')
            ->attachData(
                $pdf->output(),
                'Factura-' . $this->factura->idFactura . '.pdf',
                [
                    'mime' => 'application/pdf',
                ]
            );
    }
}
