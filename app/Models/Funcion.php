<?php

// Define el espacio de nombres del modelo.
namespace App\Models;

use Illuminate\Database\Eloquent\Model;  // Clase base que permite usar Eloquent ORM.
use App\Models\Reserva;

// Modelo que representa la tabla 'funcions' (por convención de Laravel) en la base de datos.
// Cada objeto de esta clase corresponde a un registro de una función (horario o proyección de película).
    class Funcion extends Model
    {
        // Especifica explícitamente el nombre de la tabla.
        // Aunque Laravel lo deduce automáticamente (por convención), aquí se indica por claridad.
        protected $table = 'funciones';

        // Define los campos que pueden asignarse de forma masiva (mass assignment).
        // Esto evita errores de seguridad al crear o actualizar registros.
        protected $fillable = ['hora', 'movie_id', 'sala_id'];
        
    /**
     * Relación: una función pertenece a una película.
     * 
     * belongsTo → relación inversa de "una película tiene muchas funciones".
     * El segundo parámetro ('pelicula') indica la columna que actúa como clave foránea en la tabla 'funcions'.
     */
    public function movies()
    {
        return $this->belongsTo(Movie::class, 'movie_id'); 
    }

    /**
     * Relación: una función pertenece a una sala.
     * 
     * belongsTo → cada función ocurre en una sala específica.
     * El segundo parámetro ('sala_id') es la clave foránea que relaciona con la tabla 'salas'.
     */
    public function Sala()
    {
        return $this->belongsTo(Sala::class, 'sala_id');
    }

    /**
     * Relación: una función puede tener muchas reservas.
     * 
     * hasMany → relación directa de "una función tiene muchas reservas".
     * El segundo parámetro ('funcion_id') indica la clave foránea en la tabla 'reservaciones'.
     */
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'funcion_id');
    }
}
