<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SillaApiController;
use App\Http\Controllers\ReservaApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aquí puedes registrar las rutas API para tu aplicación. Estas rutas
| son cargadas por el RouteServiceProvider y todas ellas estarán
| dentro del grupo "api" middleware.
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ========== RUTAS PÚBLICAS (sin autenticación) ==========

/**
 * SILLAS - Obtener información de sillas
 */
Route::get('/salas/{sala_id}/sillas', [SillaApiController::class, 'sillasDisponiblesPorFuncion']);
Route::get('/salas/{sala_id}/sillas-admin', [SillaApiController::class, 'obtenerSillas']);
Route::get('/funciones/{funcion_id}/sillas', [SillaApiController::class, 'sillasDisponiblesPorFuncionDirecta']);

// ========== RUTAS PROTEGIDAS (requieren autenticación con guard web) ==========

Route::middleware('auth:web')->group(function () {
    /**
     * RESERVAS - Crear, obtener y cancelar
     */
    Route::post('/reservas', [ReservaApiController::class, 'store']);
    Route::get('/reservas/{id}', [ReservaApiController::class, 'show']);
    Route::post('/reservas/{id}/cancelar', [ReservaApiController::class, 'cancelar']);
    Route::get('/mis-reservas', [ReservaApiController::class, 'reservasUsuario']);
});
