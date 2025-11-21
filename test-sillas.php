#!/usr/bin/env php
<?php
/**
 * Script de prueba para verificar que las sillas se guardan correctamente
 * 
 * Uso: php test-sillas.php
 */

require_once __DIR__ . '/bootstrap/app.php';

use App\Models\Reserva;
use App\Models\ReservaSilla;
use App\Models\Funcion;
use App\Models\Silla;
use App\Models\User;

// Obtener la aplicación
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║         TEST: Verificar Guardado de Sillas en BD               ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

try {
    // 1. Verificar que existen funciones
    echo "📋 [1] Verificando funciones...\n";
    $funciones = Funcion::count();
    echo "   ✅ Funciones encontradas: $funciones\n\n";

    // 2. Verificar sillas
    echo "📍 [2] Verificando sillas en BD...\n";
    $totalSillas = Silla::count();
    echo "   ✅ Total sillas: $totalSillas\n\n";

    // 3. Verificar reservas
    echo "📦 [3] Verificando reservas...\n";
    $totalReservas = Reserva::count();
    $totalReservasSillas = ReservaSilla::count();
    echo "   ✅ Reservas: $totalReservas\n";
    echo "   ✅ Registros en reservas_sillas: $totalReservasSillas\n\n";

    // 4. Verificar sillas ocupadas
    echo "🎫 [4] Verificando sillas ocupadas por función...\n";
    $funcion = Funcion::first();
    if ($funcion) {
        $sillasOcupadas = Silla::where('sala_id', $funcion->sala_id)
            ->whereHas('reservasSillas', function ($query) use ($funcion) {
                $query->whereHas('reserva', function ($q) use ($funcion) {
                    $q->where('funcion_id', $funcion->id)
                      ->where('estado', '!=', 'cancelada');
                });
            })
            ->count();
        
        echo "   Función: " . $funcion->movies->titulo . "\n";
        echo "   Sala: " . $funcion->sala->nombre_sala . "\n";
        echo "   ✅ Sillas ocupadas: $sillasOcupadas\n\n";
    }

    // 5. Prueba del método estaOcupadaPara
    echo "🔍 [5] Probando método estaOcupadaPara()...\n";
    if ($funcion && $totalReservasSillas > 0) {
        $primeraReserva = ReservaSilla::first();
        $silla = $primeraReserva->silla;
        $ocupada = $silla->estaOcupadaPara($funcion->id);
        
        echo "   Silla: " . $silla->fila . $silla->numero . "\n";
        echo "   ✅ Está ocupada: " . ($ocupada ? 'SÍ (TRUE)' : 'NO (FALSE)') . "\n\n";
    }

    // 6. Resumen final
    echo "╔════════════════════════════════════════════════════════════════╗\n";
    echo "║                    ✅ VERIFICACIÓN COMPLETA                   ║\n";
    echo "╠════════════════════════════════════════════════════════════════╣\n";
    echo "║ Funciones:             $funciones\n";
    echo "║ Sillas totales:        $totalSillas\n";
    echo "║ Reservas:             $totalReservas\n";
    echo "║ Relaciones guardadas:  $totalReservasSillas\n";
    echo "║                                                                ║\n";
    
    if ($totalReservasSillas > 0) {
        echo "║ Estado: 🟢 SILLAS SE ESTÁN GUARDANDO CORRECTAMENTE          ║\n";
    } else {
        echo "║ Estado: 🔴 NO HAY SILLAS GUARDADAS AÚN                      ║\n";
    }
    
    echo "╚════════════════════════════════════════════════════════════════╝\n\n";

} catch (\Exception $e) {
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo "Línea: " . $e->getLine() . "\n";
    echo "Archivo: " . $e->getFile() . "\n\n";
}

echo "Para más detalles, revisa: COMO_GUARDAR_SILLAS_EN_BD.md\n\n";
?>
