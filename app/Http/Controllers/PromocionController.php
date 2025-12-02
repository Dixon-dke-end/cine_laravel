<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PromocionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promociones = \App\Models\Promocion::all();
        return view('promociones.index', compact('promociones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('promociones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'descuento' => 'nullable|numeric',
            'codigo' => 'nullable|string|max:50',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'activo' => 'required|boolean',
            'tipo' => 'required|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('promociones', 'public');
            $data['imagen'] = $path;
        }

        \App\Models\Promocion::create($data);

        return redirect()->route('promociones.index')->with('success', 'Promoción creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $promocion = \App\Models\Promocion::findOrFail($id);
        return view('promociones.edit', compact('promocion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $promocion = \App\Models\Promocion::findOrFail($id);

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'descuento' => 'nullable|numeric',
            'codigo' => 'nullable|string|max:50',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'activo' => 'required|boolean',
            'tipo' => 'required|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('imagen')) {
            // Delete old image if exists
            if ($promocion->imagen) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($promocion->imagen);
            }
            $path = $request->file('imagen')->store('promociones', 'public');
            $data['imagen'] = $path;
        }

        $promocion->update($data);

        return redirect()->route('promociones.index')->with('success', 'Promoción actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $promocion = \App\Models\Promocion::findOrFail($id);
        if ($promocion->imagen) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($promocion->imagen);
        }
        $promocion->delete();

        return redirect()->route('promociones.index')->with('success', 'Promoción eliminada exitosamente.');
    }
        public function user()
    {
        $promociones = \App\Models\Promocion::all();
        return view('user.promociones', compact('promociones'));
    }

    public function detalles($id)
    {
        $promocion = \App\Models\Promocion::findOrFail($id);
        return view('user.promocion_detalles', compact('promocion'));
    }
}
