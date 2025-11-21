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
        Schema::table('reservas', function (Blueprint $table) {
            // Agregar columna asientos como JSON (array de strings: "A1", "A2", etc)
            $table->json('asientos')->nullable()->after('cantidad_asientos');
            
            // Agregar columna precio_total
            $table->decimal('precio_total', 8, 2)->default(0)->after('asientos');
            
            // Cambiar el estado por defecto a 'pendiente' en lugar de 'confirmada'
            // Luego se confirma después del pago
            $table->string('estado')->default('pendiente')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropColumn(['asientos', 'precio_total']);
        });
    }
};
