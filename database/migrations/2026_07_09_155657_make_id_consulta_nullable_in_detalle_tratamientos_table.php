<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('detalle_tratamientos', function (Blueprint $table) {
            $table->unsignedBigInteger('idConsulta')
                ->nullable()
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('detalle_tratamientos', function (Blueprint $table) {
            $table->unsignedBigInteger('idConsulta')
                ->nullable(false)
                ->change();
        });
    }
};


