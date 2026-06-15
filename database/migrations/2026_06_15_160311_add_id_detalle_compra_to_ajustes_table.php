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
        Schema::table('ajustes', function (Blueprint $table) {
            $table->unsignedBigInteger('idDetalleCompra')->nullable()->after('idProducto');

            $table->foreign('idDetalleCompra')
                ->references('idDetalleCompra')
                ->on('detalle_compras')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ajustes', function (Blueprint $table) {
            $table->dropForeign(['idDetalleCompra']);
            $table->dropColumn('idDetalleCompra');
        });
    }
    
};
