<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Funcion;
use App\Models\Reserva;
use App\Models\PedidoConfiteria;
use App\Models\PedidoProducto;
use App\Models\Confiteria;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportesController extends Controller
{
    /**
     * Muestra la vista principal de reportes
     */
    public function index()
    {
        // Obtener mes y año actuales como valores por defecto
        $mesActual = now()->month;
        $añoActual = now()->year;
        
        return view('reportes.index', [
            'mesActual' => $mesActual,
            'añoActual' => $añoActual
        ]);
    }

    /**
     * Genera el reporte mensual consolidado
     */
    public function generarReporte(Request $request)
    {
        $request->validate([
            'mes' => 'required|integer|min:1|max:12',
            'año' => 'required|integer|min:2020|max:2030'
        ]);

        $mes = $request->mes;
        $año = $request->año;

        // Calcular inicio y fin del mes
        $inicio = Carbon::create($año, $mes, 1)->startOfMonth();
        $fin = Carbon::create($año, $mes, 1)->endOfMonth();

        // Obtener nombre del mes en español
        $nombresMeses = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];

        // === PELÍCULAS Y FUNCIONES ===
        $peliculas = Movie::whereHas('funciones', function($q) use ($inicio, $fin) {
            $q->whereBetween('hora', [$inicio, $fin]);
        })
        ->with(['funciones' => function($q) use ($inicio, $fin) {
            $q->whereBetween('hora', [$inicio, $fin])
              ->with(['reservas' => function($r) {
                  $r->where('estado_pago', 'aprobado');
              }]);
        }])
        ->get()
        ->map(function($pelicula) {
            $funciones = $pelicula->funciones;
            $totalBoletos = 0;
            $totalIngresos = 0;

            foreach($funciones as $funcion) {
                foreach($funcion->reservas as $reserva) {
                    $totalBoletos += $reserva->cantidad_asientos;
                    $totalIngresos += $reserva->precio_total;
                }
            }

            return [
                'titulo' => $pelicula->titulo,
                'funciones' => $funciones->count(),
                'boletos_vendidos' => $totalBoletos,
                'ingresos' => $totalIngresos
            ];
        });

        // === VENTAS DE CONFITERÍA ===
        $pedidosConfiteria = PedidoConfiteria::whereBetween('created_at', [$inicio, $fin])
            ->where('estado', 'confirmado')
            ->with('productos.confiteria')
            ->get();

        // Agrupar productos de confitería
        $confiteriaAgrupada = [];
        $totalIngresosConfiteria = 0;

        foreach($pedidosConfiteria as $pedido) {
            $totalIngresosConfiteria += $pedido->total;
            
            foreach($pedido->productos as $producto) {
                $nombreProducto = $producto->confiteria->nombre ?? 'Producto Desconocido';
                
                if(!isset($confiteriaAgrupada[$nombreProducto])) {
                    $confiteriaAgrupada[$nombreProducto] = [
                        'producto' => $nombreProducto,
                        'cantidad' => 0,
                        'ingresos' => 0
                    ];
                }
                
                $confiteriaAgrupada[$nombreProducto]['cantidad'] += $producto->cantidad;
                $confiteriaAgrupada[$nombreProducto]['ingresos'] += $producto->subtotal;
            }
        }

        // Convertir a array indexado
        $confiteria = array_values($confiteriaAgrupada);

        // === RESUMEN GENERAL ===
        $totalPeliculas = $peliculas->count();
        $totalFunciones = $peliculas->sum('funciones');
        $totalBoletos = $peliculas->sum('boletos_vendidos');
        $ingresosBoletos = $peliculas->sum('ingresos');
        $ingresosTotales = $ingresosBoletos + $totalIngresosConfiteria;

        $reporte = [
            'mes' => $nombresMeses[$mes],
            'año' => $año,
            'resumen' => [
                'total_peliculas' => $totalPeliculas,
                'total_funciones' => $totalFunciones,
                'total_boletos' => $totalBoletos,
                'ingresos_boletos' => number_format($ingresosBoletos, 2),
                'ingresos_confiteria' => number_format($totalIngresosConfiteria, 2),
                'ingresos_totales' => number_format($ingresosTotales, 2)
            ],
            'peliculas' => $peliculas,
            'confiteria' => $confiteria
        ];

        return view('reportes.index', [
            'reporte' => $reporte,
            'mesActual' => $mes,
            'añoActual' => $año
        ]);
    }

    /**
     * Exporta el reporte mensual a PDF
     */
    public function exportarPDF(Request $request)
    {
        $request->validate([
            'mes' => 'required|integer|min:1|max:12',
            'año' => 'required|integer|min:2020|max:2030'
        ]);

        $mes = $request->mes;
        $año = $request->año;

        // Calcular inicio y fin del mes
        $inicio = Carbon::create($año, $mes, 1)->startOfMonth();
        $fin = Carbon::create($año, $mes, 1)->endOfMonth();

        // Obtener nombre del mes en español
        $nombresMeses = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];

        // === PELÍCULAS Y FUNCIONES ===
        $peliculas = Movie::whereHas('funciones', function($q) use ($inicio, $fin) {
            $q->whereBetween('hora', [$inicio, $fin]);
        })
        ->with(['funciones' => function($q) use ($inicio, $fin) {
            $q->whereBetween('hora', [$inicio, $fin])
              ->with(['reservas' => function($r) {
                  $r->where('estado_pago', 'aprobado');
              }]);
        }])
        ->get()
        ->map(function($pelicula) {
            $funciones = $pelicula->funciones;
            $totalBoletos = 0;
            $totalIngresos = 0;

            foreach($funciones as $funcion) {
                foreach($funcion->reservas as $reserva) {
                    $totalBoletos += $reserva->cantidad_asientos;
                    $totalIngresos += $reserva->precio_total;
                }
            }

            return [
                'titulo' => $pelicula->titulo,
                'funciones' => $funciones->count(),
                'boletos_vendidos' => $totalBoletos,
                'ingresos' => $totalIngresos
            ];
        });

        // === VENTAS DE CONFITERÍA ===
        $pedidosConfiteria = PedidoConfiteria::whereBetween('created_at', [$inicio, $fin])
            ->where('estado', 'confirmado')
            ->with('productos.confiteria')
            ->get();

        // Agrupar productos de confitería
        $confiteriaAgrupada = [];
        $totalIngresosConfiteria = 0;

        foreach($pedidosConfiteria as $pedido) {
            $totalIngresosConfiteria += $pedido->total;
            
            foreach($pedido->productos as $producto) {
                $nombreProducto = $producto->confiteria->nombre ?? 'Producto Desconocido';
                
                if(!isset($confiteriaAgrupada[$nombreProducto])) {
                    $confiteriaAgrupada[$nombreProducto] = [
                        'producto' => $nombreProducto,
                        'cantidad' => 0,
                        'ingresos' => 0
                    ];
                }
                
                $confiteriaAgrupada[$nombreProducto]['cantidad'] += $producto->cantidad;
                $confiteriaAgrupada[$nombreProducto]['ingresos'] += $producto->subtotal;
            }
        }

        // Convertir a array indexado
        $confiteria = array_values($confiteriaAgrupada);

        // === RESUMEN GENERAL ===
        $totalPeliculas = $peliculas->count();
        $totalFunciones = $peliculas->sum('funciones');
        $totalBoletos = $peliculas->sum('boletos_vendidos');
        $ingresosBoletos = $peliculas->sum('ingresos');
        $ingresosTotales = $ingresosBoletos + $totalIngresosConfiteria;

        $reporte = [
            'mes' => $nombresMeses[$mes],
            'año' => $año,
            'resumen' => [
                'total_peliculas' => $totalPeliculas,
                'total_funciones' => $totalFunciones,
                'total_boletos' => $totalBoletos,
                'ingresos_boletos' => number_format($ingresosBoletos, 2),
                'ingresos_confiteria' => number_format($totalIngresosConfiteria, 2),
                'ingresos_totales' => number_format($ingresosTotales, 2)
            ],
            'peliculas' => $peliculas,
            'confiteria' => $confiteria
        ];

        // Generar PDF
        $pdf = Pdf::loadView('reportes.pdf', ['reporte' => $reporte]);
        $pdf->setPaper('A4', 'portrait');
        
        // Nombre del archivo
        $nombreArchivo = 'Reporte_' . $nombresMeses[$mes] . '_' . $año . '.pdf';
        
        return $pdf->download($nombreArchivo);
    }
}
