<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($promocion->titulo); ?> - CineVel</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        :root {
            --primary: #667eea;
            --primary-dark: #5a67d8;
            --secondary: #764ba2;
            --text-main: #1a202c;
            --text-muted: #718096;
            --bg-body: #f4f6f9;
            --gradient-main: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-body);
            color: var(--text-main);
            margin: 0;
            padding: 0;
        }

        /* Navbar (Same as other pages) */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }

        .navbar-container {
            max-width: 1200px;
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

        .navbar-menu {
            display: flex;
            gap: 2rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .navbar-menu a {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: color 0.2s;
        }

        .navbar-menu a:hover, .navbar-menu a.active {
            color: var(--primary);
        }

        /* Breadcrumbs */
        .breadcrumbs {
            max-width: 1200px;
            margin: 1rem auto;
            padding: 0 2rem;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .breadcrumbs a {
            color: var(--text-muted);
            text-decoration: none;
        }

        .breadcrumbs a:hover {
            color: var(--primary);
        }

        /* Banner */
        .promo-banner {
            width: 100%;
            height: 400px;
            object-fit: cover;
            background: #eee;
        }

        /* Content Layout */
        .content-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .promo-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 2rem;
            text-transform: uppercase;
            color: #333;
        }

        .details-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 3rem;
        }

        /* Left Column: Description */
        .description-section h3 {
            color: #cc0000; /* Red accent like reference */
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-transform: uppercase;
        }

        .description-text {
            font-size: 1rem;
            line-height: 1.8;
            color: #4a5568;
            margin-bottom: 1.5rem;
        }

        .cta-button {
            display: inline-block;
            background: #cc0000; /* Red button */
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            margin-top: 1rem;
            transition: background 0.2s;
        }

        .cta-button:hover {
            background: #a30000;
        }

        /* Right Column: Conditions */
        .conditions-box {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .conditions-title {
            color: #cc0000;
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 1rem;
            text-transform: uppercase;
        }

        .conditions-list {
            list-style: disc;
            padding-left: 1.5rem;
            color: #4a5568;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .conditions-list li {
            margin-bottom: 0.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .details-grid {
                grid-template-columns: 1fr;
            }
            .promo-banner {
                height: 250px;
            }
            .promo-title {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar --><!-- Navbar -->
<nav class="navbar">
    <div class="navbar-container">
        <a href="<?php echo e(route('user.index')); ?>" class="navbar-brand">CineVel</a>
        <ul class="navbar-menu">
            <li><a href="<?php echo e(route('user.index')); ?>#cartelera">CARTELERA</a></li>
            <li><a href="<?php echo e(route('promociones.user')); ?>" class="active">PROMOCIONES</a></li>
            <li><a href="<?php echo e(route('confiteria.user')); ?>">CONFITERÍA</a></li>
        </ul>
        
        <div class="navbar-user">
            <?php if(auth()->guard()->guest()): ?>
                <a href="<?php echo e(route('login')); ?>" class="btn-auth btn-login">Iniciar Sesión</a>
            <?php else: ?>
                <div class="user-info">
                    <div class="user-avatar">
                        <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

                    </div>
                    <span class="user-name"><?php echo e(Auth::user()->name); ?></span>
                </div>
                <form action="<?php echo e(route('logout')); ?>" method="POST" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn-auth btn-logout">Cerrar Sesión</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</nav>

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <a href="<?php echo e(route('user.index')); ?>">Inicio</a> &gt; 
        <a href="<?php echo e(route('promociones.user')); ?>">Promociones</a> &gt; 
        <span><?php echo e(strtolower($promocion->titulo)); ?></span>
    </div>

    <!-- Banner Image -->
    <?php if($promocion->imagen): ?>
        <img src="<?php echo e(asset('storage/'.$promocion->imagen)); ?>" alt="<?php echo e($promocion->titulo); ?>" class="promo-banner">
    <?php else: ?>
        <img src="https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?w=1200&h=400&fit=crop" alt="Banner por defecto" class="promo-banner">
    <?php endif; ?>

    <!-- Main Content -->
    <div class="content-container">
        <h1 class="promo-title"><?php echo e($promocion->titulo); ?></h1>

        <div class="details-grid">
            <!-- Left Column -->
            <div class="description-section">
                <h3>DESCRIPCIÓN DE LA PROMOCIÓN</h3>
                
                <?php
                    // Split description roughly in half for visual effect if it's long enough
                    $text = $promocion->descripcion;
                    $length = strlen($text);
                    $mid = $length / 2;
                    $splitPos = strpos($text, ' ', $mid);
                    
                    if ($splitPos !== false) {
                        $part1 = substr($text, 0, $splitPos);
                        $part2 = substr($text, $splitPos);
                    } else {
                        $part1 = $text;
                        $part2 = '';
                    }
                ?>

                <div class="description-text">
                    <p><?php echo e($part1); ?></p>
                </div>
                
                <?php if($part2): ?>
                <div class="description-text">
                    <p><?php echo e($part2); ?></p>
                </div>
                <?php endif; ?>

                <h3>Asegura ya las tuyas <a href="<?php echo e(route('user.index')); ?>" style="color: #000; text-decoration: underline;">AQUÍ</a></h3>
            </div>

            <!-- Right Column -->
            <div class="conditions-box">
                <div class="conditions-title">CONDICIONES DE LA PROMOCIÓN</div>
                <ul class="conditions-list">
                    <li>Promoción válida hasta <?php echo e($promocion->fecha_fin->format('d/m/Y')); ?>.</li>
                    <li>Válido en todos los teatros CineVel a nivel nacional.</li>
                    <li>No acumulable con otras promociones.</li>
                    <li>Sujeto a disponibilidad de sala y formato.</li>
                    <?php if($promocion->codigo): ?>
                        <li>Código de promoción: <strong><?php echo e($promocion->codigo); ?></strong></li>
                    <?php endif; ?>
                    <li>Aplican términos y condiciones generales de CineVel.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer style="text-align: center; padding: 2rem; color: #718096; border-top: 1px solid #eee; margin-top: 4rem;">
        <p>&copy; 2024 CineVel. Todos los derechos reservados.</p>
    </footer>

</body>
</html>
<?php /**PATH C:\Users\Dixon\Desktop\cine_laravel\resources\views/user/promocion_detalles.blade.php ENDPATH**/ ?>