<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('caja_chicas', function (Blueprint $table) {
            $table->id('idCajaChica');

            $table->unsignedBigInteger('idUsuarioApertura');

            $table->date('fecha');
            $table->time('horaApertura');
            $table->decimal('montoInicial', 10, 2);
            $table->decimal('saldoActual', 10, 2);

            $table->string('estado', 50);
            $table->time('horaCierre')->nullable();

            $table->timestamps();

            $table->foreign('idUsuarioApertura')
                ->references('idUsuario')
                ->on('usuarios')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caja_chicas');
    }
};
