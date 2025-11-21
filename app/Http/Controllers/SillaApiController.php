<?php

namespace App\Http\Controllers;

use App\Models\Funcion;
use App\Models\Sala;
use App\Models\Silla;
use Illuminate\Http\Request;

/**
 * Controlador API para gestionar sillas y su estado en una sala.
 * Proporciona endpoints para obtener sillas disponibles para una función específica.
 */
class SillaApiController extends Controller
{
    /**
     * GET /api/salas/{sala_id}/sillas?funcion={funcion_id}
     * 
     * Retorna todas las sillas de una sala con su estado de ocupación
     * para una función específica.
     * 
     * @param int $sala_id
     * @param Request $request (contiene funcion_id en query)
     * @return \Illuminate\Http\JsonResponse
     */
    public function sillasDisponiblesPorFuncion($sala_id, Request $request)
    {
        $funcionId = $request->query('funcion_id');

        if (!$funcionId) {
            return response()->json([
                'error' => 'funcion_id es requerido'
            ], 400);
        }

        // Validar que la función existe
        $funcion = Funcion::findOrFail($funcionId);

        // Validar que la función pertenece a la sala
        if ($funcion->sala_id != $sala_id) {
            return response()->json([
                'error' => 'La función no pertenece a esta sala'
            ], 422);
        }

        // Obtener todas las sillas de la sala
        $sillas = Silla::where('sala_id', $sala_id)
            ->orderBy('fila')
            ->orderBy('numero')
            ->get()
            ->map(function ($silla) use ($funcionId) {
                return [
                    'id' => $silla->id,
                    'fila' => $silla->fila,
                    'numero' => $silla->numero,
                    'tipo' => $silla->tipo,
                    'nombre' => $silla->fila . $silla->numero,
                    'ocupada' => $silla->estaOcupadaPara($funcionId)
                ];
            });

        // Agrupar por fila para facilitar renderizado en React
        $sillasPorFila = [];
        foreach ($sillas as $silla) {
            if (!isset($sillasPorFila[$silla['fila']])) {
                $sillasPorFila[$silla['fila']] = [];
            }
            $sillasPorFila[$silla['fila']][] = $silla;
        }

        return response()->json([
            'sala_id' => $sala_id,
            'funcion_id' => $funcionId,
            'total_sillas' => $sillas->count(),
            'sillas_ocupadas' => $sillas->where('ocupada', true)->count(),
            'sillas_disponibles' => $sillas->where('ocupada', false)->count(),
            'sillas' => $sillas,
            'sillas_por_fila' => $sillasPorFila
        ]);
    }

    /**
     * GET /api/salas/{sala_id}/sillas
     * 
     * Retorna todas las sillas de una sala sin filtrar por función.
     * Útil para administración.
     * 
     * @param int $sala_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function obtenerSillas($sala_id)
    {
        $sala = Sala::findOrFail($sala_id);

        $sillas = $sala->sillas()
            ->orderBy('fila')
            ->orderBy('numero')
            ->get()
            ->map(function ($silla) {
                return [
                    'id' => $silla->id,
                    'fila' => $silla->fila,
                    'numero' => $silla->numero,
                    'tipo' => $silla->tipo,
                    'nombre' => $silla->fila . $silla->numero
                ];
            });

        return response()->json([
            'sala_id' => $sala_id,
            'total_sillas' => $sillas->count(),
            'sillas' => $sillas
        ]);
    }

    /**
     * GET /api/funciones/{funcion_id}/sillas
     * 
     * Retorna todas las sillas con estado para una función específica.
     * (Ruta alternativa usando función directamente)
     * 
     * @param int $funcion_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function sillasDisponiblesPorFuncionDirecta($funcion_id)
    {
        $funcion = Funcion::findOrFail($funcion_id);
        $sala = $funcion->Sala()->first();

        $sillas = $sala->sillas()
            ->orderBy('fila')
            ->orderBy('numero')
            ->get()
            ->map(function ($silla) use ($funcion_id) {
                return [
                    'id' => $silla->id,
                    'fila' => $silla->fila,
                    'numero' => $silla->numero,
                    'tipo' => $silla->tipo,
                    'nombre' => $silla->fila . $silla->numero,
                    'ocupada' => $silla->estaOcupadaPara($funcion_id)
                ];
            });

        // Agrupar por fila
        $sillasPorFila = [];
        foreach ($sillas as $silla) {
            if (!isset($sillasPorFila[$silla['fila']])) {
                $sillasPorFila[$silla['fila']] = [];
            }
            $sillasPorFila[$silla['fila']][] = $silla;
        }

        return response()->json([
            'success' => true,
            'funcion_id' => $funcion_id,
            'sala_id' => $sala->id,
            'total_sillas' => $sillas->count(),
            'sillas_ocupadas' => $sillas->where('ocupada', true)->count(),
            'sillas_disponibles' => $sillas->where('ocupada', false)->count(),
            'sillas' => $sillas,
            'sillas_por_fila' => $sillasPorFila
        ]);
    }
}
