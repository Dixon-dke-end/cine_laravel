<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class reservas extends Model
{
    protected $table  = 'reservaciones';

        protected $fillable=['funcion_id',   // referencia a la función reservada
                            'usuario_id',   // referencia al usuario
                            'cantidad_asientos',
                            'estado'
                        ];
    public function funciones()
    {
        return $this->belongsTo(Funcion::class,'funcion_id');
    }
    public function usuario()
    {
        return $this ->belongsTo(User::class,'usuario_id');
    }
}
 