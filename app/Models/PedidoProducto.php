<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PedidoProducto extends Model
{
    use HasFactory;

    protected $table = 'pedido_productos';

    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'subtotal'
    ];

    /**
     * Relación con el pedido de confitería
     */
    public function pedido()
    {
        return $this->belongsTo(PedidoConfiteria::class, 'pedido_id');
    }

    /**
     * Relación con el producto de confitería
     */
    public function producto()
    {
        return $this->belongsTo(Confiteria::class, 'producto_id');
    }

    /**
     * Alias para la relación producto (para usar en eager loading)
     */
    public function confiteria()
    {
        return $this->belongsTo(Confiteria::class, 'producto_id');
    }
}
