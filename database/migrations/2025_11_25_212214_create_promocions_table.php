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
        Schema::create('promocions', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion');
            $table->decimal('descuento', 8, 2)->nullable();
            $table->string('codigo')->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('imagen')->nullable();
            $table->boolean('activo')->default(true);
            $table->string('tipo')->default('general');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promocions');
    }
};
