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
        Schema::create('odontologos', function (Blueprint $table) {
            $table->id('idOdontologo');
            $table->unsignedBigInteger('idPersona');
            $table->string('exequatur',50)->unique();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('idPersona')
                ->references('idPersona')
                ->on('personas')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('odontologos');
    }
};
