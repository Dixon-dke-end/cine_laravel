<?php

// Define el espacio de nombres del controlador.
// Esto indica que el archivo pertenece al grupo de controladores de la aplicación.
namespace App\Http\Controllers;

use Illuminate\Http\Request;  // Permite manejar las solicitudes HTTP que llegan al servidor.
use App\Models\Movie;         // Importa el modelo 'Movie', que representa la tabla de películas en la base de datos.

// Controlador que gestiona las vistas y funciones del usuario normal (no administrador).
class UserController extends Controller
{    
    /**
     * Muestra la vista principal del usuario con el listado de películas.
     */
    public function index()
    {
        // Obtiene las películas en cartelera
        $movies_cartelera = Movie::where('status', 'cartelera')->get();
        
        // Obtiene las películas próximamente
        $movies_proximamente = Movie::where('status', 'proximamente')->get();

        // Envía ambas colecciones a la vista 'user.index'.
        return view('user.index', [
            'movies' => $movies_cartelera,
            'proximamente' => $movies_proximamente
        ]);             
    }
}
