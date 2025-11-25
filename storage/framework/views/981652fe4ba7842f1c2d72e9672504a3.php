<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Películas Próximamente</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/admin_index.css', 'resources/js/app.js']); ?>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f1419 0%, #1a2942 100%);
            color: #fff;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* NAVBAR */
        .navbar {
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            background: rgba(22, 33, 62, 0.98);
            border-bottom: 2px solid #00d4ff;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
        }

        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            gap: 2rem;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #00d4ff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            color: #fff;
            text-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #000;
        }

        .btn-add-navbar {
            padding: 0.6rem 1.2rem;
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            color: #000;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-add-navbar:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 212, 255, 0.3);
        }

        /* MAIN CONTAINER */
        .main-container {
            display: flex;
            margin-top: 70px;
            min-height: calc(100vh - 70px);
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            left: 0;
            top: 70px;
            width: 280px;
            height: calc(100vh - 70px);
            background: rgba(22, 33, 62, 0.95);
            border-right: 2px solid #00d4ff;
            padding: 2rem 0;
            overflow-y: auto;
            z-index: 900;
        }

        .sidebar-title {
            padding: 1rem 1.5rem;
            font-size: 0.9rem;
            color: #00d4ff;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(0, 212, 255, 0.2);
            margin-bottom: 0.5rem;
        }

        .accordion-item {
            border-bottom: 1px solid rgba(0, 212, 255, 0.1);
        }

        .accordion-header {
            padding: 1rem 1.5rem;
            background: none;
            border: none;
            color: #fff;
            cursor: pointer;
            font-size: 0.95rem;
            width: 100%;
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .accordion-header:hover {
            background: rgba(0, 212, 255, 0.1);
            padding-left: 1.8rem;
        }

        .accordion-header.active {
            color: #00d4ff;
            background: rgba(0, 212, 255, 0.15);
        }

        .accordion-icon {
            transition: transform 0.3s ease;
            font-size: 1.1rem;
        }

        .accordion-header.active .accordion-icon {
            transform: rotate(180deg);
        }

        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .accordion-content.active {
            max-height: 500px;
        }

        .accordion-links {
            padding: 0.5rem 0;
        }

        .accordion-link {
            display: block;
            padding: 0.8rem 2rem;
            color: #b0b0b0;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            font-size: 0.9rem;
        }

        .accordion-link:hover {
            color: #00d4ff;
            background: rgba(0, 212, 255, 0.1);
            border-left-color: #00d4ff;
            padding-left: 2.3rem;
        }

        /* CONTENT WRAPPER */
        .content-wrapper {
            margin-left: 280px;
            flex: 1;
            width: calc(100% - 280px);
            padding: 2rem;
            overflow-y: auto;
        }

        .content {
            max-width: 1400px;
            margin: 0 auto;
        }

        .content h1 {
            margin-bottom: 2rem;
            color: #00d4ff;
            font-size: 2.2rem;
        }

        /* ALERTS */
        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;
            border-left: 4px solid;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .alert-success {
            background: rgba(76, 175, 80, 0.15);
            border-left-color: #4CAF50;
            color: #fff;
        }

        .alert-error {
            background: rgba(244, 67, 54, 0.15);
            border-left-color: #f44336;
            color: #fff;
        }

        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            background: rgba(0, 212, 255, 0.1);
            border-radius: 12px;
            border: 2px dashed #00d4ff;
            margin-top: 2rem;
        }

        .empty-state h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #00d4ff;
        }

        .empty-state p {
            font-size: 1.1rem;
            color: #b0b0b0;
            margin-bottom: 1rem;
        }

        .btn-add {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            color: #000;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-add:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 212, 255, 0.3);
        }

        /* MOVIES WRAPPER */
        .movies-wrapper {
            position: relative;
            margin-top: 2rem;
        }

        .nav-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 212, 255, 0.2);
            border: 2px solid #00d4ff;
            color: #00d4ff;
            font-size: 2rem;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .nav-button:hover {
            background: rgba(0, 212, 255, 0.4);
            transform: translateY(-50%) scale(1.1);
        }

        .nav-button.left {
            left: -30px;
        }

        .nav-button.right {
            right: -30px;
        }

        .movies-container {
            display: flex;
            gap: 1.5rem;
            overflow-x: auto;
            padding: 2rem 0;
            scroll-behavior: smooth;
        }

        .movie-card {
            flex: 0 0 280px;
            background: rgba(0, 212, 255, 0.05);
            border: 2px solid rgba(0, 212, 255, 0.2);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .movie-card:hover {
            border-color: #00d4ff;
            box-shadow: 0 10px 30px rgba(0, 212, 255, 0.3);
        }

        .movie-poster-container {
            position: relative;
            overflow: hidden;
            height: 350px;
            background: rgba(0, 0, 0, 0.3);
        }

        .movie-poster {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .movie-card:hover .movie-poster {
            transform: scale(1.05);
        }

        .movie-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, transparent, rgba(0, 0, 0, 0.8));
        }

        .movie-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 193, 7, 0.9);
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            color: #000;
        }

        .movie-info {
            padding: 1.5rem;
        }

        .movie-title {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: #00d4ff;
        }

        .movie-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
            color: #b0b0b0;
            flex-wrap: wrap;
        }

        .movie-year, .movie-duration {
            display: inline-block;
        }

        .movie-author {
            font-size: 0.9rem;
            color: #b0b0b0;
            margin-bottom: 0.5rem;
        }

        .movie-description {
            font-size: 0.85rem;
            color: #999;
            margin-bottom: 1rem;
            line-height: 1.4;
            max-height: 60px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .movie-actions {
            display: flex;
            gap: 0.5rem;
            flex-direction: column;
            position: relative;
            z-index: 2;
        }

        .btn {
            padding: 0.6rem;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            width: 100%;
        }

        .btn-edit {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: #fff;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
        }

        .btn-delete {
            background: linear-gradient(135deg, #f44336, #d32f2f);
            color: #fff;
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(244, 67, 54, 0.3);
        }

        .btn-promote {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: #fff;
        }

        .btn-promote:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
        }

        form {
            width: 100%;
        }

        form .btn {
            width: 100%;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar {
                width: 250px;
            }

            .content-wrapper {
                margin-left: 250px;
                width: calc(100% - 250px);
                padding: 1rem;
            }

            .nav-button.left {
                left: 0;
            }

            .nav-button.right {
                right: 0;
            }

            .navbar {
                padding: 1rem;
                height: 70px;
            }

            .navbar-container {
                gap: 1rem;
            }

            .btn-add-navbar {
                padding: 0.5rem 0.8rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 600px) {
            .sidebar {
                display: none;
            }

            .main-container {
                margin-top: 70px;
            }

            .content-wrapper {
                margin-left: 0;
                width: 100%;
                padding: 1rem;
            }

            .movies-container {
                padding: 1rem 0;
            }

            .movie-card {
                flex: 0 0 200px;
            }

            .navbar {
                padding: 0.8rem;
                height: auto;
                flex-wrap: wrap;
            }

            .navbar-brand {
                font-size: 1.2rem;
            }

            .navbar-user {
                gap: 0.5rem;
            }

            .btn-add-navbar {
                font-size: 0.8rem;
                padding: 0.4rem 0.6rem;
            }

            .content h1 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 400px) {
            .movie-card {
                flex: 0 0 150px;
            }

            .movie-poster-container {
                height: 220px;
            }

            .movie-title {
                font-size: 0.9rem;
            }

            .btn {
                font-size: 0.8rem;
                padding: 0.4rem;
            }
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="<?php echo e(route('movies.index')); ?>" class="navbar-brand">
                🎬 CineVel (Admin)
            </a>
            
            <div class="navbar-user">
                <div class="user-info">
                    <div class="user-avatar">
                        <?php if(auth()->guard()->check()): ?>
                            <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

                        <?php else: ?>
                            I
                        <?php endif; ?>
                    </div>
                    <span><?php echo e(Auth::user()->name ?? 'Invitado'); ?></span>
                </div>
                <a href="<?php echo e(route('proximamente.create')); ?>" class="btn-add-navbar">
                    ➕ Agregar Película
                </a>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTAINER -->
    <div class="main-container">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-title">Menú Principal</div>
            
            <div class="accordion-item">
                <button class="accordion-header" onclick="toggleAccordion(this)">
                    <span>📽️ Películas</span>
                    <span class="accordion-icon">▼</span>
                </button>
                <div class="accordion-content">
                    <div class="accordion-links">
                        <a href="<?php echo e(route('movies.index')); ?>" class="accordion-link">Ver todas</a>
                        <a href="<?php echo e(route('proximamente.index')); ?>" class="accordion-link">Próximamente</a>
                        <a href="<?php echo e(route('movies.index')); ?>" class="accordion-link">En cartelera</a>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-header" onclick="toggleAccordion(this)">
                    <span>🎟️ Funciones</span>
                    <span class="accordion-icon">▼</span>
                </button>
                <div class="accordion-content">
                    <div class="accordion-links">
                        <a href="#" class="accordion-link">Listar funciones</a>
                        <a href="#" class="accordion-link">Crear función</a>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <button class="accordion-header" onclick="toggleAccordion(this)">
                    <span>⚙️ Configuración</span>
                    <span class="accordion-icon">▼</span>
                </button>
                <div class="accordion-content">
                    <div class="accordion-links">
                        <a href="#" class="accordion-link">Perfil</a>
                        <a href="<?php echo e(route('logout')); ?>" class="accordion-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Cerrar sesión
                        </a>
                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                            <?php echo csrf_field(); ?>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <!-- CONTENT WRAPPER -->
        <div class="content-wrapper">
            <div class="content">
                <h1>🎬 Películas Próximamente</h1>

                <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <span>✅</span>
                        <span><?php echo e(session('success')); ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if(session('error')): ?>
                    <div class="alert alert-error">
                        <span>❌</span>
                        <span><?php echo e(session('error')); ?></span>
                    </div>
                <?php endif; ?>

                <?php if($movies->isEmpty()): ?>
                    <div class="empty-state">
                        <h2>📽️ No hay películas próximamente</h2>
                        <p>Agrega películas que se estrenarán próximamente</p>
                        <a href="<?php echo e(route('proximamente.create')); ?>" class="btn-add">Agregar Primera Película</a>
                    </div>
                <?php else: ?>
                    <div class="movies-wrapper">
                        <button class="nav-button left" onclick="scrollMovies('left')">‹</button>
                        <button class="nav-button right" onclick="scrollMovies('right')">›</button>
                        
                        <div class="movies-container" id="moviesContainer">
                            <?php $__currentLoopData = $movies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $peli): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="movie-card">
                                    <div class="movie-poster-container">
                                        <img src="<?php echo e(asset('storage/'.$peli->ruta_imagen)); ?>" 
                                             alt="Imagen de <?php echo e($peli->titulo); ?>" 
                                             class="movie-poster">
                                        <div class="movie-overlay"></div>
                                        <div class="movie-badge">📅 PRÓXIMAMENTE</div>
                                    </div>
                                    
                                    <div class="movie-info">
                                        <div class="movie-title"><?php echo e($peli->titulo); ?></div>
                                        
                                        <div class="movie-meta">
                                            <?php if($peli->año): ?>
                                                <span class="movie-year">📅 <?php echo e($peli->año); ?></span>
                                            <?php endif; ?>
                                            <?php if($peli->duracion): ?>
                                                <span class="movie-duration">⏱️ <?php echo e($peli->duracion); ?> min</span>
                                            <?php endif; ?>
                                        </div>

                                        <?php if($peli->autor): ?>
                                            <div class="movie-author">🎬 <?php echo e($peli->autor); ?></div>
                                        <?php endif; ?>
                                        
                                        <div class="movie-description">
                                            <?php echo e($peli->descripcion ?? 'Sin descripción disponible'); ?>

                                        </div>

                                        <div class="movie-actions">
                                            <form action="<?php echo e(route('proximamente.promover', $peli->id)); ?>" 
                                                  method="POST" 
                                                  onsubmit="return confirmPromote(event, '<?php echo e($peli->titulo); ?>')">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-promote">
                                                    <span>🚀 Promover</span>
                                                </button>
                                            </form>
                                            <a href="<?php echo e(route('proximamente.edit', $peli->id)); ?>" class="btn btn-edit">
                                                <span>✏️ Editar</span>
                                            </a>
                                            <form action="<?php echo e(route('proximamente.destroy', $peli->id)); ?>" 
                                                  method="POST" 
                                                  onsubmit="return confirmDelete(event, '<?php echo e($peli->titulo); ?>')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-delete">
                                                    <span>🗑️ Eliminar</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Toggle Acordeón
        function toggleAccordion(header) {
            const content = header.nextElementSibling;
            const isActive = header.classList.contains('active');

            document.querySelectorAll('.accordion-header').forEach(h => {
                if (h !== header) {
                    h.classList.remove('active');
                    h.nextElementSibling.classList.remove('active');
                }
            });

            header.classList.toggle('active');
            content.classList.toggle('active');
        }

        // Función para desplazar las películas con efecto
        function scrollMovies(direction) {
            const container = document.getElementById('moviesContainer');
            const scrollAmount = 340;
            
            const targetScroll = direction === 'left' 
                ? container.scrollLeft - scrollAmount 
                : container.scrollLeft + scrollAmount;
            
            const start = container.scrollLeft;
            const change = targetScroll - start;
            const duration = 500;
            let startTime = null;

            function animateScroll(currentTime) {
                if (!startTime) startTime = currentTime;
                const timeElapsed = currentTime - startTime;
                const progress = Math.min(timeElapsed / duration, 1);
                
                const easing = progress < 0.5 
                    ? 2 * progress * progress 
                    : 1 - Math.pow(-2 * progress + 2, 2) / 2;
                
                container.scrollLeft = start + (change * easing);
                
                if (timeElapsed < duration) {
                    requestAnimationFrame(animateScroll);
                }
            }
            
            requestAnimationFrame(animateScroll);
        }

        // Función para confirmar promoción
        function confirmPromote(event, titulo) {
            event.preventDefault();
            
            if (confirm('¿Estás seguro de que quieres promover "' + titulo + '" a cartelera?\n\nPodrás crear funciones para esta película después de promoverla.')) {
                event.target.submit();
            }
            
            return false;
        }

        // Función para confirmar eliminación con efecto
        function confirmDelete(event, titulo) {
            event.preventDefault();
            
            const card = event.target.closest('.movie-card');
            card.style.filter = 'brightness(0.5)';
            
            if (confirm('¿Estás seguro de que quieres eliminar "' + titulo + '"?')) {
                card.style.transition = 'all 0.5s ease';
                card.style.transform = 'scale(0) rotate(180deg)';
                card.style.opacity = '0';
                
                setTimeout(() => {
                    event.target.submit();
                }, 500);
            } else {
                card.style.filter = 'brightness(1)';
            }
            
            return false;
        }

        // Efecto parallax mejorado
        const container = document.getElementById('moviesContainer');
        if (container) {
            container.addEventListener('scroll', () => {
                const cards = document.querySelectorAll('.movie-card');
                const containerRect = container.getBoundingClientRect();
                const containerCenter = containerRect.left + containerRect.width / 2;

                cards.forEach(card => {
                    const cardRect = card.getBoundingClientRect();
                    const cardCenter = cardRect.left + cardRect.width / 2;
                    const distance = Math.abs(containerCenter - cardCenter);
                    const maxDistance = containerRect.width;
                    const scale = 1 - (distance / maxDistance) * 0.15;
                    const opacity = Math.max(0.5, 1 - (distance / maxDistance) * 0.5);
                    
                    card.style.opacity = opacity;
                    card.style.transform = `scale(${scale})`;
                });
            });
        }

        // Navegación con teclado
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                scrollMovies('left');
            } else if (e.key === 'ArrowRight') {
                scrollMovies('right');
            }
        });

        // Animación de entrada escalonada
        window.addEventListener('load', () => {
            const cards = document.querySelectorAll('.movie-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(50px) scale(0.8)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55)';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0) scale(1)';
                }, index * 150);
            });
        });

        // Efecto de mouse tracking
        document.addEventListener('mousemove', (e) => {
            const cards = document.querySelectorAll('.movie-card');
            
            cards.forEach(card => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                
                const percentX = (x - centerX) / centerX;
                const percentY = (y - centerY) / centerY;
                
                if (card.matches(':hover')) {
                    card.style.transform = `
                        translateY(-15px) 
                        scale(1.08) 
                        rotateY(${percentX * 10}deg) 
                        rotateX(${-percentY * 10}deg)
                    `;
                }
            });
        });
    </script>
</body>
</html><?php /**PATH C:\Users\Dixon\Desktop\cine_laravel\resources\views/proximamente/index.blade.php ENDPATH**/ ?>