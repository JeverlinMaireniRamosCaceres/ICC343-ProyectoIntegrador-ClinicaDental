<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rol = Rol::where('nombre', 'Administrador')->firstOrFail();

        Usuario::firstOrCreate(
            [
                'username' => 'admin',
            ],
            [
                'idPersona' => null,
                'idRol' => $rol->idRol,
                'password' => Hash::make('admin'),
            ]
        );
    }
}
