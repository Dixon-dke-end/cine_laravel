<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Funcion;
use App\Models\Movie;      // ← Agregar esto

class reservasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los datos
        $validate = $request->validate([
            'funcion_id' => 'required|exists:funciones,id',
            'cantidad_asientos' => 'required|integer|min:1|max:10',
        ]);

        // Obtener la función para verificar disponibilidad
        $funcion = Funcion::with('salas')->findOrFail($validate['funcion_id']);
        
        // Calcular asientos ocupados
        $asientosOcupados = $funcion->reservas()->sum('cantidad_asientos');
        $capacidad = $funcion->salas->capacidad ?? 0;
        $asientosDisponibles = $capacidad - $asientosOcupados;

        // Verificar si hay suficientes asientos disponibles
        if ($validate['cantidad_asientos'] > $asientosDisponibles) {
            return back()->withErrors([
                'cantidad_asientos' => 'No hay suficientes asientos disponibles. Asientos disponibles: ' . $asientosDisponibles
            ])->withInput();
        }

        // Agregar el usuario autenticado y el estado
        $validate['usuario_id'] = auth()->id();
        $validate['estado'] = 'confirmada';

        // Crear la reserva
        Reserva::create($validate);

        // Redirigir con mensaje de éxito
        return redirect()->back()->with('success', 'Reserva realizada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('user.reserva');
        
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
