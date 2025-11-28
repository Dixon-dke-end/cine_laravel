<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PedidoConfiteria extends Model
{
    use HasFactory;

    protected $table = 'pedido_confiterias';

    protected $fillable = [
        'usuario_id',
        'reserva_id',
        'subtotal',
        'cargo_servicio',
        'total',
        'estado',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime'
    ];

    /**
     * Relación con el usuario
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Relación con la reserva (opcional)
     */
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }

    /**
     * Relación con los productos del pedido
     */
    public function productos()
    {
        return $this->hasMany(PedidoProducto::class, 'pedido_id');
    }
}
