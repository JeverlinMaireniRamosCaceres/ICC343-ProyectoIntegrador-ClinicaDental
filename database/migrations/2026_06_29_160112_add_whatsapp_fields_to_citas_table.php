<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->boolean('recordatorioWhatsappEnviado')
                ->default(false)
                ->after('estado');

            $table->timestamp('recordatorioWhatsappEnviadoAt')
                ->nullable()
                ->after('recordatorioWhatsappEnviado');

            $table->string('whatsappMessageId')
                ->nullable()
                ->after('recordatorioWhatsappEnviadoAt');
        });
    }

    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropColumn([
                'recordatorioWhatsappEnviado',
                'recordatorioWhatsappEnviadoAt',
                'whatsappMessageId',
            ]);
        });
    }
};
