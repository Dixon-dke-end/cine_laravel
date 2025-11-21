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
        'asientos',          // Array JSON con los asientos seleccionados ["A1", "A2", etc]
        'precio_total',      // Precio total de la reserva
        'estado',            // Estado de la reserva (pendiente, confirmada, cancelada, etc.)
        'metodo_pago',      
        'pago_id',          
        'estado_pago',      
        'fecha_pago',       
        'detalles_pago',
        'expires_at'
    ];

    /**
     * Conversión de tipos (casting)
     * Convierte automáticamente el JSON a array y viceversa
     */
    protected $casts = [
        'asientos' => 'array', // Convertir JSON a array automáticamente
         'expires_at' => 'datetime',
        'fecha_pago' => 'datetime',
        'detalles_pago' => 'array',
        'precio_total' => 'decimal:2'
    ];
    public function hasExpired()
    {
        return $this->expires_at && now()->greaterThan($this->expires_at);
    }

    // Método para verificar si está activa
    public function isActive()
    {
        return $this->estado === 'confirmada' || 
            ($this->estado === 'pendiente' && !$this->hasExpired());
    }
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

    /**
     * Relación: una reserva puede tener muchas sillas reservadas.
     *
     * hasMany → cada reserva puede incluir múltiples sillas específicas.
     */
    public function sillas()
    {
        return $this->hasMany(ReservaSilla::class, 'reserva_id');
    }
}
