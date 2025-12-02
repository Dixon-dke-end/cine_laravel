<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Pago - CineVel</title>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        :root {
            --primary: #667eea;
            --primary-dark: #5a67d8;
            --secondary: #764ba2;
            --success: #10b981;
            --danger: #ef4444;
            --bg-body: #f4f6f9;
            --bg-card: #ffffff;
            --text-main: #1a202c;
            --text-muted: #718096;
            --gradient-main: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --radius: 16px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-body);
            color: var(--text-main);
            line-height: 1.6;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1rem 2rem;
        }

        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-size: 1.75rem;
            font-weight: 800;
            background: var(--gradient-main);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
        }

        .header-section {
            background: var(--gradient-main);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }

        .header-section h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .main-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .payment-section {
            background: white;
            border-radius: var(--radius);
            padding: 2rem;
            box-shadow: var(--shadow-lg);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .summary-card {
            background: white;
            border-radius: var(--radius);
            padding: 2rem;
            box-shadow: var(--shadow-lg);
            height: fit-content;
            position: sticky;
            top: 100px;
        }

        .movie-info {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .movie-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--primary);
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 8px;
        }

        .info-label {
            color: var(--text-muted);
            font-weight: 500;
        }

        .info-value {
            font-weight: 700;
            color: var(--text-main);
        }

        .confiteria-items {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 2px solid #f0f0f0;
        }

        .confiteria-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .confiteria-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .total-section {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 3px solid var(--primary);
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            font-size: 1rem;
        }

        .total-final {
            font-size: 2rem;
            font-weight: 800;
            background: var(--gradient-main);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-top: 1rem;
        }

        .timer-alert {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff8e53 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 2rem;
        }

        .timer-value {
            font-size: 2rem;
            font-weight: bold;
        }

        .payment-options {
            display: grid;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .payment-option {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .payment-option:hover {
            border-color: var(--primary);
            background: rgba(102, 126, 234, 0.05);
        }

        .payment-option.active {
            border-color: var(--primary);
            background: rgba(102, 126, 234, 0.1);
        }

        .btn-pay {
            width: 100%;
            background: var(--gradient-main);
            color: white;
            border: none;
            padding: 1.25rem;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-pay:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-pay:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .alert-error {
            background: #fee;
            color: #c00;
            border: 1px solid #fcc;
        }

        @media (max-width: 1024px) {
            .main-container {
                grid-template-columns: 1fr;
            }

            .summary-card {
                position: static;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="<?php echo e(route('user.index')); ?>" class="navbar-brand">CineVel</a>
        </div>
    </nav>

    <div class="header-section">
        <h1>💳 Finalizar Pago</h1>
        <p>Completa tu compra de forma segura</p>
    </div>

    <div class="main-container">
        <div class="payment-section">
            <div class="timer-alert">
                <div style="font-size: 0.9rem; margin-bottom: 0.5rem;">⏱️ Tiempo restante para completar tu pago</div>
                <div class="timer-value" id="timer">15:00</div>
            </div>

            <?php if(session('error')): ?>
            <div class="alert alert-error">
                <?php echo e(session('error')); ?>

            </div>
            <?php endif; ?>

            <h2 class="section-title">
                <span>🔒</span>
                Selecciona tu método de pago
            </h2>

            <div class="payment-options">
                <div class="payment-option active" id="mercadopago-option">
                    <img src="https://http2.mlstatic.com/storage/logos-api-admin/a5f047d0-9be0-11ec-aad4-c3381f368aaf-xl@2x.png" 
                         alt="Mercado Pago" 
                         style="height: 40px;">
                    <div style="flex: 1;">
                        <div style="font-weight: 700;">Mercado Pago</div>
                        <div style="font-size: 0.85rem; color: var(--text-muted);">
                            Paga con tarjeta, PSE o efectivo
                        </div>
                    </div>
                </div>
            </div>

            <button id="btn-pagar" class="btn-pay">
                Proceder al Pago con Mercado Pago →
            </button>

            <div style="margin-top: 1.5rem; text-align: center; color: var(--text-muted); font-size: 0.85rem;">
                🔒 Pago 100% seguro y protegido
            </div>
        </div>

        <div class="summary-card">
            <h3 class="section-title">📋 Resumen de Compra</h3>

            <div class="movie-info">
                <div class="movie-title"><?php echo e($reserva->funcion->movies->titulo); ?></div>
                
                <div class="info-row">
                    <span class="info-label">Sala</span>
                    <span class="info-value"><?php echo e($reserva->funcion->Sala->nombre_sala); ?></span>
                </div>

                <div class="info-row">
                    <span class="info-label">Fecha y Hora</span>
                    <span class="info-value">
                        <?php echo e(\Carbon\Carbon::parse($reserva->funcion->hora)->format('d/m/Y H:i')); ?>

                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label">Asientos</span>
                    <span class="info-value">
                        <?php echo e($reserva->sillas->pluck('silla.nombre')->implode(', ')); ?>

                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label">Cantidad</span>
                    <span class="info-value"><?php echo e($reserva->cantidad_asientos); ?> boleta(s)</span>
                </div>
            </div>

            <?php if($pedidoConfiteria): ?>
            <div class="confiteria-items">
                <div class="confiteria-title">🍿 Confitería</div>
                
                <?php $__currentLoopData = $pedidoConfiteria->productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="confiteria-item">
                    <span><?php echo e($item->producto->nombre); ?> (x<?php echo e($item->cantidad); ?>)</span>
                    <span style="font-weight: 600;">
                        $<?php echo e(number_format($item->subtotal, 0, ',', '.')); ?>

                    </span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div class="confiteria-item" style="border: none; padding-top: 1rem;">
                    <span style="color: var(--text-muted);">Cargo servicio (5%)</span>
                    <span style="font-weight: 600;">
                        $<?php echo e(number_format($pedidoConfiteria->cargo_servicio, 0, ',', '.')); ?>

                    </span>
                </div>
            </div>
            <?php endif; ?>

            <div class="total-section">
                <div class="total-row">
                    <span>Boletas</span>
                    <span style="font-weight: 700;">$<?php echo e(number_format($totalReserva, 0, ',', '.')); ?></span>
                </div>

                <?php if($totalConfiteria > 0): ?>
                <div class="total-row">
                    <span>Confitería</span>
                    <span style="font-weight: 700;">$<?php echo e(number_format($totalConfiteria, 0, ',', '.')); ?></span>
                </div>
                <?php endif; ?>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem;">
                    <span style="font-size: 1.25rem; font-weight: 700;">TOTAL</span>
                    <span class="total-final">$<?php echo e(number_format($totalFinal, 0, ',', '.')); ?></span>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Variables para el pago
        const reservaId = <?php echo e($reserva->id); ?>;
        const pedidoId = <?php echo e($pedidoConfiteria ? $pedidoConfiteria->id : 'null'); ?>;
        const totalFinal = <?php echo e($totalFinal); ?>;

        // Configurar Mercado Pago
        const mp = new MercadoPago('<?php echo e(env('MERCADOPAGO_PUBLIC_KEY')); ?>', {
            locale: 'es-CO'
        });

        // Botón de pagar
        document.getElementById('btn-pagar').addEventListener('click', async function() {
            const btn = this;
            btn.disabled = true;
            btn.textContent = '⏳ PROCESANDO...';

            try {
                // Crear preferencia en el backend (usando ruta relativa para evitar mixed content)
                const response = await fetch('/pagos/unificado/crear-preferencia', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({
                        reserva_id: reservaId,
                        pedido_id: pedidoId
                    })
                });

                const data = await response.json();

                if (data.preference_id) {
                    // Redirigir a Mercado Pago
                    window.location.href = data.init_point;
                } else {
                    throw new Error('Error al crear la preferencia de pago');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Hubo un error al procesar el pago: ' + error.message);
                btn.disabled = false;
                btn.textContent = `PAGAR $${totalFinal.toLocaleString('es-CO')}`;
            }
        });

        // Timer de expiración
        const expiresAt = new Date('<?php echo e($reserva->expires_at); ?>');
        
        function updateTimer() {
            const now = new Date();
            const diff = expiresAt - now;

            if (diff <= 0) {
                document.getElementById('timer').textContent = '00:00';
                alert('Tu reserva ha expirado');
                window.location.href = '<?php echo e(route('user.index')); ?>';
                return;
            }

            const minutes = Math.floor(diff / 60000);
            const seconds = Math.floor((diff % 60000) / 1000);
            document.getElementById('timer').textContent = 
                `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }

        updateTimer();
        setInterval(updateTimer, 1000);
    </script>
</body>
</html>
<?php /**PATH C:\Users\Dixon\Desktop\cine_laravel\resources\views/pagos/checkout-unificado.blade.php ENDPATH**/ ?>