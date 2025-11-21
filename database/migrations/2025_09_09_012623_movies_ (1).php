<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    { Schema::create('movies',function (blueprint $table){
        $table->id();
        $table->string('titulo');
        $table->text('descripcion')->nullable();
        $table->integer('duracion')->nullable();
        $table->string('trailer_url')->nullable(); 
        $table->year('año')->nullable();
        $table->string('autor')->nullable();
        $table->string('ruta_imagen')->nullable();
        $table->timestamps();
        $table->string('age_suggest')->default('G');
        $table->string('genero');

        
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
