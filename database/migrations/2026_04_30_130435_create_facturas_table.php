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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id('idFactura');
            $table->unsignedBigInteger('idConsulta');

            $table->decimal('total', 10, 2);
            $table->date('fechaVencimiento')->nullable();

            $table->integer('cantidadCuotas')->default(1);

            $table->string('tipoDescuento', 50)->nullable();
            $table->decimal('montoDescuento', 10, 2)->default(0);
            $table->decimal('porcentajeDescuento', 5, 2)->default(0);

            $table->string('estado', 50);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('idConsulta')
                ->references('idConsulta')
                ->on('consultas')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
