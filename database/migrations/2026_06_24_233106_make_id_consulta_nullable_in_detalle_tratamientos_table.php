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
        Schema::table('detalle_tratamientos', function (Blueprint $table) {
            $table->unsignedBigInteger('idConsulta')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalle_tratamientos', function (Blueprint $table) {
            $table->unsignedBigInteger('idConsulta')->nullable(false)->change();
        });
    }
};
