<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detalle_consultas', function (Blueprint $table) {

            $table->unsignedBigInteger('idDetalleTratamiento')
                ->nullable()
                ->after('idProcedimiento');

            $table->foreign('idDetalleTratamiento')
                ->references('idDetalleTratamiento')
                ->on('detalle_tratamientos')
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('detalle_consultas', function (Blueprint $table) {

            $table->dropForeign(['idDetalleTratamiento']);
            $table->dropColumn('idDetalleTratamiento');

        });
    }
};