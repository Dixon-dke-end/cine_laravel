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
    {
        Schema::create('sillas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sala_id')->constrained('salas')->onDelete('cascade');
            $table->char('fila', 1); // A, B, C, D...
            $table->integer('numero'); // 1, 2, 3, 4...
            $table->string('tipo')->default('regular'); // regular, premium, vip, etc.
            $table->timestamps();
            
            // Índice compuesto para evitar duplicados
            $table->unique(['sala_id', 'fila', 'numero']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sillas');
    }
};
