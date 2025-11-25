<?php

// Definimos el espacio de nombres del controlador.
// Esto permite a Laravel ubicarlo correctamente dentro de la estructura del proyecto.
namespace App\Http\Controllers;

use Illuminate\Http\Request;             // Permite manejar las peticiones HTTP (formularios, archivos, etc.)
use App\Models\Movie;                    // Importa el modelo Movie, que interactúa con la base de datos.
use Illuminate\Support\Facades\Storage;  // Permite manipular archivos (guardar, eliminar, etc.) en el almacenamiento.

class MovieController extends Controller
{
    /**
     * Muestra un listado de todas las películas almacenadas.
     */
    public function index()
    {
        // Obtiene solo las películas en cartelera (no próximamente)
        $var_movies = Movie::where('status', 'cartelera')->get();

        // Envía los datos obtenidos a la vista 'movies.index'.
        // 'movies' es la variable que la vista usará para mostrar las películas.
        return view('movies.index', ['movies' => $var_movies]);            
    }

    /**
     * Muestra el formulario para crear una nueva película.
     */
    public function create()
    {
        // Simplemente carga la vista 'movies.create', donde estará el formulario de creación.
        return view('movies.create');
    }

    /**
     * Guarda una nueva película en la base de datos.
     */
    public function store(Request $request)
    {
        // ✅ Validación de los datos que vienen del formulario.
        // Se asegura de que los campos tengan el tipo correcto y que la imagen cumpla los requisitos.
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
        
        // Establecer status por defecto como 'cartelera'
        $validate['status'] = 'cartelera';        

        // 📸 Si se envía una imagen, se guarda en la carpeta 'movies' dentro del disco 'public'.
        // Luego se agrega la ruta del archivo al arreglo validado.
        if ($request->hasFile('ruta_imagen')) {
            $rutaImagen = $request->file('ruta_imagen')->store('movies', 'public');
            $validate['ruta_imagen'] = $rutaImagen;
        }

        // 🧱 Crea el registro en la base de datos con los datos validados (incluyendo la imagen si existe).
        Movie::create($validate);

        // 🔁 Redirige de nuevo al listado de películas con un mensaje de éxito.
        return redirect()->route('movies.index')->with('success', 'Película creada correctamente');
    }

    /**
     * Muestra los detalles de una película específica con sus funciones disponibles.
     */
    public function show($movieId) {
        $movie = Movie::findOrFail($movieId);
        
        // ✅ SOLUCIÓN: Cargar solo funciones desde HOY en adelante (próximos 14 días)
        $fechaHoy = \Carbon\Carbon::now()->startOfDay();
        $fechaFinal = \Carbon\Carbon::now()->addDays(14)->endOfDay();
        
        $funciones = Funcion::where('movie_id', $movieId)
            ->whereBetween('hora', [$fechaHoy, $fechaFinal])
            ->with(['sala'])
            ->orderBy('hora', 'asc')
            ->get();
        
        return view('funciones.show', compact('movie', 'funciones'));
    }

    /**
     * Muestra el formulario para editar una película existente.
     */
    public function edit($id)
    {
        // Busca la película según el ID o lanza un error 404 si no existe.
        $registro = Movie::findOrFail($id);

        // Envía el registro a la vista 'movies.edit' para mostrar el formulario con los datos cargados.
        return view('movies.edit', compact('registro'));
    }

    /**
     * Actualiza los datos de una película existente.
     */
    public function update(Request $request, string $id)
    {
        // Busca el registro que se va a actualizar.
        $registro = Movie::findOrFail($id);

        // Actualiza los datos directamente (aunque se revalida más abajo).
        $registro->update($request->all());

        // ✅ Valida nuevamente los campos (esto debería hacerse antes del update real).
        $validate = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'duracion' => 'nullable|integer',
            'año' => 'nullable|integer',
            'autor' => 'nullable|string|max:255',
            'ruta_imagen' => 'image|mimes:jpg,png,jpeg,gif|max:2048'
        ]);

        // 📸 Si se sube una nueva imagen:
        if ($request->hasFile('imagen')) {
            // Si la película ya tenía una imagen anterior, se elimina del almacenamiento.
            if ($registro->ruta_imagen) {
                Storage::disk('public')->delete($registro->ruta_imagen);
            }

            // Se guarda la nueva imagen en la carpeta 'movies' y se actualiza la ruta.
            $rutaImagen = $request->file('imagen')->store('movies', 'public');
            $validate['ruta_imagen'] = $rutaImagen;
        }

        // 🧱 Se aplican los nuevos valores (incluyendo la posible nueva imagen).
        $registro->update($validate);

        // 🔁 Redirige a la lista con un mensaje confirmando la actualización.
        return redirect()->route('movies.index')->with('success', 'película actualizada');
    }

    /**
     * Elimina una película de la base de datos.
     */
    public function destroy(string $id)
    {
        // Busca el registro que se desea eliminar.
        $registro = Movie::findOrFail($id);

        // Elimina el registro de la base de datos.
        $registro->delete();

        // Redirige con un mensaje de confirmación.
        return redirect()->route('movies.index')->with('success', 'Película eliminada');
    }
    public function getFuncionesPorFecha(Request $request, $movieId)
{
    try {
        $fecha = $request->query('fecha');
        
        // Validar que la fecha existe
        if (!$fecha) {
            return response()->json([
                'success' => false,
                'message' => 'Fecha no proporcionada'
            ], 400);
        }
        
        // Obtener funciones
        $funciones = \App\Models\Funcion::where('movie_id', $movieId)
            ->whereDate('hora', $fecha)
            ->with(['sala'])
            ->orderBy('hora', 'asc')
            ->get();
        
        if ($funciones->isEmpty()) {
            return response()->json([
                'success' => true,
                'empty' => true
            ]);
        }

        foreach ($funciones as $funcion) {
            if ($funcion->hora < now()) {
            return response()->json([
                'success' => true,
                'empty' => true
            ]);
             }
        }
        
        // Agrupar por nombre de sala
        $salasPorFecha = $funciones->groupBy('sala.nombre_sala');
        
        $html = '';
        
        foreach ($salasPorFecha as $salaNombre => $funcionesSala) {
            $html .= '<div class="cinema-card">';
            $html .= '<div class="cinema-info">';
            $html .= '<div class="cinema-name">🎭 ' . htmlspecialchars($salaNombre) . '</div>';
            $html .= '<div class="cinema-address">📍 Sala Principal</div>';
            $html .= '</div>';
            $html .= '<div class="showtimes-grid">';
            
            foreach ($funcionesSala as $funcion) {
                $hora = \Carbon\Carbon::parse($funcion->hora)->format('H:i');
                
                $html .= '<button class="showtime-btn" onclick="reservarFuncion(' . $funcion->id . ')">';
                $html .= '<span class="showtime-time">' . $hora . '</span>';
                $html .= '<span class="showtime-room">Sala ' . $funcion->sala_id . '</span>';
                $html .= '</button>';
            }
            
            $html .= '</div>';
            $html .= '</div>';
        }
        
        return response()->json([
            'success' => true,
            'html' => $html,
            'empty' => false
        ]);
        
    } catch (\Exception $e) {
        // Log del error para debugging
        \Log::error('Error en getFuncionesPorFecha: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Error al cargar funciones',
            'error' => $e->getMessage()
        ], 500);
    }
}


}