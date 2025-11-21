<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reservas', function (Blueprint $table) {
            // Campos de pago
            $table->enum('metodo_pago', ['mercado_pago', 'stripe', 'efectivo', 'tarjeta'])->nullable()->after('estado');
            $table->string('pago_id')->nullable()->after('metodo_pago'); // ID de transacción
            $table->enum('estado_pago', ['pendiente', 'aprobado', 'rechazado', 'reembolsado'])->default('pendiente')->after('pago_id');
            $table->timestamp('fecha_pago')->nullable()->after('estado_pago');
            $table->text('detalles_pago')->nullable()->after('fecha_pago'); // JSON con info adicional
        });
    }

    public function down()
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropColumn([
                'metodo_pago',
                'pago_id',
                'estado_pago',
                'fecha_pago',
                'detalles_pago'
            ]);
        });
    }
};