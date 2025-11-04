<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Películas</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/admin_index.css', 'resources/js/app.js']); ?>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="<?php echo e(route('movies.index')); ?>" class="navbar-brand">
                🎬 MoviesCatalog
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
                        <div class="movie-card" onclick="selectMovie(this)" data-movie-id="<?php echo e($peli->id); ?>">
                            <div class="shine"></div>
                            <div class="movie-poster-container">
                                <img src="<?php echo e(asset('storage/'.$peli->ruta_imagen)); ?>" 
                                     alt="Imagen de <?php echo e($peli->titulo); ?>" 
                                     class="movie-poster"
                                     onerror="this.src='https://via.placeholder.com/320x400?text=Sin+Imagen'">
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

                                <div class="movie-actions">
                                    <a href="<?php echo e(route('movies.edit', $peli->id)); ?>" class="btn btn-edit">
                                        <span>✏️ Editar</span>
                                    </a>
                                    
                                    <form action="<?php echo e(route('movies.destroy', $peli->id)); ?>" 
                                          method="POST" 
                                          style="flex: 1;"
                                          onsubmit="return confirmDelete(event, '<?php echo e($peli->titulo); ?>')">
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

    <script>
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
            
            // Scroll suave animado
            const start = container.scrollLeft;
            const change = targetScroll - start;
            const duration = 500;
            let startTime = null;

            function animateScroll(currentTime) {
                if (!startTime) startTime = currentTime;
                const timeElapsed = currentTime - startTime;
                const progress = Math.min(timeElapsed / duration, 1);
                
                // Easing function (ease-in-out)
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
            // Añadir efecto de click
            card.classList.add('clicked');
            
            // Crear efecto de ondas
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
                // Animación de salida
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
</html><?php /**PATH C:\backup\cine_laravel\resources\views/movies/index.blade.php ENDPATH**/ ?>