<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sala;
use App\Services\SillaService;

class salasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salas = Sala::with('sillas')->get();
        return view('salas.index', compact('salas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('salas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_sala' => 'required|string|unique:salas|max:255',
            'capacidad' => 'required|integer|min:10|max:1000',
            'filas' => 'required|integer|min:2|max:50',
            'columnas' => 'required|integer|min:2|max:50',
            'distribucion' => 'nullable|string|in:estandar,premium,vip' // opcional
        ]);

        try {
            // Crear la sala
            $sala = Sala::create([
                'nombre_sala' => $validated['nombre_sala'],
                'capacidad' => $validated['capacidad']
            ]);

            // Generar automáticamente las sillas según el tipo de distribución
            if ($validated['distribucion'] === 'premium') {
                $config = SillaService::distribucionPremium();
                SillaService::generarSillas($sala, $config['filas'], $config['columnas'], $config['distribuciones']);
            } else if ($validated['distribucion'] === 'vip') {
                // Personalizado VIP (todas premium/vip)
                SillaService::generarSillas($sala, $validated['filas'], $validated['columnas'], [
                    'A-Z' => 'vip'
                ]);
            } else {
                // Estándar
                SillaService::generarSillas($sala, $validated['filas'], $validated['columnas']);
            }

            return redirect()->route('salas.show', $sala->id)
                ->with('success', "Sala '{$sala->nombre_sala}' creada con " . $sala->sillas()->count() . " sillas.");

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al crear la sala: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sala = Sala::with('sillas', 'funciones.reservas')->findOrFail($id);
        
        // Contar sillas por tipo
        $sillasporTipo = $sala->sillas()->selectRaw('tipo, COUNT(*) as cantidad')
            ->groupBy('tipo')
            ->get();

        return view('salas.show', compact('sala', 'sillasporTipo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sala = Sala::findOrFail($id);
        return view('salas.edit', compact('sala'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sala = Sala::findOrFail($id);

        $validated = $request->validate([
            'nombre_sala' => 'required|string|unique:salas,nombre_sala,' . $id . '|max:255',
            'capacidad' => 'required|integer|min:10|max:1000'
        ]);

        $sala->update($validated);

        return redirect()->route('salas.show', $sala->id)
            ->with('success', 'Sala actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sala = Sala::findOrFail($id);
        
        // Verificar que no tenga funciones con reservas activas
        $reservasActivas = $sala->funciones()
            ->whereHas('reservas', function ($query) {
                $query->where('estado', '!=', 'cancelada');
            })
            ->count();

        if ($reservasActivas > 0) {
            return back()->withErrors(['error' => 'No se puede eliminar una sala con reservas activas.']);
        }

        $sala->delete();

        return redirect()->route('salas.index')
            ->with('success', 'Sala eliminada correctamente.');
    }
}
