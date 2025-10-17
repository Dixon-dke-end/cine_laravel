<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\Storage;
class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $var_movies=Movie::all();
        return view('movies.index',['movies'=>$var_movies]);            
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('movies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate=$request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'duracion'=>'nullable|integer',
            'año'=>'nullable|integer',
            'autor'=>'nullable|string|max:255',
            'ruta_imagen'=>'image|mimes:jpg,png,jpeg,gif|max:2048'
        ]);

if ($request->hasFile('ruta_imagen')) {
    $rutaImagen = $request->file('ruta_imagen')->store('movies', 'public');
    $validate['ruta_imagen'] = $rutaImagen;
}

Movie::create($validate);

return redirect()->route('movies.index')->with('success', 'Película creada correctamente');

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
    public function edit($id)
    {
        $registro=Movie::findOrFail($id);
        return view('movies.edit',compact('registro'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $registro=Movie::findOrFail($id);
        $registro->update($request->all());

            $validate=$request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'duracion'=>'nullable|integer',
            'año'=>'nullable|integer',
            'autor'=>'nullable|string|max:255',
            'ruta_imagen'=>'image|mimes:jpg,png,jpeg,gif|max:2048'
        ]);
            if ($request->hasFile('imagen')) {
        // Borrar la imagen vieja si existe
        if ($registro->ruta_imagen) {
            Storage::disk('public')->delete($registro->ruta_imagen);
        }
              // Guardar la nueva
        $rutaImagen = $request->file('imagen')->store('movies', 'public');
        $validate['ruta_imagen'] = $rutaImagen;
    }
           $registro->update($validate);
        return redirect()->route('movies.index')->with('success','pelicula actualizada');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $registro=Movie::findOrFail($id);
        $registro->delete();
         return redirect()->route('movies.index')->with('success', 'Película eliminada');
    }
}
