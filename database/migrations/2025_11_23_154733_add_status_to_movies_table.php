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
        Schema::table('movies', function (Blueprint $table) {
            // Agregar campo status con valor por defecto 'cartelera'
            // Valores permitidos: 'cartelera', 'proximamente'
            $table->string('status')->default('cartelera')->after('genero');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            // Eliminar campo status si se deshace la migración
            $table->dropColumn('status');
        });
    }
};
