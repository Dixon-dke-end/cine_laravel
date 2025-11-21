<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Reserva</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            width: 100%;
        }

        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .icon.success {
            animation: bounce 0.8s ease-in-out;
        }

        @keyframes bounce {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
        }

        .info-section {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .info-title {
            color: #ffd700;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .info-value {
            color: rgba(255, 255, 255, 0.95);
            font-size: 1.1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .info-value strong {
            color: #fff;
        }

        .seats-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .seat-badge {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
            margin-top: 10px;
        }

        .status-pending {
            background: #ff9800;
            color: white;
        }

        .status-confirmed {
            background: #4caf50;
            color: white;
        }

        .status-paid {
            background: #2196f3;
            color: white;
        }

        .price-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
        }

        .price-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .price-value {
            font-size: 2.5rem;
            font-weight: bold;
            color: #fff;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 30px;
        }

        .btn {
            padding: 15px;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.6);
            transform: translateY(-2px);
        }

        .reservation-id {
            font-family: 'Courier New', monospace;
            background: rgba(0, 0, 0, 0.2);
            padding: 8px 12px;
            border-radius: 6px;
            color: #ffd700;
            font-weight: bold;
        }

        .alert {
            background: rgba(255, 193, 7, 0.2);
            border-left: 4px solid #ffd700;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.95rem;
        }

        @media (max-width: 600px) {
            .card {
                padding: 25px;
            }

            h1 {
                font-size: 1.5rem;
            }

            .icon {
                font-size: 3rem;
            }

            .price-value {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <!-- Header -->
            <div class="header">
                <div class="icon success">
                    <?php if($reserva->estado === 'pagada' || $reserva->estado === 'confirmada'): ?>
                        ✅
                    <?php else: ?>
                        ⏳
                    <?php endif; ?>
                </div>
                <h1>
                    <?php if($reserva->estado === 'pagada' || $reserva->estado === 'confirmada'): ?>
                        ¡Reserva Confirmada!
                    <?php else: ?>
                        Reserva Pendiente de Pago
                    <?php endif; ?>
                </h1>
                <p class="subtitle">Tu reservación ha sido creada exitosamente</p>
            </div>

            <!-- Reservation ID -->
            <div class="info-section">
                <div class="info-title">Número de Reserva</div>
                <div class="info-value">
                    <span class="reservation-id">#<?php echo e(str_pad($reserva->id, 6, '0', STR_PAD_LEFT)); ?></span>
                </div>
            </div>

            <!-- Movie Info -->
            <div class="info-section">
                <div class="info-title">🎬 Película</div>
                <div class="info-value">
                    <?php echo e($reserva->funcion->movies->titulo); ?>

                </div>
            </div>

            <!-- Sala Info -->
            <div class="info-section">
                <div class="info-title">🎭 Sala</div>
                <div class="info-value">
                    <?php echo e($reserva->funcion->Sala->nombre_sala); ?>

                </div>
            </div>

            <!-- Date/Time Info -->
            <div class="info-section">
                <div class="info-title">📅 Fecha y Hora</div>
                <div class="info-value">
                    <?php echo e(\Carbon\Carbon::parse($reserva->funcion->hora)->locale('es')->isoFormat('dddd DD [de] MMMM [de] YYYY [a las] HH:mm')); ?>

                </div>
            </div>

            <!-- Seats Info -->
            <div class="info-section">
                <div class="info-title">💺 Asientos</div>
                <div class="info-value">
                    <strong><?php echo e($reserva->cantidad_asientos); ?> asiento(s)</strong>
                </div>
                <div class="seats-list">
                <?php $__empty_1 = true; $__currentLoopData = $reserva->sillas ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $silla): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p>No hay sillas asignadas</p>
                <?php endif; ?>
                </div>
            </div>

            <!-- Status -->
            <div class="info-section">
                <div class="info-title">Estado</div>
                <div class="info-value">
                    <span class="status-badge status-<?php echo e($reserva->estado); ?>">
                        <?php echo e(ucfirst($reserva->estado)); ?>

                    </span>
                </div>
            </div>

            <!-- Price Section -->
            <div class="price-section">
                <div class="price-label">Monto Total a Pagar</div>
                <div class="price-value">$<?php echo e(number_format($reserva->precio_total, 2)); ?></div>
            </div>

            <!-- Alert Message -->
            <?php if($reserva->estado === 'pendiente'): ?>
            <div class="alert">
                ⏳ <strong>Reserva Pendiente de Pago:</strong> Tu reservación está reservada por 30 minutos. Debes completar el pago para confirmarla. Después de este tiempo, los asientos volverán a estar disponibles.
            </div>
            <?php endif; ?>

            <!-- Buttons -->
            <div class="btn-group">
                <?php if($reserva->estado === 'pendiente'): ?>
                <button class="btn btn-primary" onclick="proceedToPayment()">
                    💳 Proceder al Pago
                </button>
                <?php else: ?>
                <a href="<?php echo e(route('user.index')); ?>" class="btn btn-primary">
                    🎬 Ver más películas
                </a>
                <?php endif; ?>
                
                <a href="<?php echo e(route('reservas.index')); ?>" class="btn btn-secondary">
                    📋 Mis Reservas
                </a>
            </div>
        </div>
    </div>

    <script>
        function proceedToPayment() {
            // Aquí irá la integración con Stripe/MercadoPago
            alert('La integración de pago será implementada próximamente');
            // window.location.href = '/payment/' + <?php echo e($reserva->id); ?>;
        }
    </script>
</body>
</html>
<?php /**PATH C:\Users\Dixon\Desktop\cine_laravel\resources\views/reservas/show.blade.php ENDPATH**/ ?>