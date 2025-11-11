<?php

// Espacio de nombres donde Laravel ubica los modelos.
namespace App\Models;

use Illuminate\Database\Eloquent\Model; // Clase base de todos los modelos de Eloquent ORM.

/**
 * Modelo que representa una reservación en el sistema.
 * Cada registro corresponde a una reserva hecha por un usuario para una función específica.
 */
class Reserva extends Model
{
    // Define explícitamente el nombre de la tabla en la base de datos.
    // Esto es necesario porque el nombre de la tabla ('reservaciones') no coincide con la convención de Laravel.
    protected $table = 'reservas';

    // Campos que pueden llenarse mediante asignación masiva (mass assignment).
    // Sirven cuando usas métodos como create() o update() para proteger el modelo de inyecciones no deseadas.
    protected $fillable = [
        'funcion_id',        // Identificador de la función reservada (clave foránea)
        'usuario_id',        // Identificador del usuario que hizo la reserva (clave foránea)
        'cantidad_asientos', // Número de asientos reservados
        'estado'             // Estado de la reserva (por ejemplo: confirmada, cancelada, pendiente, etc.)
    ];

    /**
     * Relación: una reserva pertenece a una función.
     * 
     * belongsTo → indica que este modelo (reservas) tiene una clave foránea (funcion_id)
     * que hace referencia al modelo "Funcion".
     */
    public function funcion()
    {
        return $this->belongsTo(Funcion::class, 'funcion_id');
    }

    /**
     * Relación: una reserva pertenece a un usuario.
     * 
     * belongsTo → indica que este modelo tiene una clave foránea (usuario_id)
     * que hace referencia al modelo "User".
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
