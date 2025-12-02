<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Confitería - <?php echo e($reserva->funcion->movies->titulo); ?></title>
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
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
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

        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: var(--shadow-sm);
        }

        .navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1rem 2rem;
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

        /* Progress Bar */
        .progress-bar {
            background: white;
            border-bottom: 2px solid rgba(102, 126, 234, 0.1);
            padding: 1.5rem 0;
        }

        .progress-container {
            max-width: 800px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            padding: 0 2rem;
        }

        .progress-container::before {
            content: '';
            position: absolute;
            top: 17px;
            left: 60px;
            right: 60px;
            height: 2px;
            background: rgba(102, 126, 234, 0.2);
            z-index: 0;
        }

        .progress-step {
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
            z-index: 1;
        }

        .progress-step.completed .step-number {
            background: var(--success);
            color: white;
            border-color: var(--success);
        }

        .progress-step.active .step-number {
            background: var(--gradient-main);
            color: white;
            border-color: var(--primary);
        }

        .step-number {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: white;
            border: 2px solid #e0e4e8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Header */
        .header-section {
            background: var(--gradient-main);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .header-section h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        /* Main Container */
        .main-container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 2rem;
        }

        /* Sidebar - Resumen de Reserva */
        .reserva-summary {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 2rem;
            box-shadow: var(--shadow-sm);
            height: fit-content;
            position: sticky;
            top: 100px;
        }

        .reserva-summary h2 {
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
            color: var(--text-main);
        }

        .movie-poster {
            width: 100%;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-md);
        }

        .info-item {
            margin-bottom: 1rem;
            padding: 0.75rem;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 8px;
            border-left: 3px solid var(--primary);
        }

        .info-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .timer {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff8e53 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
            margin-top: 1.5rem;
        }

        .timer-value {
            font-size: 2rem;
            font-weight: bold;
        }

        /* Products Section */
        .products-section {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 2rem;
            box-shadow: var(--shadow-sm);
        }

        .section-header {
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .product-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .product-info {
            padding: 1.25rem;
        }

        .product-name {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 800;
            background: var(--gradient-main);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #f5f7fa;
            border-radius: 10px;
            padding: 0.25rem;
            margin-bottom: 0.75rem;
        }

        .qty-btn {
            width: 32px;
            height: 32px;
            border: none;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
            color: var(--primary);
            transition: all 0.2s ease;
        }

        .qty-btn:hover {
            background: var(--primary);
            color: white;
        }

        .qty-input {
            width: 45px;
            text-align: center;
            border: none;
            background: transparent;
            font-weight: 700;
        }

        .btn-add-cart {
            width: 100%;
            background: var(--success);
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-add-cart:hover {
            background: #059669;
        }

        /* Cart Section */
        .cart-section {
            background: #f5f7fa;
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 2rem;
        }

        .cart-header {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .cart-item {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            background: white;
            border-radius: 10px;
            margin-bottom: 0.75rem;
        }

        .cart-item-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
        }

        .cart-item-info {
            flex: 1;
        }

        .cart-summary {
            border-top: 2px solid #e0e4e8;
            padding-top: 1rem;
            margin-top: 1rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .summary-row.total {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
            padding-top: 0.75rem;
            border-top: 2px solid #e0e4e8;
        }

        /* Bottom Actions */
        .bottom-actions {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-top: 2px solid rgba(102, 126, 234, 0.2);
            padding: 1.5rem;
            box-shadow: 0 -4px 25px rgba(0, 0, 0, 0.1);
            z-index: 100;
        }

        .actions-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2rem;
        }

        .total-display {
            font-size: 2rem;
            font-weight: 800;
            background: var(--gradient-main);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-skip {
            background: rgba(102, 126, 234, 0.1);
            color: var(--primary);
        }

        .btn-skip:hover {
            background: rgba(102, 126, 234, 0.2);
        }

        .btn-continue {
            background: var(--gradient-main);
            color: white;
            box-shadow: var(--shadow-md);
        }

        .btn-continue:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        @media (max-width: 1024px) {
            .main-container {
                grid-template-columns: 1fr;
            }

            .reserva-summary {
                position: static;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="<?php echo e(route('user.index')); ?>" class="navbar-brand">CineVel</a>
        </div>
    </nav>

    <!-- Progress Bar -->
    <div class="progress-bar">
        <div class="progress-container">
            <div class="progress-step completed">
                <div class="step-number">✓</div>
                <span>Asientos</span>
            </div>
            <div class="progress-step active">
                <div class="step-number">2</div>
                <span>Confitería</span>
            </div>
            <div class="progress-step">
                <div class="step-number">3</div>
                <span>Pago</span>
            </div>
        </div>
    </div>

    <!-- Header -->
    <div class="header-section">
        <h1>🍿 ¿Deseas agregar algo de confitería?</h1>
        <p>Opcional - Puedes continuar sin agregar productos</p>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Sidebar - Resumen Reserva -->
        <div class="reserva-summary">
            <h2>📋 Tu Reserva</h2>
            
            <img src="<?php echo e(asset('storage/' . $reserva->funcion->movies->ruta_imagen)); ?>" 
                 alt="<?php echo e($reserva->funcion->movies->titulo); ?>"
                 class="movie-poster">

            <div class="info-item">
                <div class="info-label">Película</div>
                <div class="info-value"><?php echo e($reserva->funcion->movies->titulo); ?></div>
            </div>

            <div class="info-item">
                <div class="info-label">Sala</div>
                <div class="info-value"><?php echo e($reserva->funcion->Sala->nombre_sala); ?></div>
            </div>

            <div class="info-item">
                <div class="info-label">Fecha y Hora</div>
                <div class="info-value">
                    <?php echo e(\Carbon\Carbon::parse($reserva->funcion->hora)->format('d/m/Y H:i')); ?>

                </div>
            </div>

            <div class="info-item">
                <div class="info-label">Asientos</div>
                <div class="info-value">
                    <?php echo e($reserva->sillas->pluck('silla.nombre')->implode(', ')); ?>

                </div>
            </div>

            <div class="info-item">
                <div class="info-label">Total Boletas</div>
                <div class="info-value">$<?php echo e(number_format($reserva->precio_total, 0, ',', '.')); ?></div>
            </div>

            <div class="timer">
                <div class="timer-label">⏱️ Tiempo restante</div>
                <div class="timer-value" id="timer">15:00</div>
            </div>
        </div>

        <!-- Products Section -->
        <div class="products-section">
            <div class="section-header">
                <h2 class="section-title">Nuestros Productos</h2>
                <p style="color: var(--text-muted);">Agrega tus snacks favoritos (opcional)</p>
            </div>

            <div class="products-grid">
                <?php $__empty_1 = true; $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="product-card">
                    <img src="<?php echo e($producto->imagen ? asset('storage/' . $producto->imagen) : 'https://images.unsplash.com/photo-1585647347384-2593bc35786b?w=300&h=200&fit=crop'); ?>" 
                         alt="<?php echo e($producto->nombre); ?>" 
                         class="product-image">
                    
                    <div class="product-info">
                        <div class="product-name"><?php echo e($producto->nombre); ?></div>
                        <div class="product-price">$<?php echo e(number_format($producto->precio, 0, ',', '.')); ?></div>
                        
                        <form action="<?php echo e(route('carrito.agregar')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="producto_id" value="<?php echo e($producto->id); ?>">
                            
                            <div class="quantity-selector">
                                <button type="button" class="qty-btn" onclick="cambiarCantidad(<?php echo e($producto->id); ?>, -1)">−</button>
                                <input type="number" class="qty-input" id="qty-<?php echo e($producto->id); ?>" name="cantidad" value="1" min="1" max="<?php echo e($producto->stock); ?>" readonly>
                                <button type="button" class="qty-btn" onclick="cambiarCantidad(<?php echo e($producto->id); ?>, 1)">+</button>
                            </div>
                            
                            <button type="submit" class="btn-add-cart">🛒 Agregar</button>
                        </form>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p style="grid-column: 1/-1; text-align: center; color: var(--text-muted);">
                    No hay productos disponibles
                </p>
                <?php endif; ?>
            </div>

            <!-- Cart Section -->
            <?php if($carrito->isNotEmpty()): ?>
            <div class="cart-section">
                <div class="cart-header">🛒 Tu Carrito de Confitería</div>
                
                <?php $__currentLoopData = $carrito; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="cart-item">
                    <img src="<?php echo e($item->producto->imagen ? asset('storage/' . $item->producto->imagen) : 'https://images.unsplash.com/photo-1585647347384-2593bc35786b?w=100&h=100&fit=crop'); ?>" 
                         class="cart-item-image">
                    
                    <div class="cart-item-info">
                        <div style="font-weight: 700;"><?php echo e($item->producto->nombre); ?></div>
                        <div style="color: var(--primary); font-weight: 600;">
                            $<?php echo e(number_format($item->producto->precio, 0, ',', '.')); ?> × <?php echo e($item->cantidad); ?>

                        </div>
                    </div>
                    
                    <form action="<?php echo e(route('carrito.eliminar', $item->id)); ?>" method="POST" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" style="background: var(--danger); color: white; border: none; padding: 0.5rem 1rem; border-radius: 8px; cursor: pointer;">
                            🗑️
                        </button>
                    </form>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <div class="cart-summary">
                    <div class="summary-row">
                        <span>Subtotal Confitería:</span>
                        <span>$<?php echo e(number_format($subtotal, 0, ',', '.')); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Cargo servicio (5%):</span>
                        <span>$<?php echo e(number_format($cargoServicio, 0, ',', '.')); ?></span>
                    </div>
                    <div class="summary-row total">
                        <span>Total Confitería:</span>
                        <span>$<?php echo e(number_format($totalConfiteria, 0, ',', '.')); ?></span>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bottom Actions -->
    <div class="bottom-actions">
        <div class="actions-container">
            <div class="total-display">
                Total: $<?php echo e(number_format($reserva->precio_total + ($totalConfiteria ?? 0), 0, ',', '.')); ?>

            </div>
            
            <div class="action-buttons">
                <!-- Omitir confitería -->
                <a href="<?php echo e(route('pagos.checkout', $reserva->id)); ?>" class="btn btn-skip">
                    Continuar sin Confitería
                </a>
                
                <!-- Agregar confitería y continuar -->
                <?php if($carrito->isNotEmpty()): ?>
                <form action="<?php echo e(route('pedidos.confiteria.crear')); ?>" method="POST" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="reserva_id" value="<?php echo e($reserva->id); ?>">
                    <button type="submit" class="btn btn-continue">
                        Agregar Confitería y Continuar →
                    </button>
                </form>
                <?php else: ?>
                <button class="btn btn-continue" disabled style="opacity: 0.5; cursor: not-allowed;">
                    Agregar productos primero
                </button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function cambiarCantidad(productoId, cambio) {
            const input = document.getElementById(`qty-${productoId}`);
            let cantidad = parseInt(input.value) + cambio;
            const max = parseInt(input.max);
            
            if (cantidad < 1) cantidad = 1;
            if (cantidad > max) cantidad = max;
            
            input.value = cantidad;
        }


    </script>
</body>
</html><?php /**PATH C:\Users\Dixon\Desktop\cine_laravel\resources\views/user/reservaComfi.blade.php ENDPATH**/ ?>