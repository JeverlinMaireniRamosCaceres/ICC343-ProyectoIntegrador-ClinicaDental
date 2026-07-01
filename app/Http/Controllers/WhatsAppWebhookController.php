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
        $mode = $request->query('hub_mode');
        $token = $request->query('hub_verify_token');
        $challenge = $request->query('hub_challenge');

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

        return response()->json([
            'success' => true
        ]);
    }
}
