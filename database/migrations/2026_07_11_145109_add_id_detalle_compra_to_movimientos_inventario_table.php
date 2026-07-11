<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('movimientos_inventario', function (Blueprint $table) {
            $table->unsignedBigInteger('idDetalleCompra')->nullable()->after('idProducto');

            $table->foreign('idDetalleCompra')
                ->references('idDetalleCompra')
                ->on('detalle_compras')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('movimientos_inventario', function (Blueprint $table) {
            $table->dropForeign(['idDetalleCompra']);
            $table->dropColumn('idDetalleCompra');
        });
    }
};