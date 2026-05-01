<?php

use App\Http\Controllers\ComprasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProcedimientoController;


Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('procedimientos', ProcedimientoController::class);
Route::resource('compras', ComprasController::class);
