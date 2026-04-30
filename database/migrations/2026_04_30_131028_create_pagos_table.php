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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id('idPago');
            $table->unsignedBigInteger('idFactura');
            $table->unsignedBigInteger('idMetodoPago');

            $table->date('fecha');
            $table->decimal('monto', 10, 2);

            $table->integer('numeroCuota')->nullable();

            $table->string('estado', 50);

            $table->foreign('idFactura')
                ->references('idFactura')
                ->on('facturas')
                ->onDelete('cascade');

            $table->foreign('idMetodoPago')
                ->references('idMetodoPago')
                ->on('metodo_pagos')
                ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
