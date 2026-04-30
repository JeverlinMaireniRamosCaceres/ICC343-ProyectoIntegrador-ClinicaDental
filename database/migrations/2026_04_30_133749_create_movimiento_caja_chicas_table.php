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
        Schema::create('movimiento_caja_chicas', function (Blueprint $table) {
            $table->id('idMovimientoCajaChica');

            $table->unsignedBigInteger('idUsuario');
            $table->unsignedBigInteger('idCajaChica');

            $table->time('hora');
            $table->decimal('monto', 10, 2);

            $table->string('tipo', 50);
            $table->text('descripcion')->nullable();

            $table->timestamps();

            $table->foreign('idUsuario')
                ->references('idUsuario')
                ->on('usuarios')
                ->onDelete('restrict');

            $table->foreign('idCajaChica')
                ->references('idCajaChica')
                ->on('caja_chicas')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimiento_caja_chicas');
    }
};
