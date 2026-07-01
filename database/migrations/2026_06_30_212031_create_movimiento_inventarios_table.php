<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movimientos_inventario', function (Blueprint $table) {
            $table->id('idMovimiento');

            $table->foreignId('idProducto')
                ->constrained('productos', 'idProducto')
                ->cascadeOnDelete();

            $table->enum('tipo', ['ENTRADA', 'SALIDA']);

            $table->integer('cantidad');

            $table->string('motivo');

            $table->foreignId('idConsulta')
                ->nullable()
                ->constrained('consultas', 'idConsulta')
                ->nullOnDelete();

            $table->foreignId('idProcedimiento')
                ->nullable()
                ->constrained('procedimientos', 'idProcedimiento')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimiento_inventarios');
    }
};
