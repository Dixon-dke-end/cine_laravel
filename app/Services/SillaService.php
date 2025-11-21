<?php

namespace App\Services;

use App\Models\Sala;
use App\Models\Silla;

/**
 * Servicio para gestionar la generación y distribución de sillas en una sala.
 * Permite crear diferentes distribuciones de sillas según el tipo de sala.
 */
class SillaService
{
    /**
     * Genera automáticamente las sillas para una sala.
     * 
     * @param Sala $sala
     * @param int $filas - Número de filas (A, B, C...)
     * @param int $columnas - Número de columnas (1, 2, 3...)
     * @param array $distribuciones - Distribuciones especiales por fila (opcional)
     *   Ejemplo: ['A' => 'vip', 'B' => 'premium', 'C-E' => 'regular']
     */
    public static function generarSillas(Sala $sala, $filas = 10, $columnas = 10, $distribuciones = [])
    {
        // Eliminar sillas existentes si las hay
        $sala->sillas()->delete();

        // Generar filas desde A hasta la letra correspondiente
        for ($i = 0; $i < $filas; $i++) {
            $fila = chr(65 + $i); // A, B, C, D...

            // Determinar tipo de silla para esta fila
            $tipo = self::determinaTipo($fila, $distribuciones);

            // Crear sillas para cada número en la fila
            for ($numero = 1; $numero <= $columnas; $numero++) {
                Silla::create([
                    'sala_id' => $sala->id,
                    'fila' => $fila,
                    'numero' => $numero,
                    'tipo' => $tipo
                ]);
            }
        }

        return $sala->sillas()->count();
    }

    /**
     * Determina el tipo de silla según la fila y las distribuciones configuradas.
     */
    private static function determinaTipo($fila, $distribuciones)
    {
        foreach ($distribuciones as $rango => $tipo) {
            if (strpos($rango, '-') !== false) {
                // Rango como "C-E"
                [$inicio, $fin] = explode('-', $rango);
                if ($fila >= $inicio && $fila <= $fin) {
                    return $tipo;
                }
            } else {
                // Fila individual
                if ($rango === $fila) {
                    return $tipo;
                }
            }
        }

        return 'regular';
    }

    /**
     * Obtiene la distribución recomendada según la capacidad de la sala.
     */
    public static function sugerirDistribucion($capacidad)
    {
        // Buscar factores cercanos
        $raiz = sqrt($capacidad);
        $filas = floor($raiz);
        $columnas = ceil($capacidad / $filas);

        return [
            'filas' => $filas,
            'columnas' => $columnas
        ];
    }

    /**
     * Genera una distribución estándar de 10x10 (100 sillas)
     */
    public static function distribucionEstandar()
    {
        return [
            'filas' => 10,
            'columnas' => 10
        ];
    }

    /**
     * Genera una distribución premium con asientos VIP y Premium
     * 
     * Ejemplo: Primeras 2 filas VIP, siguientes 3 Premium, resto Regular
     */
    public static function distribucionPremium()
    {
        return [
            'filas' => 10,
            'columnas' => 12,
            'distribuciones' => [
                'A-B' => 'vip',      // Primeras 2 filas VIP
                'C-E' => 'premium',  // Siguientes 3 filas Premium
                'F-J' => 'regular'   // Resto regular
            ]
        ];
    }
}
