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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('idUsuario');
            $table->unsignedBigInteger('idPersona');
            $table->unsignedBigInteger('idRol');
            $table->string('username', 50)->unique();
            $table->string('password');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('idPersona')
                ->references('idPersona')
                ->on('personas')
                ->onDelete('cascade');

            $table->foreign('idRol')
                ->references('idRol')
                ->on('roles')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
