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
        Schema::create('tratamientos', function (Blueprint $table) {
            $table->id('idTratamiento');
            $table->unsignedBigInteger('idPaciente');

            $table->string('nombre',100);
            $table->date('fechaInicio');
            $table->string('estado',50);
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('idPaciente')
            ->references('idPaciente')
            ->on('pacientes')
            ->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tratamientos');
    }
};
