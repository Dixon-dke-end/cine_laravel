<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;
use App\Models\Funcion;
use App\Models\Reserva;
use App\Models\User;
use App\Models\PedidoConfiteria;
use App\Models\PedidoProducto;
use App\Models\Confiteria;
use Carbon\Carbon;

class ReportesTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Genera datos de prueba para reportes mensuales:
     * - 3 películas con status 'cartelera'
     * - 4 funciones por película (diferentes días de diciembre 2024)
     * - 2-3 reservas confirmadas por función
     * - Pedidos de confitería asociados
     */
    public function run(): void
    {
        // Obtener usuario admin para asignar reservas
        $admin = User::where('email', 'peraltadixon5@gmail.com')->first();
        
        if (!$admin) {
            $this->command->error('Usuario admin no encontrado. Ejecuta AdminSeeder primero.');
            return;
        }

        $this->command->info('🎬 Creando películas de prueba...');

        // ============================================
        // PELÍCULAS
        // ============================================
        
        $peliculas = [
            [
                'titulo' => 'Interstellar',
                'descripcion' => 'Un grupo de exploradores viaja a través de un agujero de gusano en el espacio en un intento de asegurar la supervivencia de la humanidad.',
                'duracion' => 169,
                'año' => 2024,
                'autor' => 'Christopher Nolan',
                'genero' => 'Ciencia Ficción',
                'age_suggest' => '13+',
                'trailer_url' => 'https://www.youtube.com/watch?v=zSWdZVtXT7E',
                'ruta_imagen' => 'movies/interstellar.jpg',
                'status' => 'cartelera'
            ],
            [
                'titulo' => 'Barbie',
                'descripcion' => 'Barbie vive en Barbieland donde todo es perfecto. Cuando empieza a cuestionarse su existencia, viaja al mundo real en una aventura de autodescubrimiento.',
                'duracion' => 114,
                'año' => 2024,
                'autor' => 'Greta Gerwig',
                'genero' => 'Comedia/Fantasía',
                'age_suggest' => 'Todos',
                'trailer_url' => 'https://www.youtube.com/watch?v=pBk4NYhWNMM',
                'ruta_imagen' => 'movies/barbie.jpg',
                'status' => 'cartelera'
            ],
            [
                'titulo' => 'Dune: Parte Dos',
                'descripcion' => 'Paul Atreides se une a Chani y los Fremen mientras busca venganza contra los conspiradores que destruyeron a su familia.',
                'duracion' => 166,
                'año' => 2024,
                'autor' => 'Denis Villeneuve',
                'genero' => 'Ciencia Ficción',
                'age_suggest' => '13+',
                'trailer_url' => 'https://www.youtube.com/watch?v=Way9Dexny3w',
                'ruta_imagen' => 'movies/dune2.jpg',
                'status' => 'cartelera'
            ]
        ];

        $peliculasCreadas = collect();
        foreach ($peliculas as $peliculaData) {
            $pelicula = Movie::create($peliculaData);
            $peliculasCreadas->push($pelicula);
            $this->command->info("  ✓ Creada: {$pelicula->titulo}");
        }

        $this->command->info('📅 Creando funciones...');

        // ============================================
        // FUNCIONES (4 por película)
        // ============================================
        
        // Fechas de diciembre 2024
        $fechas = [
            Carbon::create(2024, 12, 5),  // 5 de diciembre
            Carbon::create(2024, 12, 10), // 10 de diciembre
            Carbon::create(2024, 12, 15), // 15 de diciembre
            Carbon::create(2024, 12, 20)  // 20 de diciembre
        ];

        // Horarios variados
        $horarios = [
            '14:00:00', // Matinée
            '17:30:00', // Tarde
            '20:00:00', // Noche
            '22:30:00'  // Noche tardía
        ];

        $funcionesCreadas = [];
        foreach ($peliculasCreadas as $index => $pelicula) {
            foreach ($fechas as $fechaIndex => $fecha) {
                // Rotar salas (1, 2, 3)
                $salaId = ($index % 3) + 1;
                
                // Combinar fecha con horario
                $fechaHora = $fecha->copy()->setTimeFromTimeString($horarios[$fechaIndex]);
                
                $funcion = Funcion::create([
                    'movie_id' => $pelicula->id,
                    'sala_id' => $salaId,
                    'hora' => $fechaHora
                ]);
                
                $funcionesCreadas[] = $funcion;
                $this->command->info("  ✓ Función: {$pelicula->titulo} - {$fechaHora->format('d/m/Y H:i')} - Sala {$salaId}");
            }
        }

        $this->command->info('🎫 Creando reservas confirmadas...');

        // ============================================
        // RESERVAS (2-3 por función)
        // ============================================
        
        $totalReservas = 0;
        $totalBoletos = 0;
        $totalIngresos = 0;

        foreach ($funcionesCreadas as $funcion) {
            // Generar 2-3 reservas por función
            $numReservas = rand(2, 3);
            
            for ($i = 0; $i < $numReservas; $i++) {
                // Cantidad de asientos (2-5)
                $cantidadAsientos = rand(2, 5);
                
                // Precio por asiento ($100-$150)
                $precioPorAsiento = rand(100, 150);
                $precioTotal = $cantidadAsientos * $precioPorAsiento;
                
                // Generar array de asientos simulados
                $asientos = [];
                $filas = ['A', 'B', 'C', 'D', 'E'];
                for ($j = 0; $j < $cantidadAsientos; $j++) {
                    $fila = $filas[array_rand($filas)];
                    $numero = rand(1, 10);
                    $asientos[] = "{$fila}{$numero}";
                }
                
                // Fecha de pago (1 día antes de la función)
                $fechaPago = $funcion->hora->copy()->subDay();
                
                $reserva = Reserva::create([
                    'funcion_id' => $funcion->id,
                    'usuario_id' => $admin->id,
                    'cantidad_asientos' => $cantidadAsientos,
                    'asientos' => $asientos,
                    'precio_total' => $precioTotal,
                    'estado' => 'confirmada',
                    'metodo_pago' => 'mercado_pago',
                    'estado_pago' => 'aprobado',
                    'pago_id' => 'TEST_' . uniqid(),
                    'fecha_pago' => $fechaPago,
                    'detalles_pago' => [
                        'payment_id' => 'TEST_' . uniqid(),
                        'status' => 'approved',
                        'transaction_amount' => $precioTotal
                    ]
                ]);
                
                $totalReservas++;
                $totalBoletos += $cantidadAsientos;
                $totalIngresos += $precioTotal;
            }
        }

        $this->command->info("  ✓ {$totalReservas} reservas creadas");
        $this->command->info("  ✓ {$totalBoletos} boletos vendidos");
        $this->command->info("  ✓ \${$totalIngresos} MXN en ingresos");

        // ============================================
        // PEDIDOS DE CONFITERÍA (Opcional) - DESHABILITADO
        // ============================================
        
        // $this->command->info('🍿 Creando pedidos de confitería...');
        // Sección deshabilitada por compatibilidad de esquema
        // Las reservas de películas ya están creadas exitosamente
        
        // Confitionery data generation disabled due to schema compatibility issues
        // The main data (movies, functions, and reservations) is complete

        // ============================================
        // RESUMEN
        // ============================================
        
        $this->command->info('');
        $this->command->info('✅ Datos de prueba creados exitosamente:');
        $this->command->info("   • {$peliculasCreadas->count()} películas");
        $this->command->info("   • " . count($funcionesCreadas) . " funciones");
        $this->command->info("   • {$totalReservas} reservas confirmadas");
        $this->command->info("   • {$totalBoletos} boletos vendidos");
        $this->command->info("   • \${$totalIngresos} MXN en ingresos de boletos");
        $this->command->info('');
        $this->command->info('📊 Ahora puedes generar reportes para Diciembre 2024');
    }
}
