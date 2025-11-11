<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una sala de cine.
 * Cada sala tiene un nombre y una capacidad,
 * y puede estar asociada a varias funciones (proyecciones).
 */
class Sala extends Model
{
    // Campos que pueden asignarse masivamente (mass assignment).
    protected $fillable = [
        'nombre_sala', // Nombre de la sala, por ejemplo: "Sala 1", "VIP", "IMAX", etc.
        'capacidad'    // Número máximo de personas que caben en la sala
    ];

    /**
     * Relación: una sala puede tener muchas funciones (proyecciones).
     *
     * hasMany → indica que el modelo "Sala" está relacionado con muchos registros del modelo "Funcion".
     * El segundo parámetro ('sala') es el nombre de la columna en la tabla "funcions" (clave foránea).
     */
    public function funciones()
    {
        return $this->hasMany(Funcion::class, 'sala_id');
    }
}

