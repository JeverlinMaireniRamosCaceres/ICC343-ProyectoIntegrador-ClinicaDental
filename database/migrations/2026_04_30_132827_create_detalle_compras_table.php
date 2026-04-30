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
        Schema::create('detalle_compras', function (Blueprint $table) {
            $table->id('idDetalleCompra');
            $table->unsignedBigInteger('idCompras');
            $table->unsignedBigInteger('idProducto');
            $table->integer('cantidad');
            $table->decimal('precioUnitario', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->date('fechaVencimiento')->nullable();
            $table->timestamps();

            $table->foreign('idCompras')
                ->references('idCompras')
                ->on('compras')
                ->onDelete('cascade');

            $table->foreign('idProducto')
                ->references('idProducto')
                ->on('productos')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_compras');
    }
};
