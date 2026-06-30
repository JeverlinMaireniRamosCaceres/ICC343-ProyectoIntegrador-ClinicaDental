<?php

namespace App\Console\Commands;

use App\Models\Cita;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendAppointmentReminders extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'appointments:reminders';

    /**
     * The console command description.
     */
    protected $description = 'Envía recordatorios de citas por WhatsApp.';

    /**
     * Execute the console command.
     */
    public function handle(WhatsAppService $whatsapp)
    {
        $desde = Carbon::now()->addHours(24);
        $hasta = Carbon::now()->addHours(25);

        $citas = Cita::with('odontologo.persona')
            ->where('estado', 'Pendiente')
            ->where('recordatorioWhatsappEnviado', false)
            ->where(function ($query) use ($desde, $hasta) {
                $query->whereRaw(
                    "TIMESTAMP(fecha, hora) >= ?",
                    [$desde->format('Y-m-d H:i:s')]
                )->whereRaw(
                    "TIMESTAMP(fecha, hora) < ?",
                    [$hasta->format('Y-m-d H:i:s')]
                );
            })
            ->get();

        if ($citas->isEmpty()) {
            $this->info('No hay citas para recordar.');
            return Command::SUCCESS;
        }

        foreach ($citas as $cita) {

            $response = $whatsapp->sendAppointmentReminder($cita);

            if ($response->successful()) {

                $json = $response->json();

                $cita->update([
                    'recordatorioWhatsappEnviado' => true,
                    'recordatorioWhatsappEnviadoAt' => now(),
                    'whatsappMessageId' => $json['messages'][0]['id'] ?? null,
                ]);

                $this->info("✓ Recordatorio enviado a {$cita->nombrePersona}");
            } else {

                $error = $response->json()['error']['message'] ?? 'Error desconocido';

                $this->error(
                    "✗ {$cita->nombrePersona}: {$error}"
                );
            }
        }

        return Command::SUCCESS;
    }
}
