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
        Schema::create('citas', function (Blueprint $table) {
            $table->id('idCita');

            $table->unsignedBigInteger('idUsuarioRegistro');
            $table->unsignedBigInteger('idOdontologo');

            $table->date('fecha');
            $table->time('hora');
            $table->string('nombrePersona',100);
            $table->string('telefono',20)->nullable();
            $table->string('correo',100)->nullable();
            $table->string('estado',20);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('idUsuarioRegistro')
            ->references('idUsuario')
            ->on('usuarios')
            ->onDelete('cascade');

            $table->foreign('idOdontologo')
            ->references('idOdontologo')
            ->on('odontologos')
            ->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
