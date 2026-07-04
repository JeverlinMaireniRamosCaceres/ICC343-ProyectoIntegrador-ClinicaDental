<?php

namespace Database\Seeders;

use App\Models\MetodoPago;
use Illuminate\Database\Seeder;

class MetodoPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $metodos = [
            'Efectivo',
            'Tarjeta',
            'Transferencia',
        ];

        foreach ($metodos as $metodo) {

            MetodoPago::firstOrCreate([
                'descripcion' => $metodo,
            ]);
        }
    }
}
