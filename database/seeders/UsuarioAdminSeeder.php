<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\Usuario;
use App\Models\Persona;
use App\Models\Odontologo;
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

        $persona = Persona::firstOrCreate(
            ['cedula' => '00000000000'],
            [
                'nombre' => 'Administrador',
                'apellido' => 'Sistema',
                'fechaNacimiento' => '1990-01-01',
                'sexo' => 'Masculino',
                'telefono' => '000-000-0000',
                'correo' => null,
            ]
        );

        $odontologo = Odontologo::firstOrCreate(
            ['idPersona' => $persona->idPersona],
            [
                'exequatur' => 'ADMIN-001',
            ]
        );

        $usuario = Usuario::firstOrCreate(
            ['username' => 'admin'],
            [
                'password' => Hash::make('admin'),
                'idRol' => $rol->idRol,
            ]
        );

        
        $usuario->update([
            'idPersona' => $persona->idPersona,
            'idRol' => $rol->idRol,
        ]);
    }
}
