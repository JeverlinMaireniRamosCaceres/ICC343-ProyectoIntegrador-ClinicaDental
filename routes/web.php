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

// productos
Route::resource('productos', ProductoController::class);

// odontologos
Route::resource('odontologos', OdontologoController::class);

// citas
Route::resource('citas', CitaController::class);

//caja chica
Route::resource('caja-chica', CajaChicaController::class);
