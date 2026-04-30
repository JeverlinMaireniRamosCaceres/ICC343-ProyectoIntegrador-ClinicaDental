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
        Schema::create('producto_procedimiento', function (Blueprint $table) {
            $table->unsignedBigInteger('idProducto');
            $table->unsignedBigInteger('idProcedimiento');
            $table->integer('cantidad')->default(1);

            $table->primary(['idProducto', 'idProcedimiento']);

            $table->foreign('idProducto')
                ->references('idProducto')
                ->on('productos')
                ->onDelete('cascade');

            $table->foreign('idProcedimiento')
                ->references('idProcedimiento')
                ->on('procedimientos')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_procedimiento');
    }
};
