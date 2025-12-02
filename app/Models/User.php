<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Modelo que representa a los usuarios del sistema.
 * Puede ser un administrador o un usuario normal según el campo 'role'.
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Campos que pueden asignarse de forma masiva.
     * Aquí definimos los datos básicos del usuario.
     */
    protected $fillable = [
        'name',     // Nombre del usuario
        'email',    // Correo electrónico
        'password', // Contraseña encriptada
        'role',     // Rol del usuario (por ejemplo: 'admin' o 'user')
    ];

    /**
     * Campos que deben permanecer ocultos cuando se serializa el modelo,
     * por ejemplo, al convertirlo en JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Define los tipos de datos para ciertos campos.
     * 'email_verified_at' es una fecha, y 'password' debe ser hasheada automáticamente.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación uno a muchos: un usuario puede tener muchas reservas.
     *
     * hasMany → significa que este modelo (User) está relacionado con muchos registros del modelo Reserva.
     * 'usuario_id' → es la clave foránea en la tabla 'reservaciones' que apunta al ID del usuario.
     */
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'usuario_id');
    }

    /**
     * Relación uno a muchos: un usuario puede tener muchos pedidos de confitería.
     *
     * hasMany → significa que este modelo (User) está relacionado con muchos registros del modelo PedidoConfiteria.
     * 'usuario_id' → es la clave foránea en la tabla 'pedido_confiterias' que apunta al ID del usuario.
     */
    public function pedidosConfiteria()
    {
        return $this->hasMany(PedidoConfiteria::class, 'usuario_id');
    }
}
