<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcion extends Model
{
        protected $fillable=['hora','pelicula','sala'];
        
        public function  movies()
        {
               return $this->belongsTo (Movie::class,'pelicula'); 
        }
        public function salas()
        {
                return $this->belongsTo(Sala::class,'sala');
        }
        public function reservas()
        {
                return $this->hasMany(Reserva::class,'funcion_id');
        }

}       
