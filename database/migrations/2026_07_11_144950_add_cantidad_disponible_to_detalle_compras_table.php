<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detalle_compras', function (Blueprint $table) {
            $table->unsignedInteger('cantidadDisponible')->default(0)->after('cantidad');
        });

        DB::table('detalle_compras')->update([
            'cantidadDisponible' => DB::raw('cantidad'),
        ]);
    }

    public function down(): void
    {
        Schema::table('detalle_compras', function (Blueprint $table) {
            $table->dropColumn('cantidadDisponible');
        });
    }
};