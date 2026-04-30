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
        Schema::create('odontologo_especialidad', function (Blueprint $table) {
            $table->unsignedBigInteger('idOdontologo');
            $table->unsignedBigInteger('idEspecialidad');

            $table->primary(['idOdontologo', 'idEspecialidad']);

            $table->foreign('idOdontologo')
                ->references('idOdontologo')
                ->on('odontologos')
                ->onDelete('cascade');

            $table->foreign('idEspecialidad')
                ->references('idEspecialidad')
                ->on('especialidades')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('odontologo_especialidad');
    }
};
