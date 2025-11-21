<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa la relación entre una reserva y una silla específica.
 * Conecta usuarios, funciones y sillas en una tabla de unión mejorada.
 */
class ReservaSilla extends Model
{
    protected $table = 'reservas_sillas';

    protected $fillable = [
        'reserva_id',
        'silla_id'
    ];

    /**
     * Relación: una reserva_silla pertenece a una reserva.
     */
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }

    /**
     * Relación: una reserva_silla pertenece a una silla.
     */
    public function silla()
    {
        return $this->belongsTo(Silla::class, 'silla_id');
    }
}
