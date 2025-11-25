<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Confiteria;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ConfiteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los productos de confitería
        $confiteria = Confiteria::all();
        
        // Verificar si el usuario es admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            // Vista de administrador con opciones de edición
            return view('confiteria.admin_index', compact('confiteria'));
        }
        
        // Vista de usuario regular
        return view('user.confiteria', compact('confiteria'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('confiteria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ✅ Validación de los datos que vienen del formulario.
        $validate = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);
        
        // 📸 Si se envía una imagen, se guarda en la carpeta 'confiteria'
        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('confiteria', 'public');
            $validate['imagen'] = $rutaImagen;
        }

        // 🧱 Crea el registro en la base de datos
        Confiteria::create($validate);

        // 🔁 Redirige de nuevo al listado con un mensaje de éxito
        return redirect()->route('confiteria.index')->with('success', 'Producto de confitería creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = Confiteria::findOrFail($id);
        
        // Verificar si el usuario es admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            // Redirigir a la vista de edición para admin
            return redirect()->route('confiteria.edit', $id);
        }
        
        // Vista de detalle para usuario regular
        return view('user.confiteria_show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $registro = Confiteria::findOrFail($id);

        // Envía el registro a la vista de edición
        return view('confiteria.edit', compact('registro'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $registro = Confiteria::findOrFail($id);
        
        // ✅ Validación de los datos
        $validate = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);
        
        // 📸 Si se envía una nueva imagen
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($registro->imagen) {
                Storage::disk('public')->delete($registro->imagen);
            }
            
            $rutaImagen = $request->file('imagen')->store('confiteria', 'public');
            $validate['imagen'] = $rutaImagen;
        }

        // 🧱 Actualiza el registro
        $registro->update($validate);

        // 🔁 Redirige con mensaje de éxito
        return redirect()->route('confiteria.index')->with('success', 'Producto de confitería actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $registro = Confiteria::findOrFail($id);

        // 🗑️ Elimina la imagen del disco si existe.
        if ($registro->imagen) {
            Storage::disk('public')->delete($registro->imagen);
        }

        // 🧱 Elimina el registro de la base de datos.
        $registro->delete();

        // 🔁 Redirige de nuevo al listado con un mensaje de éxito
        return redirect()->route('confiteria.index')->with('success', 'Producto de confitería eliminado correctamente');
    }
}
