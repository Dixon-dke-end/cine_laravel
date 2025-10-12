<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class salas extends Model
{
            protected $fillable=['nombre_sala',   // referencia a la función reservada
                            'capacidad',   // referencia al usuario
                        ];
        public function funciones()
        {
            return $this->hasMany(Funcion::class,'sala');
        }

}
