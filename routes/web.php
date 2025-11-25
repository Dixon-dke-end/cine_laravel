<?php
// Importa los controladores necesarios para manejar las diferentes rutas
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\funcionesController;
use App\Http\Controllers\salasController;
use App\Http\Controllers\reservasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProximamenteController;
use App\Http\Controllers\ConfiteriaController;

use Illuminate\Support\Facades\Route;

// 👇 Ruta principal del sitio ("/")
// Cuando un usuario entra a la raíz, es redirigido automáticamente
// a la ruta llamada 'user.index', que probablemente muestra el panel del usuario.
// Esta ruta está protegida por dos middlewares:
//  - 'auth': exige que el usuario esté autenticado.
//  - 'role': verifica el rol (por ejemplo, si es admin o usuario normal).
Route::get('/', function () {
    // no necesita devolver vista
})->middleware('role');

// 👇 Ruta para el panel de administración (dashboard)
// Solo accesible para usuarios autenticados y verificados.
// 'verified' se usa normalmente cuando el sistema exige verificación de correo.
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware([ 'verified'])->name('dashboard');

// 👇 Ruta para el panel principal de los usuarios normales.
// Llama al método 'index' del UserController.
// Está protegida por el middleware 'auth' (debe estar logueado).
Route::get('/user/index', [UserController::class, 'index'])
    ->name('user.index');

// 👇 Grupo de rutas relacionadas con el perfil del usuario autenticado.
// Este grupo aplica el middleware 'auth' a todas sus rutas internas.
Route::middleware('auth')->group(function () {

    // Muestra la vista para editar el perfil del usuario actual.
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    // Procesa los cambios del perfil enviados por el formulario (método PATCH).
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Elimina el perfil (usuario) autenticado.
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 👇 Carga las rutas de autenticación generadas por Laravel Breeze o Jetstream
// (login, registro, recuperación de contraseña, etc.)
require __DIR__.'/auth.php';

// 👇 Define rutas RESTful automáticas para los recursos principales del sistema.
// Laravel genera automáticamente todas las rutas CRUD (index, create, store, show, edit, update, destroy)
// para cada uno de los siguientes controladores:

Route::resource('movies', MovieController::class);        // CRUD de películas

Route::resource('funciones', funcionesController::class); // CRUD de funciones (horarios o sesiones)

Route::resource('salas', salasController::class);         // CRUD de salas (espacios físicos)

// Ruta personalizada para admin de próximamente (DEBE IR ANTES del resource)
Route::get('/proximamente/admin', [ProximamenteController::class, 'admin'])
    ->name('proximamente.admin');

Route::resource('proximamente', ProximamenteController::class); // CRUD de películas próximamente

Route::resource('confiteria', ConfiteriaController::class); // CRUD de confiteria

// Ruta para promover película de próximamente a cartelera
Route::post('/proximamente/{id}/promover', [ProximamenteController::class, 'promoverACartelera'])
    ->name('proximamente.promover');


// Rutas de reservas (protegidas con autenticación)
Route::middleware('auth')->group(function () {
    Route::get('/reservas/create/{funcion_id}', [reservasController::class, 'create'])->name('reservas.create');
    Route::post('/reservas', [reservasController::class, 'store'])->name('reservas.store');
    Route::get('/reservas', [reservasController::class, 'index'])->name('reservas.index');
    Route::get('/reservas/{id}', [reservasController::class, 'show'])->name('reservas.show');
});

// Ruta para obtener funciones por fecha (AJAX)
Route::get('/movies/{movie}/funciones-por-fecha', [MovieController::class, 'getFuncionesPorFecha'])
    ->name('movies.funciones-por-fecha');


    // 👇 Rutas API para reservas (usando ReservaApiController)
Route::middleware('auth')->group(function () {
    // API para crear reservas desde JavaScript
    Route::post('/api/reservas', [App\Http\Controllers\ReservaApiController::class, 'store'])
        ->name('api.reservas.store');
    
    // API para obtener sillas de una función
    Route::get('/api/funciones/{id}/sillas', [App\Http\Controllers\ReservaApiController::class, 'getSillas'])
        ->name('api.funciones.sillas');
});

// Rutas de pago
Route::middleware('auth')->group(function () {
    // Página de checkout
    Route::get('/pagos/checkout/{reserva_id}', [App\Http\Controllers\PagoController::class, 'mostrarPago'])
        ->name('pagos.checkout');
    
    // Crear preferencia de Mercado Pago (AJAX)
    Route::post('/pagos/mercadopago/preference/{reserva_id}', [App\Http\Controllers\PagoController::class, 'crearPreferenciaMercadoPago'])
        ->name('pagos.mercadopago.preference');
    
    // URLs de retorno de Mercado Pago
    Route::get('/pagos/success/{reserva_id}', [App\Http\Controllers\PagoController::class, 'pagoExitoso'])
        ->name('pagos.success');
    
    Route::get('/pagos/failure/{reserva_id}', [App\Http\Controllers\PagoController::class, 'pagoFallido'])
        ->name('pagos.failure');
    
    Route::get('/pagos/pending/{reserva_id}', [App\Http\Controllers\PagoController::class, 'pagoExitoso'])
        ->name('pagos.pending');
});

// Webhook de Mercado Pago (sin autenticación)
Route::post('/webhooks/mercadopago', [App\Http\Controllers\PagoController::class, 'webhookMercadoPago'])
    ->name('webhooks.mercadopago');

        // Ruta para acceder a pagos

    Route::get('/pagos/pending/{reserva_id}', [App\Http\Controllers\PagoController::class, 'pagoExitoso'])
        ->name('pagos.pending');