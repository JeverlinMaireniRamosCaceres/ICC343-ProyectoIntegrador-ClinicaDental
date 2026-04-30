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
        Schema::create('personas', function (Blueprint $table) {
            $table->id('idPersona');
            $table->string('cedula', 12)->unique();
            $table->string('nombre',100);
            $table->string('apellido',100);
            $table->date('fechaNacimiento')->nullable();
            $table->string('telefono',12)->nullable();
            $table->string('correo',100)->unique()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
