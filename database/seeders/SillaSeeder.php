<?php

namespace Database\Seeders;

use App\Models\Sala;
use App\Models\Funcion;
use App\Models\Movie;
use App\Services\SillaService;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SillaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Crea datos de prueba para salas, películas, funciones y sillas.
     */
    public function run(): void
    {
        // 1. Crear Películas (si no existen)
        $pelicula1 = Movie::firstOrCreate(
            ['titulo' => 'Avatar 3'],
            ['duracion' => 180, 'genero' => 'Sci-Fi']
        );

        $pelicula2 = Movie::firstOrCreate(
            ['titulo' => 'Oppenheimer'],
            ['duracion' => 180, 'genero' => 'Drama']
        );

        // 2. Crear Salas con distribuciones diferentes

        // Sala 1: Estándar (10x10 = 100 sillas)
        $sala1 = Sala::firstOrCreate(
            ['nombre_sala' => 'Sala Regular'],
            ['capacidad' => 100]
        );
        SillaService::generarSillas($sala1, 10, 10);
        echo "✅ Sala Regular: 100 sillas creadas\n";

        // Sala 2: Premium (10x12 con VIP/Premium/Regular)
        $sala2 = Sala::firstOrCreate(
            ['nombre_sala' => 'Sala Premium'],
            ['capacidad' => 120]
        );
        $config = SillaService::distribucionPremium();
        SillaService::generarSillas($sala2, $config['filas'], $config['columnas'], $config['distribuciones']);
        echo "✅ Sala Premium: 120 sillas creadas (VIP + Premium + Regular)\n";

        // Sala 3: VIP (7x10 = 70 sillas, todas VIP)
        $sala3 = Sala::firstOrCreate(
            ['nombre_sala' => 'Sala VIP'],
            ['capacidad' => 70]
        );
        SillaService::generarSillas($sala3, 7, 10, ['A-G' => 'vip']);
        echo "✅ Sala VIP: 70 sillas creadas (todas VIP)\n";

        // 3. Crear Funciones (horarios)

        // Función 1: Avatar 3 - Sala Regular - Hoy a las 14:00
        Funcion::firstOrCreate(
            [
                'movie_id' => $pelicula1->id,
                'sala_id' => $sala1->id,
                'hora' => Carbon::today()->addHours(14)->toDateTimeString()
            ]
        );

        // Función 2: Avatar 3 - Sala Regular - Hoy a las 18:00
        Funcion::firstOrCreate(
            [
                'movie_id' => $pelicula1->id,
                'sala_id' => $sala1->id,
                'hora' => Carbon::today()->addHours(18)->toDateTimeString()
            ]
        );

        // Función 3: Oppenheimer - Sala Premium - Hoy a las 14:00
        Funcion::firstOrCreate(
            [
                'movie_id' => $pelicula2->id,
                'sala_id' => $sala2->id,
                'hora' => Carbon::today()->addHours(14)->toDateTimeString()
            ]
        );

        // Función 4: Oppenheimer - Sala VIP - Hoy a las 20:00
        Funcion::firstOrCreate(
            [
                'movie_id' => $pelicula2->id,
                'sala_id' => $sala3->id,
                'hora' => Carbon::today()->addHours(20)->toDateTimeString()
            ]
        );

        echo "✅ Funciones creadas\n";
        echo "\n🎬 Base de datos poblada con datos de prueba\n";
    }
}
