<?php

// Define el espacio de nombres del modelo.
namespace App\Models;

use Illuminate\Database\Eloquent\Model; // Clase base de todos los modelos de Eloquent ORM.

// Modelo que representa la tabla 'movies' en la base de datos.
// Cada instancia de esta clase equivale a una película registrada en el sistema.
class Movie extends Model
{
    // Especifica explícitamente el nombre de la tabla.
    // Aunque Laravel lo deduce automáticamente (por convención), aquí se indica por claridad.
    protected $table = 'movies';

    // Define los campos que pueden asignarse masivamente (mass assignment).
    // Esto protege contra la asignación de campos no permitidos durante operaciones create() o update().
    protected $fillable = ['titulo', 'descripcion', 'duracion', 'año', 'autor', 'ruta_imagen','trailer_url','age_suggest','genero'];
    
    /**
     * Relación: una película puede tener muchas funciones (horarios de proyección).
     * 
     * hasMany → relación directa de "una película tiene muchas funciones".
     * El segundo parámetro ('pelicula') indica la clave foránea en la tabla 'funcions'
     * que referencia a esta película.
     */
    public function funciones()
    {
        return $this->hasMany(Funcion::class, 'movie_id');
    }
}
