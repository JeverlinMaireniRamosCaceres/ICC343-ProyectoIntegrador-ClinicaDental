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
        Schema::create('detalle_consultas', function (Blueprint $table) {
            $table->id('idDetalleConsulta');
            $table->unsignedBigInteger('idConsulta');
            $table->unsignedBigInteger('idProcedimiento');
            $table->integer('cantidadProcedimiento')->default(1);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();

            $table->foreign('idConsulta')
            ->references('idConsulta')
            ->on('consultas')
            ->onDelete('cascade');

            $table->foreign('idProcedimiento')
            ->references('idProcedimiento')
            ->on('procedimientos')
            ->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_consultas');
    }
};
