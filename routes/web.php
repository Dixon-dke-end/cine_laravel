<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\funcionesController;
use App\Http\Controllers\salasController;
use App\Http\Controllers\reservasController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// 👇 Redirección raíz controlada por middleware 'role'
Route::get('/', function () {
    return redirect()->route('user.index');
})->middleware(['auth', 'role']);

// 👇 Dashboard para administradores
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 👇 Rutas exclusivas para usuarios normales
Route::get('/user/index', [UserController::class, 'index'])
    ->middleware(['auth'])
    ->name('user.index');

// 👇 Perfil de usuario autenticado
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 👇 Otras rutas del sistema
require __DIR__.'/auth.php';

Route::resource('movies', MovieController::class);
Route::resource('funciones', funcionesController::class);
Route::resource('salas', salasController::class);
Route::resource('reservas', reservasController::class);
