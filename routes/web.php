<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProcedimientoController;


Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('procedimientos', ProcedimientoController::class);
