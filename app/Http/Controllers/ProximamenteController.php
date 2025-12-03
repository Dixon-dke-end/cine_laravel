<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProximamenteController extends Controller
{
    /**
     * Muestra un listado de películas próximamente.
     */
    public function index()
    {
        // Obtiene solo las películas con status 'proximamente'
        $movies = Movie::where('status', 'proximamente')->get();

        return view('user.proximamente', compact('movies'));
    }

    /**
     * Muestra el formulario para crear una nueva película próximamente.
     */
    public function create()
    {
        return view('proximamente.create');
    }

    /**
     * Guarda una nueva película próximamente en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de los datos
        $validate = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'duracion' => 'nullable|integer',
            'año' => 'nullable|integer',
            'autor' => 'nullable|string|max:255',
            'ruta_imagen' => 'image|mimes:jpg,png,jpeg,gif|max:2048',
            'trailer_url'=>'nullable|string',
            'age_suggest'=>'nullable|string',
            'genero'=>'nullable|string',
        ]);
        
        // Establecer status como 'proximamente'
        $validate['status'] = 'proximamente';

        // Si se envía una imagen, se guarda
        if ($request->hasFile('ruta_imagen')) {
            $rutaImagen = $request->file('ruta_imagen')->store('movies', 'public');
            $validate['ruta_imagen'] = $rutaImagen;
        }

        // Crear el registro
        Movie::create($validate);

        return redirect()->route('proximamente.admin')->with('success', 'Película agregada a Próximamente');
    }

    /**
     * Muestra el formulario para editar una película próximamente.
     */
    public function edit($id)
    {
        $registro = Movie::findOrFail($id);
        
        // Verificar que sea una película próximamente
        if ($registro->status !== 'proximamente') {
            return redirect()->route('proximamente.index')->with('error', 'Esta película no está en próximamente');
        }
        
        return view('proximamente.edit', compact('registro'));
    }

    /**
     * Actualiza los datos de una película próximamente.
     */
    public function update(Request $request, string $id)
    {
        $registro = Movie::findOrFail($id);
        
        // Verificar que sea una película próximamente
        if ($registro->status !== 'proximamente') {
            return redirect()->route('proximamente.index')->with('error', 'Esta película no está en próximamente');
        }

        // Validar los campos
        $validate = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'duracion' => 'nullable|integer',
            'año' => 'nullable|integer',
            'autor' => 'nullable|string|max:255',
            'ruta_imagen' => 'image|mimes:jpg,png,jpeg,gif|max:2048',
            'trailer_url'=>'nullable|string',
            'age_suggest'=>'nullable|string',
            'genero'=>'nullable|string',
        ]);

        // Mantener el status como proximamente
        $validate['status'] = 'proximamente';

        // Si se sube una nueva imagen
        if ($request->hasFile('ruta_imagen')) {
            // Eliminar imagen anterior si existe
            if ($registro->ruta_imagen) {
                Storage::disk('public')->delete($registro->ruta_imagen);
            }

            $rutaImagen = $request->file('ruta_imagen')->store('movies', 'public');
            $validate['ruta_imagen'] = $rutaImagen;
        }

        // Actualizar el registro
        $registro->update($validate);

        return redirect()->route('proximamente.index')->with('success', 'Película actualizada');
    }

    /**
     * Elimina una película próximamente de la base de datos.
     */
    public function destroy(string $id)
    {
        $registro = Movie::findOrFail($id);
        
        // Verificar que sea una película próximamente
        if ($registro->status !== 'proximamente') {
            return redirect()->route('proximamente.index')->with('error', 'Esta película no está en próximamente');
        }
        
        // Eliminar imagen si existe
        if ($registro->ruta_imagen) {
            Storage::disk('public')->delete($registro->ruta_imagen);
        }

        $registro->delete();

        return redirect()->route('proximamente.index')->with('success', 'Película eliminada');
    }
    
    /**
     * Promociona una película de próximamente a cartelera.
     */
    public function promoverACartelera(string $id)
    {
        $registro = Movie::findOrFail($id);
        
        // Verificar que sea una película próximamente
        if ($registro->status !== 'proximamente') {
            return redirect()->route('proximamente.index')->with('error', 'Esta película no está en próximamente');
        }
        
        // Cambiar status a cartelera
        $registro->update(['status' => 'cartelera']);
        
        return redirect()->route('movies.index')->with('success', 'Película promovida a cartelera exitosamente');
    }
     
    public function admin()
    {
        // Obtiene solo las películas con status 'proximamente'
        $movies = Movie::where('status', 'proximamente')->get();

        return view('proximamente.index', compact('movies'));
    }
}