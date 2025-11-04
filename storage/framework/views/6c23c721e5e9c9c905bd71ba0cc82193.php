<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineVel - Catálogo de Películas</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        ✨ Bienvenido a CineVel - Tu experiencia cinematográfica premium
    </div>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="<?php echo e(route('movies.index')); ?>" class="navbar-brand">
                CINEVEL
            </a>
            
            <ul class="navbar-menu">
                <li><a href="#cartelera" class="active">CARTELERA</a></li>
                <li><a href="#promociones">PROMOCIONES</a></li>
                <li><a href="#proximamente">PRÓXIMAMENTE</a></li>
                <li><a href="#confiteria">CONFITERÍA</a></li>
            </ul>

            <div class="navbar-user">
                <?php if(auth()->guard()->guest()): ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn-auth btn-login">INICIAR SESIÓN</a>
                <?php else: ?>
                    <div class="user-info">
                        <div class="user-avatar">
                            <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

                        </div>
                        <span class="user-name"><?php echo e(Auth::user()->name); ?></span>
                    </div>
                    <form method="POST" action="<?php echo e(route('logout')); ?>" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn-auth btn-logout">
                            CERRAR SESIÓN
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Hero Carousel -->
    <section class="hero-carousel" id="heroCarousel">
        <div class="carousel-slide active">
            <img src="https://images.unsplash.com/photo-1536440136628-849c177e76a1?w=1920&h=1080&fit=crop" alt="Promoción 1">
            <div class="carousel-overlay">
                <div class="carousel-content">
                    <h2>Estrenos de la Semana</h2>
                    <p>No te pierdas las películas más esperadas del año</p>
                    <button class="btn-carousel">Ver Estrenos</button>
                </div>
            </div>
        </div>
        <div class="carousel-slide">
            <img src="https://images.unsplash.com/photo-1485095329183-d0797cdc5676?w=1920&h=1080&fit=crop" alt="Promoción 2">
            <div class="carousel-overlay">
                <div class="carousel-content">
                    <h2>Películas Clásicas</h2>
                    <p>Revive los grandes clásicos del cine</p>
                    <button class="btn-carousel">Ver Clásicos</button>
                </div>
            </div>
        </div>
        <div class="carousel-slide">
            <img src="https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?w=1920&h=1080&fit=crop" alt="Promoción 3">
            <div class="carousel-overlay">
                <div class="carousel-content">
                    <h2>Ofertas Especiales</h2>
                    <p>Descuentos en boletos para funciones matinales</p>
                    <button class="btn-carousel">Ver Ofertas</button>
                </div>
            </div>
        </div>

        <div class="carousel-controls">
            <button class="carousel-btn" onclick="prevSlide()">‹</button>
            <button class="carousel-btn" onclick="nextSlide()">›</button>
        </div>

        <div class="carousel-dots" id="carouselDots"></div>
    </section>

    <!-- Section Header -->
    <div class="section-header">
        <h2>🍿 ESTRENOS EN CARTELERA</h2>
    </div>

    <!-- Movies Grid -->
    <section class="movies-section">
        <div class="movies-grid">
            <?php $__currentLoopData = $movies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="movie-card" onclick="showMovieDetails(<?php echo e($movie->id); ?>)">
                    <div class="movie-badge">ESTRENO</div>
                    <div class="movie-poster-container">
                        <img src="<?php echo e(asset('storage/'.$movie->ruta_imagen)); ?>" 
                             alt="<?php echo e($movie->titulo); ?>" 
                             class="movie-poster"
                             onerror="this.src='https://via.placeholder.com/250x350?text=Sin+Imagen'">
                    </div>
                    
                    <div class="movie-info">
                        <div class="movie-title"><?php echo e($movie->titulo); ?></div>
                        
                        <div class="movie-meta">
                            <?php if($movie->año): ?>
                                <span class="badge badge-year"><?php echo e($movie->año); ?></span>
                            <?php endif; ?>
                            <?php if($movie->duracion): ?>
                                <span class="badge badge-duration"><?php echo e($movie->duracion); ?> min</span>
                            <?php endif; ?>
                        </div>

                        <div class="movie-description">
                            <?php echo e($movie->descripcion ?? 'Sin descripción disponible'); ?>

                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 CineVel. Todos los derechos reservados.</p>
        <p>Tu experiencia cinematográfica premium</p>
    </footer>

    <script>
        // Carousel functionality
        let currentSlide = 0;
        const slides = document.querySelectorAll('.carousel-slide');
        const dotsContainer = document.getElementById('carouselDots');

        // Create dots
        slides.forEach((_, index) => {
            const dot = document.createElement('div');
            dot.className = `dot ${index === 0 ? 'active' : ''}`;
            dot.onclick = () => goToSlide(index);
            dotsContainer.appendChild(dot);
        });

        function showSlide(n) {
            slides.forEach(slide => slide.classList.remove('active'));
            document.querySelectorAll('.dot').forEach(dot => dot.classList.remove('active'));
            
            currentSlide = (n + slides.length) % slides.length;
            
            slides[currentSlide].classList.add('active');
            document.querySelectorAll('.dot')[currentSlide].classList.add('active');
        }

        function nextSlide() {
            showSlide(currentSlide + 1);
        }

        function prevSlide() {
            showSlide(currentSlide - 1);
        }

        function goToSlide(n) {
            showSlide(n);
        }

        // Auto advance
        setInterval(nextSlide, 5000);

        // Movie details
        function showMovieDetails(movieId) {
            console.log('Ver detalles de película:', movieId);
            // Aquí puedes agregar lógica para modal o redirección
        }
    </script>
</body>
</html><?php /**PATH C:\backup\cine_laravel\resources\views/user/index.blade.php ENDPATH**/ ?>