<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcion;
use App\Models\Movie;
use App\Models\Sala;

class funcionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todas las películas con sus funciones y salas
        $peliculas = Movie::with(['funciones.salas'])->get();
        // También obtener todas las funciones para casos especiales
        $funciones = Funcion::with(['movies', 'salas'])->orderBy('hora', 'asc')->get();
        return view('movies.funciones', compact('peliculas', 'funciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $peliculas = Movie::all();
        $salas = Sala::all();
        return view('movies.funciones_create', compact('peliculas', 'salas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los datos
        $validate = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'sala_id' => 'required|exists:salas,id',
            'hora' => 'required|date|after:now',
        ]);

        // Crear la función
        Funcion::create($validate);

        // Redirigir con mensaje de éxito
        return redirect()->route('funciones.index')->with('success', 'Función creada correctamente');
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
        $peliculas=Funcion::findOrFail($id);
        return view('movies.funciones_update',compact('peliculas'));

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
