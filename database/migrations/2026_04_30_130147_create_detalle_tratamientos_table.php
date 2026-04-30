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
        Schema::create('detalle_tratamientos', function (Blueprint $table) {
            $table->id('idDetalleTratamiento');

            $table->unsignedBigInteger('idConsulta');
            $table->unsignedBigInteger('idTratamiento');
            $table->unsignedBigInteger('idProcedimiento');

            $table->integer('cantidadProcedimiento')->default(1);
            $table->text('observacion')->nullable();
            $table->string('estado', 50);

            $table->foreign('idConsulta')
                ->references('idConsulta')
                ->on('consultas')
                ->onDelete('cascade');

            $table->foreign('idTratamiento')
                ->references('idTratamiento')
                ->on('tratamientos')
                ->onDelete('cascade');

            $table->foreign('idProcedimiento')
                ->references('idProcedimiento')
                ->on('procedimientos')
                ->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_tratamientos');
    }
};
