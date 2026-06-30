<?php

namespace App\Http\Controllers;

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
        // Por ahora solo guardaremos lo que llegue.
        Log::info('WhatsApp Webhook', $request->all());

        return response()->json([
            'success' => true
        ]);
    }
}
