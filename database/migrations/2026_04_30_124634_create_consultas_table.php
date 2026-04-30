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
        Schema::create('consultas', function (Blueprint $table) {
            $table->id('idConsulta');

            $table->unsignedBigInteger('idPaciente');
            $table->unsignedBigInteger('idOdontologo');

            $table->date('fecha');
            $table->text('motivo')->nullable();
            $table->text('diagnostico')->nullable();
            $table->text('receta')->nullable();
            $table->string('estado', 50);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('idPaciente')
            ->references('idPaciente')
            ->on('pacientes')
            ->onDelete('restrict');

            $table->foreign('idOdontologo')
            ->references('idOdontologo')
            ->on('odontologos')
            ->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
