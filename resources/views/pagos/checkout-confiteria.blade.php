<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pagar Pedido - CineVel</title>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 2.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 1.1rem;
        }

        .content {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 30px;
        }

        .payment-section, .summary-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .payment-methods {
            display: grid;
            gap: 15px;
        }

        .payment-method {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .payment-method:hover {
            border-color: #667eea;
            background: #f8f9ff;
        }

        .payment-method.active {
            border-color: #667eea;
            background: #f0f2ff;
        }

        .payment-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .payment-info h3 {
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 5px;
        }

        .payment-info p {
            color: #666;
            font-size: 0.85rem;
        }

        .btn-pay {
            width: 100%;
            padding: 18px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 25px;
        }

        .btn-pay:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-pay:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .security-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: #4caf50;
            font-size: 0.9rem;
            margin-top: 15px;
        }

        .products-list {
            margin-bottom: 25px;
        }

        .product-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .product-info {
            flex: 1;
        }

        .product-name {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .product-quantity {
            color: #666;
            font-size: 0.9rem;
        }

        .product-price {
            font-weight: bold;
            color: #667eea;
            font-size: 1.1rem;
        }

        .price-breakdown {
            margin-bottom: 25px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 1rem;
        }

        .price-row:last-child {
            border-bottom: none;
            padding-top: 15px;
            margin-top: 10px;
            border-top: 2px solid #333;
        }

        .price-row.total {
            font-size: 1.5rem;
            font-weight: bold;
            color: #667eea;
        }

        @media (max-width: 768px) {
            .content {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🍿 Finalizar Pago - Confitería</h1>
            <p>Estás a un paso de confirmar tu pedido</p>
        </div>

        <div class="content">
            <!-- Sección de Pago -->
            <div class="payment-section">
                <h2 class="section-title">Método de Pago</h2>

                <div class="payment-methods">
                    <div class="payment-method active" data-method="mercadopago">
                        <div class="payment-icon">💳</div>
                        <div class="payment-info">
                            <h3>Mercado Pago</h3>
                            <p>Tarjetas de crédito, débito, PSE y más</p>
                        </div>
                    </div>
                </div>

                <button class="btn-pay" id="btnPagar">
                    PAGAR ${{ number_format($pedido->total, 0, ',', '.') }}
                </button>

                <div class="security-badge">
                    <span>🔒</span>
                    <span>Pago 100% seguro y encriptado</span>
                </div>
            </div>

            <!-- Resumen del Pedido -->
            <div class="summary-section">
                <h2 class="section-title">Resumen de Compra</h2>

                <div class="products-list">
                    @foreach($pedido->productos as $item)
                    <div class="product-item">
                        <div class="product-info">
                            <div class="product-name">{{ $item->producto->nombre }}</div>
                            <div class="product-quantity">Cantidad: {{ $item->cantidad }}</div>
                        </div>
                        <div class="product-price">
                            ${{ number_format($item->precio_unitario * $item->cantidad, 0, ',', '.') }}
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="price-breakdown">
                    <div class="price-row">
                        <span>Subtotal ({{ $pedido->productos->sum('cantidad') }} productos)</span>
                        <span>${{ number_format($pedido->total, 0, ',', '.') }}</span>
                    </div>
                    <div class="price-row total">
                        <span>Total</span>
                        <span>${{ number_format($pedido->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const pedidoId = {{ $pedido->id }};
        const total = {{ $pedido->total }};

        // Configurar Mercado Pago
        const mp = new MercadoPago('{{ env("MERCADOPAGO_PUBLIC_KEY") }}', {
            locale: 'es-CO'
        });

        // Botón de pagar
        document.getElementById('btnPagar').addEventListener('click', async function() {
            const btn = this;
            btn.disabled = true;
            btn.textContent = '⏳ PROCESANDO...';

            try {
                // Crear preferencia en el backend
                const response = await fetch(`/pagos/confiteria/crear-preferencia/${pedidoId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();

                if (data.preference_id) {
                    // Redirigir a Mercado Pago
                    window.location.href = data.init_point;
                } else {
                    alert('Error al procesar el pago');
                    btn.disabled = false;
                    btn.textContent = `PAGAR $${total.toLocaleString('es-CO')}`;
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Hubo un error al procesar el pago');
                btn.disabled = false;
                btn.textContent = `PAGAR $${total.toLocaleString('es-CO')}`;
            }
        });
    </script>
</body>
</html>
