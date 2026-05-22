<?php

use App\Http\Controllers\CajaChicaController;
use App\Http\Controllers\ComprasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProcedimientoController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\OdontologoController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\FacturacionController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\AlergiaController;

use App\Http\Controllers\EspecialidadController;

// dashboard
Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

// procedimientos
Route::resource('procedimientos', ProcedimientoController::class);

// login
Route::get('/login', function () {
    return view('auth.login');
});

// compras
Route::resource('compras', ComprasController::class);

// pacientes
Route::resource('pacientes', PacientesController::class);

// proveedores
Route::resource('proveedores', ProveedorController::class);

// usuarios
Route::resource('usuarios', UsuariosController::class);
Route::put('/usuarios/{id}/activar', [UsuariosController::class, 'activar'])
    ->name('usuarios.activar');

// para buscar persona y vincularla al usuario
Route::get('/buscar-personas', [UsuariosController::class, 'buscarPersonas'])
    ->name('usuarios.buscarPersonas');

// productos
Route::resource('productos', ProductoController::class);

// odontologos
Route::resource('odontologos', OdontologoController::class);

// citas
Route::resource('citas', CitaController::class);

//caja chica
Route::resource('caja-chica', CajaChicaController::class);

//Facturacion
Route::resource('facturacion', FacturacionController::class);

//Consultas
Route::resource('consultas', ConsultaController::class);

// alergias
Route::resource('alergias', AlergiaController::class);

//Especialidades
Route::resource('especialidades', EspecialidadController::class);
