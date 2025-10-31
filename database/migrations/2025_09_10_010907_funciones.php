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
    {Schema::create('funciones', function (Blueprint $table) {
    $table->id();
    $table->dateTime('hora');
    $table->foreignId('movie_id')->constrained('movies')->onDelete('cascade');
    $table->foreignId('sala_id')->constrained('salas')->onDelete('cascade');
    $table->timestamps();
});

}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funciones');
        
    }
};
