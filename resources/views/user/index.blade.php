<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineVel - Experiencia Premium</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('user.index') }}" class="navbar-brand">
                CineVel
            </a>
            
            <ul class="navbar-menu">
                <li><a href="#cartelera" class="active">CARTELERA</a></li>
                <li><a href="{{route('promociones.user')}}">PROMOCIONES</a></li>
                <li><a href="{{route('confiteria.user')}}">CONFITERÍA</a></li>
            </ul>   

            <div class="navbar-user">
                @guest
                    <a href="{{ route('login') }}" class="btn-auth btn-login">Iniciar Sesión</a>
                @else
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('movies.index') }}" class="btn-auth" style="background: #fff3cd; color: #856404;">
                            Admin
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
                            Salir
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Hero Carousel -->
    <section class="hero-carousel">
        <div class="carousel-slide active">
            <img src="https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?w=1920&h=800&fit=crop" alt="Cinema">
            <div class="carousel-overlay">
                <div class="carousel-content">
                    <h2>Vive la Magia del Cine</h2>
                    <p>Disfruta de los mejores estrenos con la mejor calidad de imagen y sonido.</p>
                    <button class="btn-carousel">Ver Cartelera</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Filter Tabs -->
    <div class="filter-section">
        <div class="filter-tabs">
            <button class="tab-btn active" onclick="switchTab('cartelera')">En Cartelera</button>
            <button class="tab-btn" onclick="switchTab('proximamente')">Próximamente</button>
        </div>
    </div>

    <!-- Cartelera Section -->
    <div id="cartelera-section" class="movies-section">
        <div class="section-title">
            <h3>🎬 Películas en Cartelera</h3>
        </div>
        <div class="movies-grid">
            @foreach($movies as $movie)
                <div class="movie-card" onclick="window.location.href='{{ route('funciones.show', $movie->id) }}'" style="cursor: pointer;">
                    <div class="movie-badge">Estreno</div>
                    <div class="movie-poster-container">
                        <img src="{{ asset('storage/'.$movie->ruta_imagen) }}" alt="{{ $movie->titulo }}" class="movie-poster">
                    </div>
                    <div class="movie-info">
                        <h3 class="movie-title">{{ $movie->titulo }}</h3>
                        <div class="movie-meta">
                            @if($movie->año) <span class="badge badge-year">{{ $movie->año }}</span> @endif
                            @if($movie->duracion) <span class="badge badge-duration">{{ $movie->duracion }} min</span> @endif
                        </div>
                        <p class="movie-description">{{ $movie->descripcion }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Próximamente Section -->
    <div id="proximamente-section" class="movies-section" style="display: none;">
        <div class="section-title">
            <h3>📅 Próximamente en Cines</h3>
        </div>
        <div class="movies-grid">
            @foreach($proximamente as $movie)
                <div class="movie-card">
                    <div class="movie-badge" style="background: #ed8936;">Pronto</div>
                    <div class="movie-poster-container">
                        <img src="{{ asset('storage/'.$movie->ruta_imagen) }}" alt="{{ $movie->titulo }}" class="movie-poster">
                    </div>
                    <div class="movie-info">
                        <h3 class="movie-title">{{ $movie->titulo }}</h3>
                        <div class="movie-meta">
                            @if($movie->año) <span class="badge badge-year">{{ $movie->año }}</span> @endif
                            <span class="badge badge-duration">Próximamente</span>
                        </div>
                        <p class="movie-description">{{ $movie->descripcion }}</p>
                    </div>
                </div>
            @endforeach
            @if($proximamente->isEmpty())
                <div style="grid-column: 1/-1; text-align: center; padding: 3rem; color: var(--text-muted);">
                    <p>No hay películas próximas por el momento.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 CineVel. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        function switchTab(tab) {
            // Update buttons
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');

            // Update sections
            const cartelera = document.getElementById('cartelera-section');
            const proximamente = document.getElementById('proximamente-section');

            if (tab === 'cartelera') {
                cartelera.style.display = 'block';
                proximamente.style.display = 'none';
                // Optional: Add fade animation
                cartelera.style.opacity = 0;
                setTimeout(() => cartelera.style.opacity = 1, 50);
            } else {
                cartelera.style.display = 'none';
                proximamente.style.display = 'block';
                proximamente.style.opacity = 0;
                setTimeout(() => proximamente.style.opacity = 1, 50);
            }
        }
    </script>
</body>
</html>