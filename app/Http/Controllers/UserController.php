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
        // Obtiene todos los registros de películas desde la base de datos.
        // Usa Eloquent (ORM de Laravel) para ejecutar el equivalente a "SELECT * FROM movies".
        $var_movies = Movie::all();

        // Envía las películas obtenidas a la vista 'user.index'.
        // La vista podrá acceder a ellas mediante la variable 'movies'.
        return view('user.index', ['movies' => $var_movies]);             
    }
}
