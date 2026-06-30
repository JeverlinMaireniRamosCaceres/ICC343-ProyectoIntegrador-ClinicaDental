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
        $verifyToken = env('WHATSAPP_VERIFY_TOKEN');

        if (
            $request->get('hub_mode') === 'subscribe' &&
            $request->get('hub_verify_token') === $verifyToken
        ) {
            return response($request->get('hub_challenge'), 200);
        }

        return response('Token inválido.', 403);
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
