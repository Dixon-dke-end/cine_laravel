<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table  = 'movies';

    protected $fillable=['titulo','descripcion','duracion','año','autor','ruta_imagen'];
    
    public function funciones()
        {
                return $this ->hasMany(Funcion::class,'pelicula');
        }
}
