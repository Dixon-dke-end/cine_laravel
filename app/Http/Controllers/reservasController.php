<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\ReservaSilla;
use App\Models\Funcion;
use App\Models\Movie;
use App\Models\Sala;
use App\Models\Silla;
use Illuminate\Support\Facades\DB;

class reservasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener reservas del usuario autenticado
        $reservas = Reserva::where('usuario_id', auth()->id())
            ->with(['funcion.movies', 'funcion.Sala'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('user.reserva', compact('reservas'));
    }

    /**
     * Show the form for creating a new resource (selección de asientos)
     */
    public function create($funcion_id)
    {
        // Obtener la función con relaciones
        $funcion = Funcion::with(['movies', 'Sala'])->findOrFail($funcion_id);
        
        // Obtener todas las sillas de la sala con su estado de ocupación
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

        // Agrupar por fila para facilitar el renderizado
        $sillasPorFila = [];
        foreach ($sillas as $silla) {
            if (!isset($sillasPorFila[$silla['fila']])) {
                $sillasPorFila[$silla['fila']] = [];
            }
            $sillasPorFila[$silla['fila']][] = $silla;
        }

        return view('reservas.create', compact('funcion', 'sillas', 'sillasPorFila'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los datos
        $validate = $request->validate([
            'funcion_id' => 'required|exists:funciones,id',
            'sillas_ids' => 'required|array|min:1|max:20',
            'sillas_ids.*' => 'required|exists:sillas,id|integer',
            'precio_total' => 'required|numeric|min:0.01',
        ]);

        // Obtener la función
        $funcion = Funcion::with(['Sala'])->findOrFail($validate['funcion_id']);

        // Verificar que la función no esté en el pasado
        if (\Carbon\Carbon::parse($funcion->hora)->isPast()) {
            return back()->withErrors(['funcion' => 'No puedes reservar una función que ya pasó.']);
        }

        // Dentro de una transacción para evitar condiciones de carrera
        DB::beginTransaction();

        try {
            // Bloqueo pessimista: obtener la función con bloqueo
            $funcionBloqueada = Funcion::lockForUpdate()->findOrFail($validate['funcion_id']);
            
            // Obtener sillas que ya están ocupadas para esta función
            $sillasOcupadas = Silla::whereHas('reservasSillas', function ($query) use ($validate) {
                $query->whereHas('reserva', function ($q) use ($validate) {
                    $q->where('funcion_id', $validate['funcion_id'])
                      ->where('estado', '!=', 'cancelada');
                });
            })->pluck('id')->toArray();

            // Verificar que las sillas seleccionadas no estén ocupadas
            $sillaConflicto = array_intersect($validate['sillas_ids'], $sillasOcupadas);
            if (!empty($sillaConflicto)) {
                DB::rollBack();
                return back()->withErrors([
                    'sillas' => 'Una o más sillas ya fueron reservadas. Por favor, selecciona otras.'
                ])->withInput();
            }

            // Validar que las sillas pertenecen a la sala correcta
            $sillasValidas = Silla::whereIn('id', $validate['sillas_ids'])
                ->where('sala_id', $funcion->sala_id)
                ->count();

            if ($sillasValidas !== count($validate['sillas_ids'])) {
                DB::rollBack();
                return back()->withErrors([
                    'sillas' => 'Una o más sillas no pertenecen a esta sala.'
                ])->withInput();
            }

            // Crear la reserva
            $reserva = Reserva::create([
                'funcion_id' => $validate['funcion_id'],
                'usuario_id' => auth()->id(),
                'cantidad_asientos' => count($validate['sillas_ids']),
                'precio_total' => $validate['precio_total'],
                'estado' => 'pendiente'
            ]);

            // Asociar las sillas a la reserva
            foreach ($validate['sillas_ids'] as $sillaId) {
                ReservaSilla::create([
                    'reserva_id' => $reserva->id,
                    'silla_id' => $sillaId
                ]);
            }

            DB::commit();

            // Redirigir a confirmación
            return redirect()->route('reservas.show', $reserva->id)
                ->with('success', 'Reserva creada exitosamente. Procede con el pago.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al crear la reserva: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Obtener la reserva con sus relaciones
        $reserva = Reserva::with([
            'funcion.movies',
            'funcion.Sala',
            'usuario',
            'sillas.silla'
        ])->findOrFail($id);
        
        // Verificar que el usuario sea el dueño de la reserva
        if ($reserva->usuario_id !== auth()->id()) {
            abort(403, 'No tienes permiso para ver esta reserva');
        }
        
        return view('reservas.show', compact('reserva'));
    }

    /**
     * Display reservation with confiteria option
     */
    public function showComfi(string $id)
    {
        // Obtener la reserva con sus relaciones
        $reserva = Reserva::with([
            'funcion.movies',
            'funcion.Sala',
            'usuario',
            'sillas.silla'
        ])->findOrFail($id);
        
        // Verificar que el usuario sea el dueño de la reserva
        if ($reserva->usuario_id !== auth()->id()) {
            abort(403, 'No tienes permiso para ver esta reserva');
        }
        
        return view('user.reservaComfi', compact('reserva'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
