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
        Schema::create('paciente_alergia', function (Blueprint $table) {
            $table->unsignedBigInteger('idPaciente');
            $table->unsignedBigInteger('idAlergia');

            $table->string('tipo', 50)->nullable();
            $table->string('severidad', 50)->nullable();

            $table->primary(['idPaciente', 'idAlergia']);

            $table->timestamps();

            $table->foreign('idPaciente')
            ->references('idPaciente')
            ->on('pacientes')
            ->onDelete('cascade');

            $table->foreign('idAlergia')
            ->references('idAlergia')
            ->on('alergias')
            ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paciente_alergia');
    }
};
