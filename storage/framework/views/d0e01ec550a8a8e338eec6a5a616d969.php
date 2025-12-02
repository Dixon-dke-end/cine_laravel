<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($movie->titulo); ?> - CineVel</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
* {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #667eea;
            --primary-dark: #5568d3;
            --secondary: #764ba2;
            --accent: #f093fb;
            
            --bg-light: #ffffff;
            --bg-gray: #f8f9fc;
            --text-dark: #1a1a2e;
            --text-gray: #6b7280;
            --text-light: #9ca3af;
            
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-soft: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            
            --shadow-sm: 0 2px 8px rgba(102, 126, 234, 0.08);
            --shadow-md: 0 4px 16px rgba(102, 126, 234, 0.12);
            --shadow-lg: 0 8px 32px rgba(102, 126, 234, 0.16);
            --shadow-glow: 0 0 40px rgba(102, 126, 234, 0.3);
            
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-image: url(/storage/movies/portada.jpg);
            color: var(--text-dark);
            line-height: 1.6;
            overflow-x: hidden;
            
        }

        /* Navigation */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
            box-shadow: var(--shadow-sm);
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.75rem;
            font-weight: 900;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.05em;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            color: var(--text-gray);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: var(--transition);
            position: relative;
            padding: 0.5rem 0;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gradient-primary);
            transition: var(--transition);
        }

        .nav-links a:hover, .nav-links a.active {
            color: var(--primary);
        }

        .nav-links a:hover::after, .nav-links a.active::after {
            width: 100%;
        }

        .user-section {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn {
            padding: 0.625rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: white;
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(102, 126, 234, 0.5);
        }

        .btn-ghost {
            background: transparent;
            color: var(--primary);
            border: 2px solid rgba(102, 126, 234, 0.3);
        }

        .btn-ghost:hover {
            border-color: var(--primary);
            background: rgba(102, 126, 234, 0.05);
        }

        .btn-admin {
            background: rgba(255, 193, 7, 0.1);
            color: #f59e0b;
            border: 2px solid rgba(255, 193, 7, 0.3);
        }

        .btn-admin:hover {
            background: rgba(255, 193, 7, 0.2);
            border-color: #f59e0b;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: var(--gradient-soft);
            border-radius: 50px;
        }

        .user-name {
            font-weight: 600;
            color: var(--text-dark);
        }

        /* Hero Section */
        .hero {
            position: relative;
            height: 60vh;
            min-height: 450px;
            overflow: hidden;
            background: var(--bg-light);
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            filter: brightness(0.4) blur(0);
            transform: scale(1.05);
            transition: transform 0.5s ease;
        }

        .hero:hover .hero-bg {
            transform: scale(1.1);
        }

        .hero-gradient {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                to bottom,
                rgba(255, 255, 255, 0.1) 0%,
                rgba(102, 126, 234, 0.6) 60%,
                rgba(118, 75, 162, 0.9) 100%
            );
        }

        /* Main Content */
        .container {
            max-width: 1400px;
            margin: -100px auto 0;
            padding: 0 2rem 4rem;
            position: relative;
            z-index: 3;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 2rem;
            margin-bottom: 3rem;
        }

        /* Poster Card */
        .poster-card {
            background: var(--bg-light);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            transition: var(--transition);
            position: sticky;
            top: 100px;
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        .poster-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-glow);
        }

        .poster-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: var(--gradient-primary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            box-shadow: var(--shadow-md);
            z-index: 1;
        }

        .poster-img {
            width: 100%;
            aspect-ratio: 2/3;
            object-fit: cover;
        }

        .poster-content {
            padding: 1.5rem;
        }

        .cta-button {
            width: 100%;
            padding: 1rem;
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(102, 126, 234, 0.5);
        }

        /* Movie Details */
        .details-section {
            background: var(--bg-light);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        .movie-title {
            font-size: 2.5rem;
            font-weight: 900;
            color: var(--text-dark);
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .movie-subtitle {
            font-size: 1.125rem;
            color: var(--text-gray);
            margin-bottom: 2rem;
            font-weight: 500;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--text-dark);
        }

        .section-title::before {
            content: '';
            width: 4px;
            height: 1.5rem;
            background: var(--gradient-primary);
            border-radius: 2px;
        }

        .meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2rem;
            padding: 2rem;
            background: var(--gradient-soft);
            border-radius: 16px;
            border: 1px solid rgba(102, 126, 234, 0.15);
        }

        .meta-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .meta-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-light);
            font-weight: 600;
        }

        .meta-value {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            background: var(--gradient-primary);
            color: white;
        }

        .synopsis-box {
            background: var(--gradient-soft);
            padding: 2rem;
            border-radius: 16px;
            border-left: 4px solid var(--primary);
            line-height: 1.8;
            color: var(--text-gray);
            margin-bottom: 2rem;
        }

        /* Trailer Button */
        .trailer-section {
            margin-bottom: 2rem;
        }

        .trailer-btn {
            padding: 1rem 2rem;
            background: rgba(102, 126, 234, 0.1);
            border: 2px solid rgba(102, 126, 234, 0.3);
            border-radius: 12px;
            color: var(--primary);
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1rem;
        }

        .trailer-btn:hover {
            background: rgba(102, 126, 234, 0.15);
            border-color: var(--primary);
            transform: translateY(-2px);
        }

        /* Schedule Section */
        .schedule-section {
            background: var(--bg-light);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        /* Date Selector */
        .date-selector {
            margin-bottom: 2.5rem;
            background: var(--gradient-soft);
            padding: 2rem;
            border-radius: 16px;
            border: 1px solid rgba(102, 126, 234, 0.15);
        }

        .date-carousel {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .carousel-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: white;
            border: 2px solid rgba(102, 126, 234, 0.2);
            color: var(--primary);
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .carousel-btn:hover:not(:disabled) {
            background: var(--gradient-primary);
            color: white;
            border-color: transparent;
            transform: scale(1.1);
            box-shadow: var(--shadow-md);
        }

        .carousel-btn:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .dates-container {
            overflow: hidden;
            flex: 1;
        }

        .dates-track {
            display: flex;
            gap: 0.75rem;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .date-card {
            min-width: 90px;
            background: white;
            border: 2px solid rgba(102, 126, 234, 0.15);
            border-radius: 16px;
            padding: 1.25rem 1rem;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .date-card:hover {
            border-color: var(--primary);
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .date-card.active {
            background: var(--gradient-primary);
            border-color: transparent;
            color: white;
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
            transform: translateY(-4px);
        }

        .date-day {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: var(--text-light);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .date-card.active .date-day {
            color: rgba(255, 255, 255, 0.9);
        }

        .date-number {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.25rem;
            color: var(--text-dark);
        }

        .date-card.active .date-number {
            color: white;
        }

        .date-month {
            font-size: 0.75rem;
            color: var(--text-gray);
            font-weight: 600;
            text-transform: capitalize;
        }

        .date-card.active .date-month {
            color: rgba(255, 255, 255, 0.9);
        }

        /* Cinema Cards - ESTRUCTURA ACTUALIZADA */
        .cinema-card {
            background: white;
            border: 1px solid rgba(102, 126, 234, 0.15);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .cinema-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .cinema-info {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(102, 126, 234, 0.1);
        }

        .cinema-name {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--text-dark);
        }

        .cinema-address {
            font-size: 0.875rem;
            color: var(--text-gray);
            font-weight: 500;
        }

        /* Cinema Group - ESTRUCTURA ANTIGUA (mantener por compatibilidad) */
        .cinema-group {
            margin-bottom: 2.5rem;
        }

        .cinema-group .cinema-name {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--text-dark);
        }

        /* Showtimes Grid - COMPATIBLE CON AMBAS ESTRUCTURAS */
        .showtimes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
            gap: 1rem;
        }

        /* Showtime Buttons - ESTILOS UNIFICADOS */
        .showtime-btn,
        .showtime-card {
            background: white;
            border: 2px solid rgba(102, 126, 234, 0.15);
            border-radius: 12px;
            padding: 1.25rem 1rem;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.25rem;
            font-family: inherit;
            font-size: inherit;
        }

        .showtime-btn:hover:not(:disabled),
        .showtime-card:hover:not(:disabled) {
            background: var(--gradient-primary);
            border-color: transparent;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
        }

        .showtime-time {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-dark);
            display: block;
        }

        .showtime-btn:hover:not(:disabled) .showtime-time,
        .showtime-card:hover:not(:disabled) .showtime-time {
            color: white;
        }

        .showtime-room {
            font-size: 0.75rem;
            color: var(--text-light);
            font-weight: 600;
            display: block;
        }

        .showtime-btn:hover:not(:disabled) .showtime-room,
        .showtime-card:hover:not(:disabled) .showtime-room {
            color: rgba(255, 255, 255, 0.9);
        }

        .showtime-btn:disabled,
        .showtime-card:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: var(--gradient-soft);
            border-radius: 16px;
            border: 2px dashed rgba(102, 126, 234, 0.2);
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.4;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }

        .empty-state p {
            color: var(--text-gray);
        }

        /* Loading */
        .loading {
            text-align: center;
            padding: 3rem;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(102, 126, 234, 0.2);
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            width: 100%;
            max-width: 1200px;
            background: var(--bg-light);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: var(--shadow-glow);
        }

        .modal-header {
            padding: 1.5rem 2rem;
            background: var(--gradient-soft);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(102, 126, 234, 0.15);
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .modal-close {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            border: 2px solid rgba(102, 126, 234, 0.2);
            color: var(--primary);
            font-size: 1.5rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-close:hover {
            background: var(--gradient-primary);
            color: white;
            border-color: transparent;
            transform: rotate(90deg);
        }

        .video-wrapper {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            background: #000;
        }

        .video-wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Animación de entrada para elementos dinámicos */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cinema-card,
        .cinema-group {
            animation: fadeInUp 0.5s ease-out;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
            }

            .poster-card {
                position: relative;
                top: 0;
                max-width: 400px;
                margin: 0 auto;
            }

            .nav-links {
                display: none;
            }

            .user-name {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 1rem 2rem;
                margin-top: -80px;
            }

            .hero {
                height: 50vh;
                min-height: 350px;
            }

            .movie-title {
                font-size: 2rem;
            }

            .details-section,
            .schedule-section {
                padding: 1.5rem;
            }

            .cinema-card {
                padding: 1.5rem;
            }

            .date-selector {
                padding: 1.5rem;
            }

            .date-card {
                min-width: 80px;
                padding: 1rem 0.75rem;
            }

            .showtimes-grid {
                grid-template-columns: repeat(auto-fill, minmax(95px, 1fr));
                gap: 0.75rem;
            }

            .showtime-btn,
            .showtime-card {
                padding: 1rem 0.75rem;
            }

            .showtime-time {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="<?php echo e(route('user.index')); ?>" class="logo">CINEVEL</a>
            
            <ul class="nav-links">
                <li><a href="#cartelera" class="active">CARTELERA</a></li>
                <li><a href="#promociones">PROMOCIONES</a></li>
                <li><a href="#proximamente">PRÓXIMAMENTE</a></li>
                <li><a href="#confiteria">CONFITERÍA</a></li>
            </ul>

            <div class="user-section">
                <?php if(auth()->guard()->guest()): ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-primary">INICIAR SESIÓN</a>
                <?php else: ?>
                    <?php if(Auth::user()->role === 'admin'): ?>
                        <a href="<?php echo e(route('movies.index')); ?>" class="btn btn-admin" title="Ver vista de administrador">
                            🔧 Admin
                        </a>
                    <?php endif; ?>
                    <div class="user-info">
                        <div class="user-avatar">
                            <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

                        </div>
                        <span class="user-name"><?php echo e(Auth::user()->name); ?></span>
                    </div>
                    <form method="POST" action="<?php echo e(route('logout')); ?>" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-ghost">
                            CERRAR SESIÓN
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-bg" style="background-image: url('<?php echo e(asset('storage/' . $movie->ruta_imagen)); ?>');"></div>
        <div class="hero-gradient"></div>
    </section>

    <!-- Main Content -->
    <div class="container">
        <div class="content-grid">
            <!-- Poster Card -->
            <div class="poster-card">
                <div class="poster-badge">En Cartelera</div>
                <img src="<?php echo e(asset('storage/' . $movie->ruta_imagen)); ?>" 
                     alt="<?php echo e($movie->titulo); ?>" 
                     class="poster-img">
                <div class="poster-content">
                    <button class="cta-button" onclick="scrollToSchedule()">
                        🎟️ Comprar Boletos
                    </button>
                </div>
            </div>

            <!-- Movie Details -->
            <div class="details-section">
                <h1 class="movie-title"><?php echo e($movie->titulo); ?></h1>

                <!-- Meta Grid -->
                <div class="meta-grid">
                    <div class="meta-item">
                        <span class="meta-label">Clasificación</span>
                        <span class="badge"><?php echo e($movie->age_suggest); ?></span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Duración</span>
                        <span class="meta-value"><?php echo e($movie->duracion); ?> min</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Género</span>
                        <span class="badge"><?php echo e($movie->genero); ?></span>
                    </div>
                    <?php if($movie->año): ?>
                    <div class="meta-item">
                        <span class="meta-label">Año</span>
                        <span class="meta-value"><?php echo e($movie->año); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if($movie->autor): ?>
                    <div class="meta-item">
                        <span class="meta-label">Director</span>
                        <span class="meta-value"><?php echo e($movie->autor); ?></span>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Synopsis -->
                <?php if($movie->descripcion): ?>
                <h2 class="section-title">Sinopsis</h2>
                <div class="synopsis-box">
                    <?php echo e($movie->descripcion); ?>

                </div>
                <?php endif; ?>

                <!-- Trailer -->
                <?php if($movie->trailer_url): ?>
                <div class="trailer-section">
                    <button class="trailer-btn" onclick="openTrailer()">
                        ▶️ Ver Tráiler
                    </button>
                </div>
                <?php endif; ?>
            </div>
        </div>
<!-- Schedule Section -->
<section class="schedule-section" id="scheduleSection">
    <h2 class="section-title">Horarios Disponibles</h2>

    <?php
        $ahora = \Carbon\Carbon::now();
        $fechaHoy = $ahora->format('Y-m-d');
        $horaActual = $ahora->format('H:i:s');
        
        // Filtrar solo funciones futuras
        $funcionesFuturas = $funciones->filter(function($f) use ($ahora) {
            return \Carbon\Carbon::parse($f->hora)->isAfter($ahora);
        });
        
        // Obtener fechas con funciones futuras
        $fechasCalendario = collect();
        for ($i = 0; $i < 14; $i++) {
            $fecha = \Carbon\Carbon::now()->addDays($i)->format('Y-m-d');
            
            // Verificar si hay funciones futuras en esta fecha
            $tieneFuncionesFuturas = $funcionesFuturas->filter(function ($f) use ($fecha, $ahora) {
                $fechaFuncion = \Carbon\Carbon::parse($f->hora);
                return $fechaFuncion->format('Y-m-d') === $fecha && $fechaFuncion->isAfter($ahora);
            })->isNotEmpty();
            
            if ($tieneFuncionesFuturas) {
                $fechasCalendario->push($fecha);
            }
        }
        
        // Obtener la primera fecha disponible con funciones futuras
        $diaActivo = $fechasCalendario->first() ?? $fechaHoy;
    ?>

    <?php if($fechasCalendario->isEmpty()): ?>
        <div class="empty-state">
            <div class="empty-icon">🎬</div>
            <h3>No hay funciones disponibles</h3>
            <p>No hay funciones programadas en los próximos 14 días</p>
        </div>
    <?php else: ?>
        <!-- Date Selector -->
        <div class="date-selector">
            <div class="date-carousel">
                <button class="carousel-btn" id="prevBtn" onclick="moveCarousel(-1)">◄</button>
                
                <div class="dates-container">
                    <div class="dates-track" id="datesTrack">
                        <?php $__currentLoopData = $fechasCalendario; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $fecha): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $carbon = \Carbon\Carbon::parse($fecha);
                                $esActivo = $fecha === $diaActivo;
                            ?>
                            <div class="date-card <?php echo e($esActivo ? 'active' : ''); ?>" 
                                 data-fecha="<?php echo e($fecha); ?>"
                                 onclick="selectDay(this)">
                                <div class="date-day"><?php echo e($carbon->locale('es')->isoFormat('ddd')); ?></div>
                                <div class="date-number"><?php echo e($carbon->format('d')); ?></div>
                                <div class="date-month"><?php echo e($carbon->locale('es')->isoFormat('MMM')); ?></div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <button class="carousel-btn" id="nextBtn" onclick="moveCarousel(1)">►</button>
            </div>
        </div>

        <!-- Cinema List -->
        <div id="cinemaList">
            <?php
                // Filtrar funciones del día activo que sean futuras
                $funcionesDelDia = $funcionesFuturas->filter(function($f) use ($diaActivo, $ahora) {
                    $fechaFuncion = \Carbon\Carbon::parse($f->hora);
                    return $fechaFuncion->format('Y-m-d') === $diaActivo && $fechaFuncion->isAfter($ahora);
                })->groupBy('sala.nombre_sala');
            ?>

            <?php if($funcionesDelDia->count() > 0): ?>
                <?php $__currentLoopData = $funcionesDelDia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salaNombre => $funcionesSala): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="cinema-group">
                        <div class="cinema-name">🎭 <?php echo e(htmlspecialchars($salaNombre)); ?></div>
                        <div class="showtimes-grid">
                            <?php $__currentLoopData = $funcionesSala->sortBy(fn($f) => \Carbon\Carbon::parse($f->hora)); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $funcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $hora = \Carbon\Carbon::parse($funcion->hora)->format('H:i');
                                ?>
                                <button class="showtime-card" onclick="reservarFuncion(<?php echo e($funcion->id); ?>)">
                                    <div class="showtime-time"><?php echo e($hora); ?></div>
                                    <div class="showtime-room">Sala <?php echo e($funcion->sala_id); ?></div>
                                </button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">🎬</div>
                    <h3>No hay funciones disponibles</h3>
                    <p>Selecciona otro día para ver las funciones disponibles</p>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>
    </div>

    <!-- Trailer Modal -->
    <div class="modal" id="trailerModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Tráiler - <?php echo e($movie->titulo); ?></h3>
                <button class="modal-close" onclick="closeTrailer()">×</button>
            </div>
            <div class="video-wrapper" id="videoContainer"></div>
        </div>
    </div>

    <script>
        let currentPosition = 0;
        const cardsPerPage = 5;

        // Open Trailer Modal
        function openTrailer() {
            const modal = document.getElementById('trailerModal');
            const videoContainer = document.getElementById('videoContainer');
            const trailerUrl = '<?php echo e($movie->trailer_url ?? ""); ?>';
            
            if (trailerUrl) {
                videoContainer.innerHTML = `<iframe src="${trailerUrl}" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>`;
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }

        // Close Trailer Modal
        function closeTrailer() {
            const modal = document.getElementById('trailerModal');
            const videoContainer = document.getElementById('videoContainer');
            
            modal.classList.remove('active');
            videoContainer.innerHTML = '';
            document.body.style.overflow = 'auto';
        }

        // Close modal on outside click
        document.getElementById('trailerModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeTrailer();
            }
        });

        // Scroll to Schedule
        function scrollToSchedule() {
            document.getElementById('scheduleSection').scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        }

        // Carousel Navigation
        function moveCarousel(direction) {
            const track = document.getElementById('datesTrack');
            const items = track.querySelectorAll('.date-card');
            const totalItems = items.length;
            
            if (items.length === 0) return;
            
            const itemWidth = items[0].offsetWidth + 12;
            currentPosition += direction;
            
            const maxPosition = Math.max(0, totalItems - cardsPerPage);
            currentPosition = Math.max(0, Math.min(currentPosition, maxPosition));
            
            track.style.transform = `translateX(-${currentPosition * itemWidth}px)`;
            updateCarouselButtons(totalItems);
        }

        function updateCarouselButtons(totalItems) {
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            
            prevBtn.disabled = currentPosition === 0;
            nextBtn.disabled = currentPosition >= totalItems - cardsPerPage;
        }

        // Select Day
        function selectDay(dayItem) {
            document.querySelectorAll('.date-card').forEach(item => {
                item.classList.remove('active');
            });
            dayItem.classList.add('active');

            const fecha = dayItem.dataset.fecha;
            const movieId = window.location.pathname.split('/').pop();
            
            const cinemaList = document.getElementById('cinemaList');
            cinemaList.innerHTML = `
                <div class="loading">
                    <div class="spinner"></div>
                    <h3 style="color: var(--primary);">Cargando funciones...</h3>
                </div>
            `;

            fetch(`/movies/${movieId}/funciones-por-fecha?fecha=${fecha}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.empty) {
                            cinemaList.innerHTML = `
                                <div class="empty-state">
                                    <div class="empty-icon">🎬</div>
                                    <h3>No hay funciones disponibles</h3>
                                    <p>Selecciona otro día para ver las funciones disponibles</p>
                                </div>
                            `;
                        } else {
                            cinemaList.innerHTML = data.html;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    cinemaList.innerHTML = `
                        <div class="empty-state">
                            <div class="empty-icon">⚠️</div>
                            <h3>Error al cargar funciones</h3>
                            <p>Por favor, intenta nuevamente</p>
                        </div>
                    `;
                });
        }

        // Reserve Function
        function reservarFuncion(funcionId) {
            window.location.href = `/reservas/create/${funcionId}`;
        }

        // Initialize
        window.addEventListener('load', () => {
            const items = document.querySelectorAll('.date-card');
            updateCarouselButtons(items.length);

            // Adjust carousel on resize
            window.addEventListener('resize', () => {
                const track = document.getElementById('datesTrack');
                const items = track.querySelectorAll('.date-card');
                if (items.length > 0) {
                    const itemWidth = items[0].offsetWidth + 12;
                    const maxPosition = Math.max(0, items.length - cardsPerPage);
                    if (currentPosition > maxPosition) {
                        currentPosition = maxPosition;
                    }
                    track.style.transform = `translateX(-${currentPosition * itemWidth}px)`;
                    updateCarouselButtons(items.length);
                }
            });
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeTrailer();
            }
        });
    </script>
</body>
</html><?php /**PATH C:\Users\Dixon\Desktop\cine_laravel\resources\views/user/user_func.blade.php ENDPATH**/ ?>