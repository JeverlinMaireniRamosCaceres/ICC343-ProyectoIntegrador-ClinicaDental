<?php

namespace App\Services;

use App\Models\Cita;
use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    protected string $token;
    protected string $phoneNumberId;
    protected string $version;

    public function __construct()
    {
        $this->token = config('services.whatsapp.token');
        $this->phoneNumberId = config('services.whatsapp.phone_number_id');
        $this->version = config('services.whatsapp.version');
    }

    /**
     * Envía un mensaje de texto.
     * Solo funciona si existe una conversación abierta.
     */
    public function sendText(string $to, string $message)
    {
        $url = "https://graph.facebook.com/{$this->version}/{$this->phoneNumberId}/messages";

        return Http::withToken($this->token)
            ->acceptJson()
            ->post($url, [
                "messaging_product" => "whatsapp",
                "to" => $this->normalizePhone($to),
                "type" => "text",
                "text" => [
                    "preview_url" => false,
                    "body" => $message
                ]
            ]);
    }

    /**
     * Envía una plantilla de WhatsApp.
     */
    public function sendTemplate(string $to, string $template, array $parameters = [])
    {
        $url = "https://graph.facebook.com/{$this->version}/{$this->phoneNumberId}/messages";

        $payload = [
            "messaging_product" => "whatsapp",
            "to" => $this->normalizePhone($to),
            "type" => "template",
            "template" => [
                "name" => $template,
                "language" => [
                    "code" => "es"
                ]
            ]
        ];

        if (!empty($parameters)) {

            $payload["template"]["components"] = [
                [
                    "type" => "body",
                    "parameters" => collect($parameters)->map(function ($value) {
                        return [
                            "type" => "text",
                            "text" => (string) $value
                        ];
                    })->toArray()
                ]
            ];
        }

        return Http::withToken($this->token)
            ->acceptJson()
            ->post($url, $payload);
    }

    /**
     * Envía el recordatorio de una cita.
     */
    public function sendAppointmentReminder(Cita $cita)
    {
        $nombreOdontologo = '';

        if ($cita->odontologo && $cita->odontologo->persona) {
            $nombreOdontologo = trim(
                $cita->odontologo->persona->nombre . ' ' .
                    $cita->odontologo->persona->apellido
            );
        }

        return $this->sendTemplate(
            $cita->telefono,
            'recordatorio_cita',
            [
                $cita->nombrePersona,
                date('d/m/Y', strtotime($cita->fecha)),
                date('g:i A', strtotime($cita->hora)),
                $nombreOdontologo,
            ]
        );
    }

    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (strlen($phone) === 10) {
            $phone = '1' . $phone;
        }

        return $phone;
    }
}
