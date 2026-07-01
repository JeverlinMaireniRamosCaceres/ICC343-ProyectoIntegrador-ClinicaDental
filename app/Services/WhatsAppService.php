<?php

namespace App\Services;

use App\Models\Cita;
use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    protected string $token;
    protected string $phoneNumberId;
    protected string $version;
    protected string $language;

    public function __construct()
    {
        $this->token = config('services.whatsapp.token');
        $this->phoneNumberId = config('services.whatsapp.phone_number_id');
        $this->version = config('services.whatsapp.version');
        $this->language = config('services.whatsapp.language');
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
                'messaging_product' => 'whatsapp',
                'to' => $this->normalizePhone($to),
                'type' => 'text',
                'text' => [
                    'preview_url' => false,
                    'body' => $message,
                ],
            ]);
    }

    /**
     * Envía una plantilla de WhatsApp.
     */
    public function sendTemplate(string $to, string $template, array $parameters = [])
    {
        $url = "https://graph.facebook.com/{$this->version}/{$this->phoneNumberId}/messages";

        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $this->normalizePhone($to),
            'type' => 'template',
            'template' => [
                'name' => $template,
                'language' => [
                    'code' => $this->language,
                ],
            ],
        ];

        if (!empty($parameters)) {
            $payload['template']['components'] = [
                [
                    'type' => 'body',
                    'parameters' => collect($parameters)
                        ->map(fn($value) => [
                            'type' => 'text',
                            'text' => (string) $value,
                        ])
                        ->values()
                        ->toArray(),
                ],
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

        $response = $this->sendTemplate(
            $cita->telefono,
            config('services.whatsapp.templates.recordatorio'),
            [
                $cita->nombrePersona,
                \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y'),
                \Carbon\Carbon::parse($cita->hora)->format('g:i A'),
                $nombreOdontologo,
            ]
        );

        if ($response->failed()) {
            logger()->error('Error enviando recordatorio de WhatsApp.', [
                'cita_id' => $cita->id,
                'telefono' => $cita->telefono,
                'response' => $response->json(),
            ]);
        }

        return $response;
    }

    /**
     * Normaliza el número al formato E.164 sin el signo +.
     */
    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);

        if (strlen($phone) === 10) {
            $phone = '1' . $phone;
        }

        return $phone;
    }
}
