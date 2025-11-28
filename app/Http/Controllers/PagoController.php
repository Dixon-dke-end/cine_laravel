<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;

class PagoController extends Controller
{
    public function __construct()
    {
        // Configurar Access Token de Mercado Pago
        MercadoPagoConfig::setAccessToken(env('MERCADOPAGO_ACCESS_TOKEN'));
        
        // 🔒 SOLO en desarrollo local: Deshabilitar verificación SSL de cURL
            // Guardar el valor original de CURLOPT_SSL_VERIFYPEER
            // Este workaround funciona porque el SDK internamente usa cURL
            $this->disableSSLVerification();
    }

    /**
     * Deshabilitar verificación SSL para desarrollo local
     * ADVERTENCIA: Solo usar en desarrollo, NUNCA en producción
     */
    private function disableSSLVerification()
    {
        // Crear un contexto de stream que deshabilita SSL
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ],
            'http' => [
                'ignore_errors' => true
            ]
        ]);
        
        // Establecer como contexto por defecto
        stream_context_set_default([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ]);
    }

    /**
     * Mostrar página de checkout/pago
     */
    public function mostrarPago($reserva_id)
    {
        $reserva = Reserva::with(['funcion.movies', 'funcion.Sala', 'sillas.silla'])
            ->findOrFail($reserva_id);

        // Verificar que el usuario sea el dueño
        if ($reserva->usuario_id !== auth()->id()) {
            abort(403, 'No tienes permiso para pagar esta reserva');
        }

        // Verificar que esté pendiente
        if ($reserva->estado !== 'pendiente') {
            return redirect()->route('reservas.show', $reserva_id)
                ->with('error', 'Esta reserva ya fue procesada.');
        }

        // Calcular desglose de precios
        $subtotal = $reserva->cantidad_asientos * 6000;
        $cargoServicio = $reserva->cantidad_asientos * 1500;
        $total = $reserva->precio_total;

        return view('pagos.checkout', compact('reserva', 'subtotal', 'cargoServicio', 'total'));
    }

    /**
     * Crear preferencia de pago en Mercado Pago
     */
    public function crearPreferenciaMercadoPago($reserva_id)
    {
        $reserva = Reserva::with(['funcion.movies'])->findOrFail($reserva_id);

        if ($reserva->usuario_id !== auth()->id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        try {
            // Asegurarse de que SSL esté deshabilitado en local
            if (app()->environment('local')) {
                $this->disableSSLVerification();
            }

            $client = new PreferenceClient();
            $precioUnitario = floatval($reserva->precio_total / $reserva->cantidad_asientos);

            $preferenceData = [
                'items' => [
                    [
                        'id' => 'reserva_' . $reserva->id,
                        'title' => 'Reserva CineVel - ' . $reserva->funcion->movies->titulo,
                        'description' => 'Entradas para ' . $reserva->funcion->movies->titulo,
                        'quantity' => $reserva->cantidad_asientos,
                        'unit_price' => $precioUnitario,
                        'currency_id' => 'COP'
                    ]
                ],
                
            'back_urls' => [
                'success' =>  'https://cecilia-thiocyano-michael.ngrok-free.dev/pagos/success/' . $reserva->id,
                'failure' => url("/pagos/failure/{$reserva->id}"),
                'pending' => url("/pagos/pending/{$reserva->id}")

                ],
                'auto_return' => 'approved',
                'external_reference' => 'reserva_' . $reserva->id,
                'statement_descriptor' => 'CINEVEL',
                'notification_url' => url('/webhooks/mercadopago'),
                'payer' => [
                    'name' => auth()->user()->name ?? 'Cliente',
                    'email' => auth()->user()->email ?? 'cliente@cinevel.com'
                ]
            ];
            $preference = $client->create($preferenceData);

            \Log::info('✅ Preferencia creada:', [
                'preference_id' => $preference->id,
                'reserva_id' => $reserva_id
            ]);

            return response()->json([
                'success' => true,
                'preference_id' => $preference->id,
                'init_point' => $preference->init_point
            ]);

        } catch (MPApiException $e) {
            \Log::error('Error API Mercado Pago:', [
                'status' => $e->getApiResponse()->getStatusCode(),
                'content' => $e->getApiResponse()->getContent(),
                'reserva_id' => $reserva_id
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el pago con Mercado Pago'
            ], 500);

        } catch (\Exception $e) {
            \Log::error('Error general al crear preferencia:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'reserva_id' => $reserva_id
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el pago'
            ], 500);
        }
    }

    /**
     * Página de éxito después del pago
     */
    public function pagoExitoso(Request $request, $reserva_id)
    {
        $reserva = Reserva::with(['funcion.movies', 'sillas.silla'])->findOrFail($reserva_id);
        
        $payment_id = $request->get('payment_id');
        $status = $request->get('status');
        $payment_type = $request->get('payment_type');
        
        \Log::info('Pago exitoso recibido:', [
            'reserva_id' => $reserva_id,
            'payment_id' => $payment_id,
            'status' => $status,
            'all_params' => $request->all()
        ]);
            if ($status === 'approved' && $reserva->estado !== 'confirmada') {
                try {
                    $reserva->update([
                        'estado' => 'confirmada',
                        'metodo_pago' => 'mercado_pago',
                        'pago_id' => $payment_id,
                        'estado_pago' => 'aprobado',
                        'fecha_pago' => now(),
                        'expires_at' => null,  // ⬅️ QUITAR expiración porque ya pagó
                        'detalles_pago' => [
                            'payment_type' => $payment_type,
                            'collection_status' => $status,
                            'preference_id' => $request->get('preference_id'),
                            'merchant_order_id' => $request->get('merchant_order_id'),
                            'collection_id' => $request->get('collection_id')
                        ]
                    ]);

                \Log::info("✅ Reserva {$reserva_id} confirmada exitosamente");

                return view('pagos.success', compact('reserva'));

            } catch (\Exception $e) {
                \Log::error('Error al confirmar pago:', [
                    'error' => $e->getMessage(),
                    'reserva_id' => $reserva_id
                ]);
                
                return redirect()->route('reservas.show', $reserva_id)
                    ->with('error', 'Hubo un problema al confirmar tu pago. Contacta a soporte.');
            }
        }

        if ($status === 'pending') {
            return view('pagos.pending', compact('reserva'));
        }

        return redirect()->route('reservas.show', $reserva_id)
            ->with('info', 'Esta reserva ya fue procesada anteriormente.');
    }

    /**
     * Página de pago fallido o cancelado
     */
    public function pagoFallido($reserva_id)
    {
        $reserva = Reserva::with(['funcion.movies'])->findOrFail($reserva_id);
        
        \Log::warning('Pago fallido o cancelado:', ['reserva_id' => $reserva_id]);
        
        return view('pagos.failure', compact('reserva'));
    }

    /**
     * Webhook para recibir notificaciones automáticas de Mercado Pago
     */
    public function webhookMercadoPago(Request $request)
    {
        \Log::info('🔔 Webhook MP recibido:', $request->all());

        $type = $request->get('type');
        $dataId = $request->input('data.id');

        \Log::info('Webhook detalles:', [
            'type' => $type,
            'data_id' => $dataId
        ]);

        if ($type === 'payment' && $dataId) {
            try {
                // Deshabilitar SSL también para el webhook
                if (app()->environment('local')) {
                    $this->disableSSLVerification();
                }

                $client = new PaymentClient();
                $payment = $client->get($dataId);
                
                \Log::info('Información del pago desde webhook:', [
                    'id' => $payment->id,
                    'status' => $payment->status,
                    'external_reference' => $payment->external_reference,
                    'transaction_amount' => $payment->transaction_amount
                ]);

                if ($payment->status === 'approved') {
                    $external_reference = $payment->external_reference;
                    
                    if ($external_reference && strpos($external_reference, 'reserva_') === 0) {
                        $reserva_id = str_replace('reserva_', '', $external_reference);
                        
                        $reserva = Reserva::find($reserva_id);
                        
                        if ($reserva && $reserva->estado === 'pendiente') {
                            $reserva->update([
                                'estado' => 'confirmada',
                                'metodo_pago' => 'mercado_pago',
                                'pago_id' => $payment->id,
                                'estado_pago' => 'aprobado',
                                'fecha_pago' => now(),
                                'detalles_pago' => [
                                    'payment_method_id' => $payment->payment_method_id ?? null,
                                    'payment_type_id' => $payment->payment_type_id ?? null,
                                    'transaction_amount' => $payment->transaction_amount ?? null,
                                    'status' => $payment->status,
                                    'status_detail' => $payment->status_detail ?? null
                                ]
                            ]);

                            \Log::info("✅ Webhook: Pago confirmado para reserva {$reserva_id}");
                        } else {
                            \Log::warning("Reserva {$reserva_id} no encontrada o ya procesada", [
                                'reserva_estado' => $reserva ? $reserva->estado : 'no_existe'
                            ]);
                        }
                    } else {
                        \Log::warning('External reference no válido:', [
                            'external_reference' => $external_reference
                        ]);
                    }
                } else {
                    \Log::info('Pago con estado diferente a approved:', [
                        'status' => $payment->status,
                        'payment_id' => $payment->id
                    ]);
                }

            } catch (MPApiException $e) {
                \Log::error('Error API en webhook:', [
                    'status' => $e->getApiResponse()->getStatusCode(),
                    'content' => $e->getApiResponse()->getContent()
                ]);
            } catch (\Exception $e) {
                \Log::error('Error general procesando webhook:', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        } else {
            \Log::info('Tipo de notificación no procesado:', [
                'type' => $type
            ]);
        }

        return response()->json(['status' => 'ok'], 200);
    }

    /**
     * Mostrar página de checkout/pago para confitería
     */
    public function mostrarPagoConfiteria($pedido_id)
    {
        $pedido = \App\Models\PedidoConfiteria::with(['productos.producto'])
            ->findOrFail($pedido_id);

        // Verificar que el usuario sea el dueño
        if ($pedido->usuario_id !== auth()->id()) {
            abort(403, 'No tienes permiso para pagar este pedido');
        }

        // Verificar que esté pendiente
        if ($pedido->estado !== 'pendiente') {
            return redirect()->route('confiteria.user')
                ->with('error', 'Este pedido ya fue procesado.');
        }

        return view('pagos.checkout-confiteria', compact('pedido'));
    }

    /**
     * Crear preferencia de pago en Mercado Pago para confitería
     */
    public function crearPreferenciaMercadoPagoConfiteria($pedido_id)
    {
        $pedido = \App\Models\PedidoConfiteria::with(['productos.producto'])
            ->findOrFail($pedido_id);

        if ($pedido->usuario_id !== auth()->id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        try {
            if (app()->environment('local')) {
                $this->disableSSLVerification();
            }

            $client = new PreferenceClient();

            // Crear items para cada producto
            $items = [];
            foreach ($pedido->productos as $item) {
                $items[] = [
                    'id' => 'producto_' . $item->producto_id,
                    'title' => $item->producto->nombre,
                    'description' => $item->producto->descripcion ?? 'Producto de confitería',
                    'quantity' => $item->cantidad,
                    'unit_price' => floatval($item->precio_unitario),
                    'currency_id' => 'COP'
                ];
            }

            $preferenceData = [
                'items' => $items,
                'back_urls' => [
                    'success' => 'https://cecilia-thiocyano-michael.ngrok-free.dev/pagos/confiteria/success/' . $pedido->id,
                    'failure' => 'https://cecilia-thiocyano-michael.ngrok-free.dev/pagos/confiteria/failure/' . $pedido->id,
                    'pending' => 'https://cecilia-thiocyano-michael.ngrok-free.dev/pagos/confiteria/success/' . $pedido->id
                ],
                'auto_return' => 'approved',
                'external_reference' => 'pedido_confiteria_' . $pedido->id,
                'statement_descriptor' => 'CINEVEL CONFITERIA',
                'notification_url' => url('/webhooks/mercadopago'),
                'payer' => [
                    'name' => auth()->user()->name ?? 'Cliente',
                    'email' => auth()->user()->email ?? 'cliente@cinevel.com'
                ]
            ];

            $preference = $client->create($preferenceData);

            \Log::info('✅ Preferencia confitería creada:', [
                'preference_id' => $preference->id,
                'pedido_id' => $pedido_id
            ]);

            return response()->json([
                'success' => true,
                'preference_id' => $preference->id,
                'init_point' => $preference->init_point
            ]);

        } catch (MPApiException $e) {
            \Log::error('Error API Mercado Pago (Confitería):', [
                'status' => $e->getApiResponse()->getStatusCode(),
                'content' => $e->getApiResponse()->getContent(),
                'pedido_id' => $pedido_id
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el pago con Mercado Pago'
            ], 500);

        } catch (\Exception $e) {
            \Log::error('Error general al crear preferencia (Confitería):', [
                'error' => $e->getMessage(),
                'pedido_id' => $pedido_id
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el pago'
            ], 500);
        }
    }

    /**
     * Página de éxito después del pago de confitería
     */
    public function pagoExitosoConfiteria(Request $request, $pedido_id)
    {
        $pedido = \App\Models\PedidoConfiteria::with(['productos.producto'])
            ->findOrFail($pedido_id);
        
        $payment_id = $request->get('payment_id');
        $status = $request->get('status');
        $payment_type = $request->get('payment_type');
        
        \Log::info('Pago confitería exitoso recibido:', [
            'pedido_id' => $pedido_id,
            'payment_id' => $payment_id,
            'status' => $status
        ]);

        if ($status === 'approved' && $pedido->estado !== 'pagado') {
            try {
                $pedido->update([
                    'estado' => 'pagado',
                    'metodo_pago' => 'mercado_pago',
                    'pago_id' => $payment_id,
                    'fecha_pago' => now()
                ]);

                \Log::info("✅ Pedido confitería {$pedido_id} confirmado exitosamente");

                return view('pagos.success-confiteria', compact('pedido'));

            } catch (\Exception $e) {
                \Log::error('Error al confirmar pago confitería:', [
                    'error' => $e->getMessage(),
                    'pedido_id' => $pedido_id
                ]);
                
                return redirect()->route('confiteria.user')
                    ->with('error', 'Hubo un problema al confirmar tu pago. Contacta a soporte.');
            }
        }

        if ($status === 'pending') {
            return view('pagos.pending-confiteria', compact('pedido'));
        }

        return redirect()->route('confiteria.user')
            ->with('info', 'Este pedido ya fue procesado anteriormente.');
    }

    /**
     * Página de pago fallido o cancelado para confitería
     */
    public function pagoFallidoConfiteria($pedido_id)
    {
        $pedido = \App\Models\PedidoConfiteria::with(['productos.producto'])
            ->findOrFail($pedido_id);
        
        \Log::warning('Pago confitería fallido o cancelado:', ['pedido_id' => $pedido_id]);
        
        return view('pagos.failure-confiteria', compact('pedido'));
    }
}