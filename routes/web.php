<?php

use App\Http\Controllers\ComprasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProcedimientoController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\ProveedorController;

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

Route::resource('proveedores', ProveedorController::class);


