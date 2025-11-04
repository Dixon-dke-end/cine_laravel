<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\funcionesController;
use App\Http\Controllers\salasController;
use App\Http\Controllers\reservasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

<<<<<<< HEAD
Route::get('/', function () {return redirect()->route('user.index');});


Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');});
    require __DIR__.'/auth.php';



Route::delete('/movies/{id}',[MovieController::class,'destroy'])->name('movies.destroy');
=======
Route::get('/', function () {return view('movies/index');});

Route::get('/dashboard', function () {return view('dashboard');})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');});require __DIR__.'/auth.php';

Route::delete('/movies/{id}',[MovieController::class,'destroy'])->name('movies.destroy');


Route::get('/',[MovieController::class,'edit'])->name('movies.edit');

Route::get('/', [MovieController::class,'index']);

>>>>>>> f690796 (Subida inicial del proyecto Laravel)
Route::resource('movies', MovieController::class);

Route::resource('funciones',funcionesController::class);

Route::resource('salas',salasController::class);
<<<<<<< HEAD
Route::resource('reservas',reservasController::class);
Route::get('/user/index', [UserController::class, 'index'])->name('user.index');
=======

Route::resource('reservas',reservasController::class);
>>>>>>> f690796 (Subida inicial del proyecto Laravel)
