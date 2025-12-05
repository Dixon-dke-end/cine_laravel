<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\funcionesController;
use App\Http\Controllers\salasController;
use App\Http\Controllers\reservasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ProximamenteController;
use App\Http\Controllers\ConfiteriaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ReportesController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // no necesita devolver vista
})->middleware('role');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['verified'])->name('dashboard');

Route::get('/user/index', [UserController::class, 'index'])
    ->name('user.index');

Route::get('/user/perfil', [UserProfileController::class, 'index'])
    ->middleware('auth')
    ->name('user.perfil');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::resource('movies', MovieController::class);
Route::resource('funciones', funcionesController::class);
Route::resource('salas', salasController::class);

Route::get('/proximamente/admin', [ProximamenteController::class, 'admin'])
    ->name('proximamente.admin');

Route::resource('proximamente', ProximamenteController::class);
Route::resource('confiteria', ConfiteriaController::class);
Route::resource('promociones', App\Http\Controllers\PromocionController::class);

// Ruta pública de confitería para usuarios (catálogo general)
Route::get('/user/confiteria', [ConfiteriaController::class, 'userIndex'])
    ->name('confiteria.user')
    ->middleware('auth');

// 🎯 NUEVA RUTA: Confitería vinculada a reserva (después de seleccionar asientos)
Route::get('/user/confiteria/reserva/{reserva_id}', [ConfiteriaController::class, 'mostrarConfiteriaConReserva'])
    ->name('confiteria.reserva')
    ->middleware('auth');

Route::post('/proximamente/{id}/promover', [ProximamenteController::class, 'promoverACartelera'])
    ->name('proximamente.promover');
    
Route::get('/user/promociones', [App\Http\Controllers\PromocionController::class, 'user'])
    ->name('promociones.user');
    
Route::get('/promociones/{id}/detalles', [App\Http\Controllers\PromocionController::class, 'detalles'])
    ->name('promociones.detalles');

// Rutas de reservas
Route::middleware('auth')->group(function () {
    Route::get('/reservas/create/{funcion_id}', [reservasController::class, 'create'])->name('reservas.create');
    Route::post('/reservas', [reservasController::class, 'store'])->name('reservas.store');
    Route::get('/reservas', [reservasController::class, 'index'])->name('reservas.index');
    Route::get('/reservas/{id}', [reservasController::class, 'show'])->name('reservas.show');
    
    // 🔄 RUTA ANTIGUA (mantener por compatibilidad, pero redirigir a la nueva)
    Route::get('/user/reservaComfi/{id}', function($id) {
        return redirect()->route('confiteria.reserva', $id);
    })->name('reservas.showComfi');
});

Route::get('/movies/{movie}/funciones-por-fecha', [MovieController::class, 'getFuncionesPorFecha'])
    ->name('movies.funciones-por-fecha');

// Rutas API para reservas
Route::middleware('auth')->group(function () {
    Route::post('/api/reservas', [App\Http\Controllers\ReservaApiController::class, 'store'])
        ->name('api.reservas.store');
    
    Route::get('/api/funciones/{id}/sillas', [App\Http\Controllers\ReservaApiController::class, 'getSillas'])
        ->name('api.funciones.sillas');
});

// Rutas de pago
Route::middleware('auth')->group(function () {
    // 🎯 RUTAS DE PAGO UNIFICADO (Reserva + Confitería)
    Route::get('/pagos/checkout/unificado', [PagoController::class, 'mostrarPagoUnificado'])
        ->name('pagos.checkout.unificado');
    
    Route::post('/pagos/unificado/crear-preferencia', [PagoController::class, 'crearPreferenciaMercadoPagoUnificado'])
        ->name('pagos.unificado.preferencia');
    
    Route::get('/pagos/unificado/success', [PagoController::class, 'pagoExitosoUnificado'])
        ->name('pagos.unificado.success');
    
    Route::get('/pagos/unificado/failure', [PagoController::class, 'pagoFallidoUnificado'])
        ->name('pagos.unificado.failure');
    
    // Rutas antiguas de pago (mantener por compatibilidad)
    Route::get('/pagos/checkout/{reserva_id}', [PagoController::class, 'mostrarPago'])
        ->name('pagos.checkout');
    
    Route::post('/pagos/mercadopago/preference/{reserva_id}', [PagoController::class, 'crearPreferenciaMercadoPago'])
        ->name('pagos.mercadopago.preference');
    
    Route::get('/pagos/success/{reserva_id}', [PagoController::class, 'pagoExitoso'])
        ->name('pagos.success');
    
    Route::get('/pagos/failure/{reserva_id}', [PagoController::class, 'pagoFallido'])
        ->name('pagos.failure');
    
    Route::get('/pagos/pending/{reserva_id}', [PagoController::class, 'pagoExitoso'])
        ->name('pagos.pending');
});

// Rutas de reportes (solo para administradores)
Route::middleware('auth')->group(function () {
    Route::get('/reportes', [ReportesController::class, 'index'])->name('reportes.index');
    Route::post('/reportes/generar', [ReportesController::class, 'generarReporte'])->name('reportes.generar');
    Route::get('/reportes/exportar-pdf', [ReportesController::class, 'exportarPDF'])->name('reportes.exportarPDF');
});

Route::post('/webhooks/mercadopago', [PagoController::class, 'webhookMercadoPago'])
    ->name('webhooks.mercadopago');

// Rutas de carrito y confitería
Route::middleware('auth')->group(function () {  
    Route::post('/carrito/agregar', [ConfiteriaController::class, 'agregarAlCarrito'])
        ->name('carrito.agregar');
    Route::put('/carrito/actualizar/{id}', [ConfiteriaController::class, 'actualizarCarrito'])
        ->name('carrito.actualizar');
    Route::delete('/carrito/eliminar/{id}', [ConfiteriaController::class, 'eliminarDelCarrito'])
        ->name('carrito.eliminar');
    Route::delete('/carrito/limpiar', [ConfiteriaController::class, 'limpiarCarrito'])
        ->name('carrito.limpiar');
    
    // Pedidos de confitería
    Route::post('/pedidos/confiteria', [ConfiteriaController::class, 'crearPedido'])
        ->name('pedidos.confiteria.crear');
    Route::get('/pedidos/confiteria', [ConfiteriaController::class, 'misPedidos'])
        ->name('pedidos.confiteria.index');
    Route::get('/pedidos/confiteria/{id}', [ConfiteriaController::class, 'verPedido'])
        ->name('pedidos.confiteria.ver');
    
    // Pagos de confitería
    Route::get('/pagos/checkout/confiteria/{pedido_id}', [PagoController::class, 'mostrarPagoConfiteria'])
        ->name('pagos.checkout.confiteria');
    Route::post('/pagos/confiteria/crear-preferencia/{pedido_id}', [PagoController::class, 'crearPreferenciaMercadoPagoConfiteria'])
        ->name('pagos.confiteria.preferencia');
    Route::get('/pagos/confiteria/success/{pedido_id}', [PagoController::class, 'pagoExitosoConfiteria'])
        ->name('pagos.confiteria.success');
    Route::get('/pagos/confiteria/failure/{pedido_id}', [PagoController::class, 'pagoFallidoConfiteria'])
        ->name('pagos.confiteria.failure');
});