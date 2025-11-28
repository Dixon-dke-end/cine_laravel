<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Películas</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/admin_index.css', 'resources/js/app.js']); ?>
    <style>
        body {
            display: flex;
            flex-direction: column;
        }

        .main-container {
            display: flex;
            margin-top: 70px;
            min-height: calc(100vh - 70px);
        }

        .sidebar {
            width: 280px;
            background: rgba(22, 33, 62, 0.95);
            padding: 2rem 0;
            border-right: 2px solid #00d4ff;
            overflow-y: auto;
            max-height: calc(100vh - 70px);
            position: fixed;
            left: 0;
            top: 70px;
            height: calc(100vh - 70px);
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

        .content-wrapper {
            margin-left: 280px;
            flex: 1;
            width: calc(100% - 280px);
        }

        .navbar {
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 250px;
            }

            .content-wrapper {
                margin-left: 250px;
                width: calc(100% - 250px);
            }
        }

        @media (max-width: 600px) {
            .sidebar {
                display: none;
            }

            .content-wrapper {
                margin-left: 0;
                width: 100%;
            }

            .main-container {
                margin-top: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
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
                    <span class="user-name">
                        <?php if(auth()->guard()->check()): ?>
                            <?php echo e(Auth::user()->name); ?>

                        <?php else: ?>
                            Invitado
                        <?php endif; ?>
                    </span>
                </div>
                
                <?php if(auth()->guard()->guest()): ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn-dashboard">
                        🔐 Iniciar Sesión
                    </a>
                <?php endif; ?>
                
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('dashboard')); ?>" class="btn-dashboard">
                        📊 Dashboard
                    </a>
                    <form method="POST" action="<?php echo e(route('logout')); ?>" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn-logout">
                            🚪 Cerrar Sesión
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Partículas de fondo -->
    <div class="particles" id="particles"></div>

    <div class="main-container">
        <!-- Sidebar Acordeón -->
        <aside class="sidebar">
            <div class="sidebar-title">Menú Principal</div>

            <?php if(auth()->guard()->check()): ?>
                <!-- Sección Películas -->
                <div class="accordion-item">
                    <button class="accordion-header active" onclick="toggleAccordion(this)">
                        <span>🎬 Películas</span>
                        <span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content active">
                        <div class="accordion-links">
                            <a href="<?php echo e(route('movies.index')); ?>" class="accordion-link">📋 Ver Todas</a>
                            <a href="<?php echo e(route('movies.create')); ?>" class="accordion-link">➕ Agregar Nueva</a>
                        </div>
                    </div>
                </div>

                <!-- Sección Funciones -->
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>📅 Funciones</span>
                        <span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="<?php echo e(route('funciones.index')); ?>" class="accordion-link">📋 Ver Funciones</a>
                            <a href="<?php echo e(route('funciones.create')); ?>" class="accordion-link">➕ Agregar Función</a>
                        </div>
                    </div>
                </div>
               <!-- Sección confiteria -->
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>Confiteria</span>
                        <span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="<?php echo e(route('confiteria.index')); ?>" class="accordion-link">📋 Ver Confiteria</a>
                            <a href="<?php echo e(route('confiteria.create')); ?>" class="accordion-link">➕ Agregar Confiteria</a>
                        </div>
                    </div>
                </div>
                <!-- Sección Promociones -->
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>🏷️ Promociones</span>
                        <span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="<?php echo e(route('promociones.index')); ?>" class="accordion-link">📋 Ver Promociones</a>
                            <a href="<?php echo e(route('promociones.create')); ?>" class="accordion-link">➕ Agregar Promoción</a>
                        </div>
                    </div>
                </div>
                <!-- Sección Próximamente -->
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>🎥 Próximamente</span>
                        <span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="<?php echo e(route('proximamente.admin')); ?>" class="accordion-link">📋 Próximos Estrenos</a>
                            <a href="<?php echo e(route('proximamente.create')); ?>" class="accordion-link">➕ Agregar Película</a>
                        </div>
                    </div>
                </div>

                <!-- Sección Usuarios -->
                <?php if(Auth::user()->role === 'admin'): ?>
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>👥 Usuarios</span>
                        <span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="<?php echo e(route('user.index')); ?>" class="accordion-link">👤 Vista Usuario</a>
                            <a href="<?php echo e(route('user.index')); ?>" class="accordion-link">👨‍💼 Gestionar</a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </aside>

        <div class="content-wrapper">
            <div class="container">
                <div class="header">
                    <h1>🎬 Catálogo de Películas</h1>
                    <a href="<?php echo e(route('movies.create')); ?>" class="btn-add">
                        <span>➕ Agregar Película</span>
                    </a>
                </div>
                
                <?php if($movies->isEmpty()): ?>
                    <div class="empty-state">
                        <h2>📽️ No hay películas registradas</h2>
                        <p>Comienza agregando tu primera película al catálogo</p>
                        <a href="<?php echo e(route('movies.create')); ?>" class="btn-add">Agregar Primera Película</a>
                    </div>
                <?php else: ?>
                    <div class="movies-wrapper">
                        <button class="nav-button left" onclick="scrollMovies('left')">‹</button>
                        <button class="nav-button right" onclick="scrollMovies('right')">›</button>
                        
                        <div class="movies-container" id="moviesContainer">
                            <?php $__currentLoopData = $movies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $peli): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="movie-card" style="position: relative;">
                                    <a href="<?php echo e(route('movies.show', $peli->id)); ?>" style="position: absolute; top: 0; left: 0; width: 100%; height: calc(100% - 80px); z-index: 1; cursor: pointer;" title="Ver detalles y reservar"></a>
                                    <div class="shine"></div>
                                    <div class="movie-poster-container">
                                        <img src="<?php echo e(asset('storage/'.$peli->ruta_imagen)); ?>" 
                                             alt="Imagen de <?php echo e($peli->titulo); ?>" 
                                             class="movie-poster">
                                        <div class="movie-overlay"></div>
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

                                        <div class="movie-actions" style="position: relative; z-index: 2;">
                                            <a href="<?php echo e(route('movies.show', $peli->id)); ?>" class="btn btn-edit" onclick="event.stopPropagation();" style="flex: 1;">
                                                <span>🎫Reservaciones</span>
                                            </a>
                                            <a href="<?php echo e(route('movies.edit', $peli->id)); ?>" class="btn btn-edit" onclick="event.stopPropagation();">
                                                <span>✏️ Editar</span>
                                            </a>
                                            <form action="<?php echo e(route('movies.destroy', $peli->id)); ?>" 
                                                  method="POST" 
                                                  style="flex: 1;"
                                                  onsubmit="return confirmDelete(event, '<?php echo e($peli->titulo); ?>')"
                                                  onclick="event.stopPropagation();">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-delete" style="width: 100%;">
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

        // Crear partículas de fondo
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 20;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                const size = Math.random() * 60 + 20;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 15 + 's';
                particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
                
                particlesContainer.appendChild(particle);
            }
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

        // Función para seleccionar una película con efectos
        function selectMovie(card) {
            card.classList.add('clicked');
            
            const ripple = document.createElement('div');
            ripple.style.position = 'absolute';
            ripple.style.borderRadius = '50%';
            ripple.style.background = 'rgba(255,255,255,0.5)';
            ripple.style.width = '20px';
            ripple.style.height = '20px';
            ripple.style.animation = 'ripple 1s ease-out';
            ripple.style.top = '50%';
            ripple.style.left = '50%';
            ripple.style.transform = 'translate(-50%, -50%)';
            ripple.style.pointerEvents = 'none';
            
            card.style.position = 'relative';
            card.appendChild(ripple);
            
            setTimeout(() => {
                card.classList.remove('clicked');
                ripple.remove();
            }, 600);
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
            createParticles();
            
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

        // Agregar animación de ripple al CSS dinámicamente
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    width: 500px;
                    height: 500px;
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html><?php /**PATH C:\Users\Dixon\Desktop\cine_laravel\resources\views/movies/index.blade.php ENDPATH**/ ?>