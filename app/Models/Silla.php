<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una silla individual en una sala de cine.
 * Cada silla es un registro independiente con su fila y número.
 */
class Silla extends Model
{
    protected $table = 'sillas';

    protected $fillable = [
        'sala_id',
        'fila',
        'numero',
        'tipo'
    ];

    /**
     * Relación: una silla pertenece a una sala.
     */
    public function sala()
    {
        return $this->belongsTo(Sala::class, 'sala_id');
    }

    /**
     * Relación: una silla puede estar en muchas reservas de sillas.
     */
    public function reservasSillas()
    {
        return $this->hasMany(ReservaSilla::class, 'silla_id');
    }

    /**
     * Verifica si la silla está ocupada para una función específica.
     * Solo considera reservas no canceladas y no expiradas.
     */
    public function estaOcupadaPara($funcionId)
    {
        return $this->reservasSillas()
            ->whereHas('reserva', function ($query) use ($funcionId) {
                $query->where('funcion_id', $funcionId)
                      ->where('estado', '!=', 'cancelada')
                      ->where(function($subQ) {
                          // Solo contar reservas confirmadas o pendientes que no expiraron
                          $subQ->where('estado', 'confirmada')
                              ->orWhere(function($pendingQ) {
                                  $pendingQ->where('estado', 'pendiente')
                                            ->where(function($expireQ) {
                                                $expireQ->whereNull('expires_at')
                                                        ->orWhere('expires_at', '>', now());
                                            });
                              });
                      });
            })
            ->exists();
    }

    /**
     * Obtiene el identificador legible de la silla (ej: "A1", "B5").
     */
    public function getNombreAttribute()
    {
        return $this->fila . $this->numero;
    }
}
