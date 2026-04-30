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
        Schema::create('compras', function (Blueprint $table) {
            $table->id('idCompras');

            $table->unsignedBigInteger('idProveedor');
            $table->date('fecha');
            $table->decimal('monto', 10, 2);
            $table->string('estado', 20);
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('idProveedor')
            ->references('idProveedor')
            ->on('proveedores')
            ->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
