<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\ReservaSilla;
use App\Models\Funcion;
use App\Models\Silla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Controlador API para gestionar reservas desde React
 * Proporciona endpoints para crear y gestionar reservas
 */
class ReservaApiController extends Controller
{
    /**
     * POST /api/reservas
     * 
     * Crea una nueva reserva con las sillas seleccionadas
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        \Log::info('🚀 LLEGÓ LA PETICIÓN A Laravel');
        \Log::info('📩 Datos recibidos:', ['request_all' => request()->all()]);
        
        // Validación
        $validated = $request->validate([
            'funcion_id' => 'required|exists:funciones,id',
            'sillas_ids' => 'required|array|min:1|max:20',
            'sillas_ids.*' => 'required|exists:sillas,id|integer',
            'precio_total' => 'required|numeric|min:0.01',
        ]);
        
        \Log::info('📝 Datos validados:', $validated);

        DB::beginTransaction();

        try {
            // Obtener la función
            $funcion = Funcion::lockForUpdate()->findOrFail($validated['funcion_id']);

            // Verificar que la función no esté en el pasado
            if (\Carbon\Carbon::parse($funcion->hora)->isPast()) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'No puedes reservar una función que ya pasó.'
                ], 422);
            }

            // Obtener sillas ocupadas para esta función
            // IGNORANDO reservas expiradas o canceladas
            $sillasOcupadas = Silla::whereHas('reservasSillas', function ($query) use ($validated) {
                $query->whereHas('reserva', function ($q) use ($validated) {
                    $q->where('funcion_id', $validated['funcion_id'])
                    ->where('estado', '!=', 'cancelada')
                    ->where(function($subQ) {
                        // Solo contar reservas confirmadas o pendientes que no expiraron
                        $subQ->where('estado', 'confirmada')
                            ->orWhere(function($pendingQ) {
                                $pendingQ->where('estado', 'pendiente')
                                            ->where(function($expireQ) {
                                                $expireQ->whereNull('expires_at')
                                                        ->orWhere('expires_at', '>', now());
                                            });
                            });
                    });
                });
            })->pluck('id')->toArray();

            // Verificar conflictos
            $sillaConflicto = array_intersect($validated['sillas_ids'], $sillasOcupadas);
            if (!empty($sillaConflicto)) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Una o más sillas ya fueron reservadas.',
                    'sillas_conflicto' => $sillaConflicto
                ], 409);
            }

            // Validar que las sillas pertenecen a la sala correcta
            $sillasValidas = Silla::whereIn('id', $validated['sillas_ids'])
                ->where('sala_id', $funcion->sala_id)
                ->count();

            if ($sillasValidas !== count($validated['sillas_ids'])) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Una o más sillas no pertenecen a esta sala.'
                ], 422);
            }
            
            // Crear la reserva
            $reserva = Reserva::create([
                'funcion_id' => $validated['funcion_id'],
                'usuario_id' => auth()->id(),
                'cantidad_asientos' => count($validated['sillas_ids']),
                'precio_total' => $validated['precio_total'],
                'estado' => 'pendiente',
                'expires_at' => now()->addMinutes(15) 
            ]);

            // Crear registros en reservas_sillas
            foreach ($validated['sillas_ids'] as $sillaId) {
                ReservaSilla::create([
                    'reserva_id' => $reserva->id,
                    'silla_id' => $sillaId
                ]);
            }

            DB::commit();

            // Cargar relaciones para respuesta
            $reserva->load(['sillas.silla', 'funcion.movies', 'funcion.Sala']);

            // 🎯 RESPUESTA MODIFICADA PARA REDIRIGIR A CONFITERÍA
            return response()->json([
                'success' => true,
                'message' => 'Reserva creada exitosamente',
                'reserva' => [
                    'id' => $reserva->id,
                    'funcion_id' => $reserva->funcion_id,
                    'cantidad_asientos' => $reserva->cantidad_asientos,
                    'precio_total' => $reserva->precio_total,
                    'estado' => $reserva->estado
                ],
                'redirect_url' => route('confiteria.reserva', $reserva->id) // 🔗 URL de confitería
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('❌ Error al crear reserva:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la reserva: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/reservas/{id}
     * 
     * Obtiene los detalles de una reserva
     */
    public function show($id)
    {
        $reserva = Reserva::with([
            'sillas.silla',
            'funcion.movies',
            'funcion.Sala',
            'usuario'
        ])->findOrFail($id);

        // Verificar que el usuario sea el propietario
        if ($reserva->usuario_id !== auth()->id()) {
            return response()->json([
                'error' => 'No tienes permiso para ver esta reserva'
            ], 403);
        }

        return response()->json($reserva);
    }

    /**
     * DELETE /api/reservas/{id}/cancelar
     * 
     * Cancela una reserva (si está pendiente o confirmada)
     */
    public function cancelar($id)
    {
        $reserva = Reserva::findOrFail($id);

        // Verificar que el usuario sea el propietario
        if ($reserva->usuario_id !== auth()->id()) {
            return response()->json([
                'error' => 'No tienes permiso para cancelar esta reserva'
            ], 403);
        }

        // Verificar que la reserva no esté ya cancelada
        if ($reserva->estado === 'cancelada') {
            return response()->json([
                'error' => 'Esta reserva ya fue cancelada'
            ], 422);
        }

        // Verificar que no esté vencida
        if (\Carbon\Carbon::parse($reserva->funcion->hora)->isPast()) {
            return response()->json([
                'error' => 'No puedes cancelar una reserva vencida'
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Marcar como cancelada
            $reserva->update(['estado' => 'cancelada']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Reserva cancelada exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Error al cancelar la reserva: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/usuarios/{usuario_id}/reservas
     * 
     * Obtiene todas las reservas del usuario autenticado
     */
    public function reservasUsuario()
    {
        $reservas = Reserva::where('usuario_id', auth()->id())
            ->with(['funcion.movies', 'funcion.Sala', 'sillas.silla'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($reservas);
    }

    /**
     * GET /api/funciones/{id}/sillas
     * 
     * Obtiene las sillas de una función con su estado de ocupación
     */
    public function getSillas($id)
    {
        $funcion = Funcion::with('Sala.sillas')->findOrFail($id);
        
        $sillas = $funcion->Sala->sillas->map(function($silla) use ($id) {
            return [
                'id' => $silla->id,
                'fila' => $silla->fila,
                'numero' => $silla->numero,
                'tipo' => $silla->tipo,
                'ocupada' => $silla->estaOcupadaPara($id)
            ];
        });

        return response()->json([
            'success' => true,
            'sillas' => $sillas
        ]);
    }
}