<?php

namespace App\Http\Controllers;

use App\Models\Confiteria;
use App\Models\Carrito;
use App\Models\PedidoConfiteria;
use App\Models\PedidoProducto;
use App\Models\Reserva;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ConfiteriaController extends Controller
{
    /**
     * Display a listing of the resource (Admin view only)
     */
    public function index()
    {
        // Solo para administradores
        $confiteria = Confiteria::all();
        return view('confiteria.admin_index', compact('confiteria'));
    }

    /**
     * Show the form for creating a new resource
     */
    public function create()
    {
        return view('confiteria.create');
    }

    /**
     * Store a newly created resource in storage
     */
    public function store(Request $request)
    {
        // Validación de los datos que vienen del formulario
        $validate = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);
        
        // Si se envía una imagen, se guarda en la carpeta 'confiteria'
        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('confiteria', 'public');
            $validate['imagen'] = $rutaImagen;
        }

        // Crea el registro en la base de datos
        Confiteria::create($validate);

        // Redirige de nuevo al listado con un mensaje de éxito
        return redirect()->route('confiteria.index')->with('success', 'Producto de confitería creado correctamente');
    }

    /**
     * Display the specified resource
     */
    public function show(string $id)
    {
        $producto = Confiteria::findOrFail($id);
        
        // Verificar si el usuario es admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            // Redirigir a la vista de edición para admin
            return redirect()->route('confiteria.edit', $id);
        }
        
        // Vista de detalle para usuario regular
        return view('user.confiteria_show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource
     */
    public function edit(string $id)
    {
        $registro = Confiteria::findOrFail($id);

        // Envía el registro a la vista de edición
        return view('confiteria.edit', compact('registro'));
    }

    /**
     * Update the specified resource in storage
     */
    public function update(Request $request, string $id)
    {
        $registro = Confiteria::findOrFail($id);
        
        // Validación de los datos
        $validate = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);
        
        // Si se envía una nueva imagen
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($registro->imagen) {
                Storage::disk('public')->delete($registro->imagen);
            }
            
            $rutaImagen = $request->file('imagen')->store('confiteria', 'public');
            $validate['imagen'] = $rutaImagen;
        }

        // Actualiza el registro
        $registro->update($validate);

        // Redirige con mensaje de éxito
        return redirect()->route('confiteria.index')->with('success', 'Producto de confitería actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage
     */
    public function destroy(string $id)
    {
        $registro = Confiteria::findOrFail($id);

        // Elimina la imagen del disco si existe
        if ($registro->imagen) {
            Storage::disk('public')->delete($registro->imagen);
        }

        // Elimina el registro de la base de datos
        $registro->delete();

        // Redirige de nuevo al listado con un mensaje de éxito
        return redirect()->route('confiteria.index')->with('success', 'Producto de confitería eliminado correctamente');
    }

    /**
     * Vista principal de confitería para usuarios (User view)
     */
    public function userIndex()
    {
        $productos = Confiteria::where('stock', '>', 0)
            ->orderBy('nombre')
            ->get();

        // Obtener carrito del usuario
        $carrito = Carrito::with('producto')
            ->where('usuario_id', auth()->id())
            ->get();

        $subtotal = $carrito->sum(function ($item) {
            return $item->cantidad * $item->producto->precio;
        });
        $cargoServicio = $subtotal * 0.05;
        $total = $subtotal + $cargoServicio;

        return view('user.confiteria', compact('productos', 'carrito', 'subtotal', 'cargoServicio', 'total'));
    }

    /**
     * Agregar producto al carrito
     */
    public function agregarAlCarrito(Request $request)
    {
        $validated = $request->validate([
            'producto_id' => 'required|exists:confiteria,id',
            'cantidad' => 'required|integer|min:1|max:20'
        ]);

        $producto = Confiteria::findOrFail($validated['producto_id']);
        
        if ($producto->stock < $validated['cantidad']) {
            return back()->with('error', 'Stock insuficiente. Solo hay ' . $producto->stock . ' disponibles.');
        }

        $itemCarrito = Carrito::where('usuario_id', auth()->id())
            ->where('producto_id', $validated['producto_id'])
            ->first();

        if ($itemCarrito) {
            $nuevaCantidad = $itemCarrito->cantidad + $validated['cantidad'];
            
            if ($nuevaCantidad > $producto->stock) {
                return back()->with('error', 'No puedes agregar más. Stock máximo: ' . $producto->stock);
            }

            $itemCarrito->update(['cantidad' => $nuevaCantidad]);
        } else {
            Carrito::create([
                'usuario_id' => auth()->id(),
                'producto_id' => $validated['producto_id'],
                'cantidad' => $validated['cantidad']
            ]);
        }

        return back()->with('success', '✅ Producto agregado al carrito');
    }

    /**
     * Actualizar cantidad en carrito
     */
    public function actualizarCarrito(Request $request, $id)
    {
        $validated = $request->validate([
            'cantidad' => 'required|integer|min:1|max:20'
        ]);

        $itemCarrito = Carrito::where('usuario_id', auth()->id())
            ->findOrFail($id);

        if ($itemCarrito->producto->stock < $validated['cantidad']) {
            return back()->with('error', 'Stock insuficiente');
        }

        $itemCarrito->update(['cantidad' => $validated['cantidad']]);

        return back()->with('success', 'Cantidad actualizada');
    }

    /**
     * Eliminar del carrito
     */
    public function eliminarDelCarrito($id)
    {
        $itemCarrito = Carrito::where('usuario_id', auth()->id())
            ->findOrFail($id);

        $itemCarrito->delete();

        return back()->with('success', 'Producto eliminado del carrito');
    }

    /**
     * Vaciar carrito
     */
    public function limpiarCarrito()
    {
        Carrito::where('usuario_id', auth()->id())->delete();

        return back()->with('success', 'Carrito vaciado');
    }

    /**
     * Ver mis pedidos
     */
    public function misPedidos()
    {
        $pedidos = PedidoConfiteria::with(['productos.producto', 'reserva'])
            ->where('usuario_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('confiteria.mis-pedidos', compact('pedidos'));
    }

    /**
     * Ver detalle de pedido
     */
    public function verPedido($id)
    {
        $pedido = PedidoConfiteria::with(['productos.producto', 'reserva.funcion.movies'])
            ->where('usuario_id', auth()->id())
            ->findOrFail($id);

        return view('confiteria.detalle-pedido', compact('pedido'));
    }


    public function mostrarConfiteriaConReserva($reserva_id)
    {
        // Obtener la reserva con sus relaciones
        $reserva = Reserva::with([
            'funcion.movies',
            'funcion.Sala',
            'usuario',
            'sillas.silla'
        ])->findOrFail($reserva_id);
        
        // Verificar que el usuario sea el dueño de la reserva
        if ($reserva->usuario_id !== auth()->id()) {
            abort(403, 'No tienes permiso para ver esta reserva');
        }

        // Verificar que la reserva no haya expirado
        if ($reserva->hasExpired()) {
            return redirect()->route('user.index')
                ->with('error', 'Tu reserva ha expirado. Por favor, vuelve a seleccionar tus asientos.');
        }

        // Verificar que la reserva esté pendiente
        if ($reserva->estado !== 'pendiente') {
            return redirect()->route('reservas.show', $reserva->id)
                ->with('error', 'Esta reserva ya fue procesada.');
        }

        // Obtener productos disponibles
        $productos = Confiteria::where('stock', '>', 0)
            ->orderBy('nombre')
            ->get();

        // Obtener carrito del usuario (por si tiene productos previos)
        $carrito = Carrito::with('producto')
            ->where('usuario_id', auth()->id())
            ->get();

        // Calcular totales del carrito
        $subtotal = $carrito->sum(function ($item) {
            return $item->cantidad * $item->producto->precio;
        });
        $cargoServicio = $subtotal * 0.05;
        $totalConfiteria = $subtotal + $cargoServicio;

        return view('user.reservaComfi', compact(
            'reserva',
            'productos',
            'carrito',
            'subtotal',
            'cargoServicio',
            'totalConfiteria'
        ));
    }

    /**
     * 🎯 MODIFICADO: Crear pedido vinculado a una reserva
     */
    public function crearPedido(Request $request)
    {
        $carrito = Carrito::with('producto')
            ->where('usuario_id', auth()->id())
            ->get();

        if ($carrito->isEmpty()) {
            return back()->with('error', 'El carrito está vacío');
        }

        // 🔍 Validar que la reserva exista y pertenezca al usuario
        $reservaId = $request->reserva_id;
        if ($reservaId) {
            $reserva = Reserva::where('id', $reservaId)
                ->where('usuario_id', auth()->id())
                ->where('estado', 'pendiente')
                ->first();

            if (!$reserva) {
                return back()->with('error', 'Reserva no válida o ya procesada');
            }

            if ($reserva->hasExpired()) {
                return back()->with('error', 'Tu reserva ha expirado');
            }
        }

        DB::beginTransaction();

        try {
            // Verificar stock
            foreach ($carrito as $item) {
                if ($item->producto->stock < $item->cantidad) {
                    DB::rollBack();
                    return back()->with('error', "Stock insuficiente para {$item->producto->nombre}");
                }
            }

            // Calcular totales
            $subtotal = $carrito->sum(function ($item) {
                return $item->cantidad * $item->producto->precio;
            });
            $cargoServicio = $subtotal * 0.05;
            $total = $subtotal + $cargoServicio;

            // Crear pedido vinculado a la reserva
            $pedido = PedidoConfiteria::create([
                'usuario_id' => auth()->id(),
                'reserva_id' => $reservaId ?? null, // 🔗 Vinculación con reserva
                'subtotal' => $subtotal,
                'cargo_servicio' => $cargoServicio,
                'total' => $total,
                'estado' => 'pendiente',
                'expires_at' => now()->addMinutes(15)
            ]);

            // Crear detalle de productos
            foreach ($carrito as $item) {
                PedidoProducto::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $item->producto_id,
                    'cantidad' => $item->cantidad,
                    'precio_unitario' => $item->producto->precio,
                    'subtotal' => $item->cantidad * $item->producto->precio
                ]);

                // Reducir stock
                $item->producto->decrement('stock', $item->cantidad);
            }

            // Limpiar carrito
            Carrito::where('usuario_id', auth()->id())->delete();

            DB::commit();

            // 🎯 Redirigir al pago unificado (reserva + confitería)
            return redirect()->route('pagos.checkout.unificado', [
                'reserva_id' => $reservaId,
                'pedido_id' => $pedido->id
            ])->with('success', 'Pedido creado exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al crear pedido:', ['error' => $e->getMessage()]);
            
            return back()->with('error', 'Error al crear el pedido');
        }
    }
}