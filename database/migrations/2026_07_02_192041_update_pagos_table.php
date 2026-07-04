<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE pagos
            CHANGE fechaCorte fechaVencimiento DATE NOT NULL
        ");

        DB::statement("
            ALTER TABLE pagos
            MODIFY referenciaPago VARCHAR(100) NULL
        ");

        Schema::table('pagos', function (Blueprint $table) {

            $table->foreignId('idUsuario')
                ->after('idMetodoPago')
                ->constrained('usuarios', 'idUsuario');

            $table->text('observacion')
                ->nullable()
                ->after('referenciaPago');
        });
    }

    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {

            $table->dropForeign(['idUsuario']);

            $table->dropColumn([
                'idUsuario',
                'observacion',
            ]);
        });

        DB::statement("
            ALTER TABLE pagos
            CHANGE fechaVencimiento fechaCorte DATE NOT NULL
        ");

        DB::statement("
            ALTER TABLE pagos
            MODIFY referenciaPago INT NULL
        ");
    }
};
