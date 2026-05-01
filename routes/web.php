<?php

use App\Http\Controllers\ComprasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProcedimientoController;
use App\Http\Controllers\ProveedorController;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('procedimientos', ProcedimientoController::class);

Route::get('/login', function () {
    return view('auth.login');
});

Route::resource('compras', ComprasController::class);

Route::resource('proveedores', ProveedorController::class);

