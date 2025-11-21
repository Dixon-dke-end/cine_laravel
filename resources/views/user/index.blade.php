<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineVel - Catálogo de Películas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        ✨ Bienvenido a CineVel - Tu experiencia cinematográfica premium
    </div>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('user.index') }}" class="navbar-brand">
                CINEVEL
            </a>
            
            <ul class="navbar-menu">
                <li><a href="#cartelera" class="active">CARTELERA</a></li>
                <li><a href="#promociones">PROMOCIONES</a></li>
                <li><a href="#proximamente">PRÓXIMAMENTE</a></li>
                <li><a href="#confiteria">CONFITERÍA</a></li>
            </ul>

            <div class="navbar-user">
                @guest
                    <a href="{{ route('login') }}" class="btn-auth btn-login">INICIAR SESIÓN</a>
                @else
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('movies.index') }}" class="btn-auth" style="background: rgba(255, 193, 7, 0.2); color: #ffc107; border: 2px solid rgba(255, 193, 7, 0.5);" title="Ver vista de administrador">
                            🔧 Vista Admin
                        </a>
                    @endif
                    <div class="user-info">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="user-name">{{ Auth::user()->name }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-auth btn-logout">
                            CERRAR SESIÓN
                        </button>
                    </form>
                @endguest
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
            @foreach($movies as $movie)
                <div class="movie-card" >
                    <div class="movie-badge">ESTRENO</div>
                    <div class="movie-poster-container" >
                        <a href="{{ route('funciones.show', $movie->id) }}">
                        <img  src="{{ asset('storage/'.$movie->ruta_imagen) }}" 
                             alt="{{ $movie->titulo }}" 
                             class="movie-poster">
                             </a>
                    </div>
                    
                    <div class="movie-info">
                        <div class="movie-title">{{ $movie->titulo }}</div>
                        
                        <div class="movie-meta">
                            @if($movie->año)
                                <span class="badge badge-year">{{ $movie->año }}</span>
                            @endif
                            @if($movie->duracion)
                                <span class="badge badge-duration">{{ $movie->duracion }} min</span>
                            @endif
                        </div>

                        <div class="movie-description">
                            {{ $movie->descripcion ?? 'Sin descripción disponible' }}
                        </div>
                    </div>
                </div>
            @endforeach
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

        
    </script>
</body>
</html>