<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa la tabla 'confiteria' en la base de datos.
 * Cada instancia representa un producto de confitería (palomitas, bebidas, dulces, etc.)
 */
class Confiteria extends Model
{
    // Especifica el nombre de la tabla
    protected $table = 'confiteria';

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'imagen',
        'stock'
    ];
}
