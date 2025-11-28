<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    protected $fillable = [
        'titulo',
        'descripcion',
        'descuento',
        'codigo',
        'fecha_inicio',
        'fecha_fin',
        'imagen',
        'activo',
        'tipo'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'activo' => 'boolean',
        'descuento' => 'decimal:2',
        'tipo' => 'string'
    ];
}
