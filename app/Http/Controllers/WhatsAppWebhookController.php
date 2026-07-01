<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsAppWebhookController extends Controller
{
    /**
     * Verificación del webhook por Meta.
     */
    public function verify(Request $request)
    {
        $mode = $request->query('hub.mode');
        $token = $request->query('hub.verify_token');
        $challenge = $request->query('hub.challenge');

        if (
            $mode === 'subscribe' &&
            $token === env('WHATSAPP_VERIFY_TOKEN')
        ) {
            return response($challenge, 200);
        }

        return response('Forbidden', 403);
    }

    /**
     * Recibe eventos de WhatsApp.
     */
    public function receive(Request $request)
    {
        Log::info('WhatsApp Webhook: ' . $request->getContent());

        $data = json_decode($request->getContent(), true);

        $message = $data['entry'][0]['changes'][0]['value']['messages'][0] ?? null;

        if (!$message) {
            return response()->json(['success' => true]);
        }

        if (($message['type'] ?? null) !== 'button') {
            return response()->json(['success' => true]);
        }

        $contextId = $message['context']['id'] ?? null;
        $accion = $message['button']['payload'] ?? null;

        if (!$contextId || !$accion) {
            return response()->json(['success' => true]);
        }

        $cita = Cita::where('whatsappMessageId', $contextId)->first();

        if (!$cita) {
            Log::warning("No se encontró una cita para el mensaje {$contextId}");

            return response()->json(['success' => true]);
        }

        switch ($accion) {
            case 'Confirmar':
                $cita->estado = 'Confirmada';
                break;

            case 'Cancelar':
                $cita->estado = 'Cancelada';
                break;

            default:
                return response()->json(['success' => true]);
        }

        $cita->save();

        Log::info("Cita {$cita->idCita} actualizada a {$cita->estado}");

        return response()->json([
            'success' => true
        ]);
    }
}
