<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $movie->titulo }} - CineVel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            min-height: 100vh;
        }

        /* Top Bar */
        .top-bar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 8px 0;
            text-align: center;
            font-size: 0.85rem;
            color: white;
            font-weight: 500;
        }

        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.98);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
            backdrop-filter: blur(10px);
        }

        .navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 40px;
        }

        .navbar-brand {
            font-size: 2.2rem;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
        }

        .navbar-menu {
            display: flex;
            gap: 30px;
            list-style: none;
            align-items: center;
        }

        .navbar-menu a {
            color: #555;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            padding: 8px 0;
            border-bottom: 2px solid transparent;
        }

        .navbar-menu a:hover,
        .navbar-menu .active {
            color: #667eea;
            border-bottom-color: #667eea;
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 16px;
            background: #f0f2ff;
            border-radius: 25px;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
            font-size: 0.9rem;
        }

        .user-name {
            color: #333;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .btn-auth {
            padding: 10px 24px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-login {
            background: transparent;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .btn-login:hover {
            background: #667eea;
            color: white;
        }

        .btn-logout {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        /* Hero Section con Background */
        .hero-section {
            position: relative;
            height: 500px;
            overflow: hidden;
        }

        .hero-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            filter: blur(8px);
            transform: scale(1.1);
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, 
                rgba(102, 126, 234, 0.4) 0%, 
                rgba(118, 75, 162, 0.6) 50%,
                rgba(102, 126, 234, 0.95) 100%);
        }

        /* Main Content */
        .content-wrapper {
            max-width: 1400px;
            margin: -200px auto 0;
            padding: 0 40px 60px;
            position: relative;
            z-index: 2;
        }

        .movie-content {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 40px;
            align-items: start;
        }

        /* Poster Card */
        .poster-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
            position: sticky;
            top: 100px;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .poster-badge {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff8e53 100%);
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .movie-poster {
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.2);
            margin-bottom: 20px;
        }

        .cta-button {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        /* Info Section */
        .info-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .movie-title-main {
            font-size: 2.8rem;
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 15px;
            line-height: 1.2;
        }

        .movie-subtitle {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 25px;
            font-weight: 500;
        }

        .movie-meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
            padding: 25px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border-radius: 15px;
            border: 2px solid rgba(102, 126, 234, 0.2);
        }

        .meta-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .meta-label {
            font-size: 0.85rem;
            color: #888;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .meta-value {
            font-size: 1.05rem;
            color: #333;
            font-weight: 600;
        }

        .badge-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .badge {
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .badge-age {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .badge-genre {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        /* Synopsis */
        .synopsis-section {
            margin-bottom: 30px;
            padding: 25px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            border-radius: 15px;
            border-left: 4px solid #667eea;
        }

        .section-title {
            font-size: 1.4rem;
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .synopsis-text {
            font-size: 1.05rem;
            line-height: 1.8;
            color: #555;
        }

        /* Trailer */
        .trailer-section {
            margin-bottom: 35px;
        }

        .trailer-toggle {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .trailer-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(102, 126, 234, 0.6);
        }

        .trailer-container {
            margin-top: 20px;
            display: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        }

        .trailer-container.active {
            display: block;
        }

        .trailer-wrapper {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
        }

        .trailer-wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Schedule Section */
        .schedule-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px;
            margin-top: 30px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .schedule-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        /* Calendar Carousel */
        .calendar-carousel {
            position: relative;
            margin-bottom: 40px;
            padding: 25px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
            border-radius: 15px;
            border: 2px solid rgba(102, 126, 234, 0.15);
        }

        .carousel-wrapper {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .carousel-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            flex-shrink: 0;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .carousel-btn:hover:not(:disabled) {
            transform: scale(1.15);
            box-shadow: 0 6px 25px rgba(102, 126, 234, 0.6);
        }

        .carousel-btn:disabled {
            opacity: 0.3;
            cursor: not-allowed;
            transform: none;
        }

        .days-container {
            overflow: hidden;
            flex: 1;
        }

        .days-track {
            display: flex;
            gap: 12px;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .day-item {
            min-width: 110px;
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid rgba(102, 126, 234, 0.2);
            border-radius: 15px;
            padding: 18px 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            flex-shrink: 0;
            color: #333;
        }

        .day-item:hover {
            border-color: #667eea;
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
            background: white;
        }

        .day-item.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            color: white;
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 10px 35px rgba(102, 126, 234, 0.5);
        }

        .day-name {
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            opacity: 0.7;
            margin-bottom: 8px;
        }

        .day-item.active .day-name {
            opacity: 1;
        }

        .day-number {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .day-month {
            font-size: 0.85rem;
            opacity: 0.8;
            text-transform: capitalize;
        }

        /* Cinema Accordion */
        .cinema-accordion {
            border: 2px solid rgba(102, 126, 234, 0.2);
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 20px;
            background: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.1);
        }

        .cinema-header {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .cinema-header:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
        }

        .cinema-header.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-bottom: none;
        }

        .cinema-info h3 {
            font-size: 1.3rem;
            color: #1a1a1a;
            margin-bottom: 5px;
            transition: color 0.3s ease;
        }

        .cinema-header.active .cinema-info h3 {
            color: white;
        }

        .cinema-address {
            font-size: 0.9rem;
            color: #888;
            transition: color 0.3s ease;
        }

        .cinema-header.active .cinema-address {
            color: rgba(255, 255, 255, 0.9);
        }

        .expand-icon {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #667eea;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.2);
        }

        .cinema-header.active .expand-icon {
            transform: rotate(180deg);
            background: white;
            color: #667eea;
        }

        .cinema-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease;
        }

        .cinema-content.active {
            max-height: 1000px;
        }

        .format-tabs {
            display: flex;
            gap: 10px;
            padding: 20px 25px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            border-bottom: 2px solid rgba(102, 126, 234, 0.1);
        }

        .format-tab {
            padding: 10px 20px;
            border-radius: 20px;
            background: white;
            border: 2px solid rgba(102, 126, 234, 0.2);
            color: #667eea;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .format-tab:hover {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .format-tab.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .showtimes-grid {
            padding: 25px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 15px;
        }

        .showtime-btn {
            padding: 20px 15px;
            background: white;
            border: 2px solid #e0e4e8;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        .showtime-btn:hover {
            border-color: #667eea;
            background: #f0f2ff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
        }

        .showtime-time {
            font-size: 1.4rem;
            font-weight: bold;
            color: #1a1a1a;
            display: block;
            margin-bottom: 5px;
        }

        .showtime-room {
            font-size: 0.85rem;
            color: #888;
        }

        .showtime-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
            background: #f8f9fb;
        }

        .showtime-btn:disabled:hover {
            transform: none;
            border-color: #e0e4e8;
            box-shadow: none;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 80px 40px;
            background: #f8f9fb;
            border-radius: 15px;
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.4;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            color: #1a1a1a;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #888;
            font-size: 1rem;
        }

        /* Loading State */
        .loading-state {
            text-align: center;
            padding: 60px;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f0f2ff;
            border-top-color: #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 968px) {
            .movie-content {
                grid-template-columns: 1fr;
            }

            .poster-card {
                position: relative;
                top: 0;
                max-width: 400px;
                margin: 0 auto;
            }

            .navbar-menu {
                display: none;
            }

            .user-name {
                display: none;
            }

            .days-track {
                gap: 8px;
            }

            .day-item {
                min-width: 90px;
                padding: 15px 8px;
            }

            .showtimes-grid {
                grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            }
        }

        @media (max-width: 640px) {
            .navbar-container {
                padding: 15px 20px;
            }

            .content-wrapper {
                padding: 0 20px 40px;
            }

            .info-section,
            .schedule-section {
                padding: 25px 20px;
            }

            .movie-title-main {
                font-size: 2rem;
            }

            .carousel-btn {
                width: 38px;
                height: 38px;
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        ✨ Bienvenido a CineVel - Tu experiencia cinematográfica premium
    </div>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('user.index') }}" class="navbar-brand">CINEVEL</a>
            
            <ul class="navbar-menu">
                <li><a href="{{ route('user.index') }}">Películas</a></li>
                <li><a href="#" class="active">Formatos de salas</a></li>
                <li><a href="#">Servicios corporativos</a></li>
                <li><a href="#">Ofertas y Noticias</a></li>
                <li><a href="#">Alimentos</a></li>
                <li><a href="#">Cine Fans</a></li>
            </ul>

            <div class="navbar-user">
                @guest
                    <a href="{{ route('login') }}" class="btn-auth btn-login">INICIAR SESIÓN</a>
                @else
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('movies.index') }}" class="btn-auth" style="background: rgba(255, 193, 7, 0.2); color: #ffc107; border: 2px solid #ffc107;">
                            🔧 Admin
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
                        <button type="submit" class="btn-auth btn-logout">CERRAR SESIÓN</button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Hero Background -->
    <div class="hero-section">
        <div class="hero-background" style="background-image: url('{{ asset('storage/' . $movie->ruta_imagen) }}');"></div>
        <div class="hero-overlay"></div>
    </div>

    <!-- Main Content -->
    <div class="content-wrapper">
        <div class="movie-content">
            <!-- Left: Poster Card -->
            <div class="poster-card">
                <div class="poster-badge">Cartelera</div>
                <img src="{{ asset('storage/' . $movie->ruta_imagen) }}" 
                     alt="{{ $movie->titulo }}" 
                     class="movie-poster">
                <button class="cta-button" onclick="scrollToSchedule()">
                    🎟️ Comprar Boletos
                </button>
            </div>

            <!-- Right: Info -->
            <div class="info-section">
                <h1 class="movie-title-main">{{ $movie->titulo }}</h1>

                <!-- Meta Grid -->
                <div class="movie-meta-grid">
                    <div class="meta-item">
                        <span class="meta-label">Clasificación</span>
                        <div class="badge-container">
                            <span class="badge badge-age">{{ $movie->age_suggest }}</span>
                        </div>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Duración</span>
                        <span class="meta-value">{{ $movie->duracion }} Minutos</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Género</span>
                        <div class="badge-container">
                            <span class="badge badge-genre">{{ $movie->genero }}</span>
                        </div>
                    </div>
                    @if($movie->año)
                    <div class="meta-item">
                        <span class="meta-label">año de estreno</span>
                        <span class="meta-value">{{ $movie->año }}</span>
                    </div>
                    @endif
                    @if($movie->autor)
                    <div class="meta-item">
                        <span class="meta-label">Director</span>
                        <span class="meta-value">{{ $movie->autor }}</span>
                    </div>
                    @endif
                </div>

                <!-- Synopsis -->
                @if($movie->descripcion)
                <div class="synopsis-section">
                    <h2 class="section-title">📖 Sinopsis</h2>
                    <p class="synopsis-text">{{ $movie->descripcion }}</p>
                </div>
                @endif

                <!-- Trailer -->
                @if($movie->trailer_url)
                <div class="trailer-section">
                    <button class="trailer-toggle" onclick="toggleTrailer()">
                        🎬 Ver el trailer de la película
                    </button>
                    <div class="trailer-container" id="trailerContainer">
                        <div class="trailer-wrapper">
                            <iframe src="{{ $movie->trailer_url }}" 
                                    allowfullscreen
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                            </iframe>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Schedule Section -->
        <div class="schedule-section" id="scheduleSection">
            <div class="schedule-header">
                <h2 class="section-title">🎬 Horarios y Boletos</h2>
            </div>

            @php
                $fechaHoy = \Carbon\Carbon::now()->format('Y-m-d');
                $fechasCalendario = collect();
                for ($i = -1; $i < 14; $i++) {
                    $fechasCalendario->push(\Carbon\Carbon::now()->addDays($i)->format('Y-m-d'));
                }
                $fechasConFunciones = $funciones->pluck('hora')
                    ->map(fn($h) => \Carbon\Carbon::parse($h)->format('Y-m-d'))
                    ->unique()
                    ->values();
            @endphp

            <!-- Calendar Carousel -->
            <div class="calendar-carousel">
                <div class="carousel-wrapper">
                    <button class="carousel-btn" id="prevBtn" onclick="moveCarousel(-1)">◄</button>
                    
                    <div class="days-container">
                        <div class="days-track" id="daysTrack">
                            @foreach($fechasCalendario as $index => $fecha)
                                @php
                                    $carbon = \Carbon\Carbon::parse($fecha);
                                    $esHoy = $fecha === $fechaHoy;
                                @endphp
                                <div class="day-item {{ $esHoy ? 'active' : '' }}" 
                                     data-fecha="{{ $fecha }}"
                                     onclick="selectDay(this)">
                                    <div class="day-name">{{ $carbon->locale('es')->isoFormat('ddd') }}</div>
                                    <div class="day-number">{{ $carbon->format('d') }}</div>
                                    <div class="day-month">{{ $carbon->locale('es')->isoFormat('MMM') }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button class="carousel-btn" id="nextBtn" onclick="moveCarousel(1)">►</button>
                </div>
            </div>

            <!-- Cinema List -->
            <div id="cinemaList">
                @php
                    $funcionesHoy = $funciones->filter(fn($f) => \Carbon\Carbon::parse($f->hora)->format('Y-m-d') === $fechaHoy)
                        ->groupBy('sala.nombre_sala');
                @endphp

                @if($funcionesHoy->count() > 0)
                    @foreach($funcionesHoy as $salaNombre => $funcionesSala)
                        <div class="cinema-accordion">
                            <div class="cinema-header {{ $loop->first ? 'active' : '' }}" onclick="toggleCinema(this)">
                                <div class="cinema-info">
                                    <h3>{{ $salaNombre }}</h3>
                                    <p class="cinema-address">📍 {{ $funcionesSala->first()->sala->ubicacion ?? 'Ubicación Principal' }}</p>
                                </div>
                                <div class="expand-icon">▼</div>
                            </div>
                            <div class="cinema-content {{ $loop->first ? 'active' : '' }}">
                                <div class="format-tabs">
                                    <button class="format-tab active">Todos</button>
                                    <button class="format-tab">2D Doblada</button>
                                </div>
                                <div class="showtimes-grid">
                                    @foreach($funcionesSala as $funcion)
                                    <button class="showtime-btn" 
                                            onclick="reservarFuncion({{ $funcion->id}})"
                                            {{ ($funcion->disponible ?? true) ? '' : 'disabled' }}>
                                        <span class="showtime-time">
                                            {{ \Carbon\Carbon::parse($funcion->hora)->format('H:i') }}
                                        </span>
                                        <span class="showtime-room">Sala {{ $funcion->sala_id }}</span>
                                    </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <div class="empty-icon">🎬</div>
                        <h3>No hay funciones disponibles</h3>
                        <p>Selecciona otro día para ver las funciones disponibles</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        let currentPosition = 0;
        const cardsPerPage = 5;

        // Toggle Trailer
        function toggleTrailer() {
            const container = document.getElementById('trailerContainer');
            container.classList.toggle('active');
        }

        // Scroll to Schedule
        function scrollToSchedule() {
            document.getElementById('scheduleSection').scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        }

        // Carousel Navigation
        function moveCarousel(direction) {
            const track = document.getElementById('daysTrack');
            const items = track.querySelectorAll('.day-item');
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
            document.querySelectorAll('.day-item').forEach(item => {
                item.classList.remove('active');
            });
            dayItem.classList.add('active');

            const fecha = dayItem.dataset.fecha;
            const movieId = window.location.pathname.split('/').pop();
            
            const cinemaList = document.getElementById('cinemaList');
            cinemaList.innerHTML = `
                <div class="loading-state">
                    <div class="spinner"></div>
                    <h3 style="color: #667eea;">Cargando funciones...</h3>
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

        // Toggle Cinema Accordion
        function toggleCinema(header) {
            const content = header.nextElementSibling;
            const isActive = header.classList.contains('active');
            
            // Close all
            document.querySelectorAll('.cinema-header').forEach(h => {
                h.classList.remove('active');
                h.nextElementSibling.classList.remove('active');
            });
            
            // Open clicked if it wasn't active
            if (!isActive) {
                header.classList.add('active');
                content.classList.add('active');
            }
        }

        // Reserve Function
        function reservarFuncion(funcionId) {
                window.location.href = `/reservas/create/${funcionId}`;
        }

        // Initialize
        window.addEventListener('load', () => {
            const items = document.querySelectorAll('.day-item');
            updateCarouselButtons(items.length);

            // Auto-open first cinema
            const firstCinema = document.querySelector('.cinema-header');
            if (firstCinema && !firstCinema.classList.contains('active')) {
                firstCinema.classList.add('active');
                firstCinema.nextElementSibling.classList.add('active');
            }

            // Adjust carousel on resize
            window.addEventListener('resize', () => {
                const track = document.getElementById('daysTrack');
                const items = track.querySelectorAll('.day-item');
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
    </script>
</body>
</html>