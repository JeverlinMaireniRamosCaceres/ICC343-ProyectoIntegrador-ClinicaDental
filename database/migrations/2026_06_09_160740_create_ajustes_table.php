<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ajustes', function (Blueprint $table) {
            $table->id('idAjuste');
            $table->unsignedBigInteger('idProducto');
            $table->unsignedBigInteger('idUsuario')->nullable();
            $table->integer('stockAnterior');
            $table->integer('stockNuevo');
            $table->string('motivo');
            $table->text('observacion')->nullable();
            $table->timestamps();

            $table->foreign('idProducto')
                ->references('idProducto')
                ->on('productos')
                ->onDelete('cascade');

            $table->foreign('idUsuario')
                ->references('idUsuario')
                ->on('usuarios')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ajustes');
    }
};
