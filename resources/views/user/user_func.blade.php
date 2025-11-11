<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $movie->titulo }} - Funciones Disponibles</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: #fff;
            min-height: 100vh;
        }

        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 15px rgba(0,0,0,0.2);
        }

        .navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
        }

        .navbar-brand {
            font-size: 2.5rem;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
            letter-spacing: -1px;
        }

        .btn-back {
            padding: 10px 25px;
            border-radius: 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }

        /* Movie Header */
        .movie-header {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 30px;
            display: grid;
            grid-template-columns: 400px 1fr;
            gap: 40px;
            align-items: start;
        }

        .left-column {
            position: sticky;
            top: 90px;
        }

        .movie-poster-large {
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border: 3px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 30px;
        }

        .movie-details {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .movie-title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
        }

        .movie-badges {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .badge {
            padding: 10px 20px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .badge-age {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .badge-genre {
            background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
            color: #333;
        }

        .movie-info-item {
            margin-bottom: 15px;
            font-size: 1.1rem;
        }

        .movie-info-label {
            color: #ffd700;
            font-weight: bold;
            margin-right: 10px;
            display: inline-block;
        }

        .movie-synopsis {
            margin-top: 20px;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.9);
            padding-top: 20px;
            border-top: 2px solid rgba(255, 255, 255, 0.2);
        }

        .movie-synopsis p {
            margin-top: 10px;
        }

        .right-column {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        /* Trailer Section */
        .trailer-section {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .trailer-title {
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .trailer-container {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            height: 0;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
        }

        .trailer-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Schedule Section */
        .schedule-section {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .schedule-title {
            font-size: 1.8rem;
            margin-bottom: 25px;
            color: #fff;
            border-bottom: 2px solid rgba(255, 255, 255, 0.3);
            padding-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .cinema-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(5px);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .cinema-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .cinema-header:hover {
            transform: translateX(5px);
        }

        .cinema-name {
            font-size: 1.5rem;
            font-weight: bold;
            color: #fff;
        }

        .cinema-address {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
            margin-top: 5px;
        }

        .expand-icon {
            font-size: 1.5rem;
            transition: transform 0.3s ease;
            color: #ffd700;
        }

        .expand-icon.expanded {
            transform: rotate(180deg);
        }

        .showtimes-container {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .showtimes-container.expanded {
            max-height: 800px;
        }

        .date-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .date-tab {
            padding: 12px 20px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
            color: #fff;
            font-weight: 600;
        }

        .date-tab.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #87ceeb;
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .date-tab:hover {
            border-color: #87ceeb;
            transform: translateY(-2px);
        }

        .showtimes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
            gap: 15px;
        }

        .showtime-btn {
            padding: 18px;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .showtime-btn:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        .showtime-btn.full {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            opacity: 0.6;
            cursor: not-allowed;
        }

        .showtime-time {
            font-size: 1.3rem;
            display: block;
        }

        .showtime-room {
            font-size: 0.85rem;
            opacity: 0.9;
            margin-top: 5px;
        }

        .empty-state {
            text-align: center;
            padding: 60px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            backdrop-filter: blur(10px);
        }

        .empty-state h3 {
            color: #ffd700;
            margin-bottom: 10px;
            font-size: 1.8rem;
        }

        .empty-state p {
            color: rgba(255, 255, 255, 0.8);
        }

        @media (max-width: 768px) {
            .movie-header {
                grid-template-columns: 1fr;
            }

            .left-column {
                position: relative;
                top: 0;
            }

            .movie-title {
                font-size: 2rem;
            }

            .showtimes-grid {
                grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
            }

            .trailer-section,
            .schedule-section {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('user.index') }}" class="navbar-brand">
                CINEVEL
            </a>
            <a href="{{ route('user.index') }}" class="btn-back">
                ← Volver al Catálogo
            </a>
        </div>
    </nav>

    <!-- Movie Header with 2 Columns -->
    <div class="movie-header">
        <!-- Left Column: Poster + Details -->
        <div class="left-column">
            <img src="{{ asset('storage/' . $movie->ruta_imagen) }}" 
                 alt="{{ $movie->titulo }}" 
                 class="movie-poster-large"
                 onerror="this.src='https://via.placeholder.com/400x600?text={{ $movie->titulo }}'">
            
            <div class="movie-details">
                <h1 class="movie-title">{{ $movie->titulo }}</h1>
                
                <div class="movie-badges">
                    <span class="badge badge-age">{{ $movie->age_suggest }}</span>
                    <span class="badge badge-genre">{{ $movie->genero }}</span>
                </div>

                <div class="movie-info-item">
                    <span class="movie-info-label">📝 TÍTULO ORIGINAL</span>
                    <span>{{ $movie->titulo }}</span>
                </div>

                @if($movie->autor)
                <div class="movie-info-item">
                    <span class="movie-info-label">🎬 DIRECTOR</span>
                    <span>{{ $movie->autor }}</span>
                </div>
                @endif

                @if($movie->duracion)
                <div class="movie-info-item">
                    <span class="movie-info-label">⏱️ DURACIÓN</span>
                    <span>{{ $movie->duracion }} minutos</span>
                </div>
                @endif

                @if($movie->año)
                <div class="movie-info-item">
                    <span class="movie-info-label">📅 AÑO</span>
                    <span>{{ $movie->año }}</span>
                </div>
                @endif

                @if($movie->descripcion)
                <div class="movie-synopsis">
                    <span class="movie-info-label">📄 SINOPSIS</span>
                    <p>{{ $movie->descripcion }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Right Column: Trailer + Schedule -->
        <div class="right-column">
            <!-- Trailer Section -->
            @if($movie->trailer_url)
            <div class="trailer-section">
                <h2 class="trailer-title">🎥 Trailer Oficial</h2>
                <div class="trailer-container">
                    <iframe 
                        src="{{ $movie->trailer_url }}" 
                        allowfullscreen
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                    </iframe>
                </div>
            </div>
            @endif

            <!-- Schedule Section -->
            <div class="schedule-section">
                <h2 class="schedule-title">📅 Horarios Disponibles</h2>

                @forelse($funciones->groupBy('sala.nombre') as $salaNombre => $funcionesSala)
                <div class="cinema-card">
                    <div class="cinema-header" onclick="toggleCinema(this)">
                        <div>
                            <div class="cinema-name">🎭 {{ $salaNombre }}</div>
                            <div class="cinema-address">📍 {{ $funcionesSala->first()->sala->ubicacion ?? 'Sala Principal' }}</div>
                        </div>
                        <span class="expand-icon">▼</span>
                    </div>

                    <div class="showtimes-container">
                        <!-- Date Tabs -->
                        <div class="date-tabs">
                            @php
                                $fechasUnicas = $funcionesSala->pluck('hora')->map(function($hora) {
                                    return \Carbon\Carbon::parse($hora)->format('Y-m-d');
                                })->unique()->take(7);
                            @endphp

                            @foreach($fechasUnicas as $index => $fecha)
                            <div class="date-tab {{ $index === 0 ? 'active' : '' }}" 
                                 onclick="filterByDate(this, '{{ $fecha }}', '{{ $salaNombre }}')">
                                <div style="font-weight: bold;">{{ \Carbon\Carbon::parse($fecha)->locale('es')->isoFormat('ddd') }}</div>
                                <div style="font-size: 0.9rem;">{{ \Carbon\Carbon::parse($fecha)->format('d/m') }}</div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Showtimes Grid -->
                        @foreach($fechasUnicas as $fecha)
                        <div class="showtimes-grid" 
                             data-sala="{{ $salaNombre }}" 
                             data-fecha="{{ $fecha }}"
                             style="{{ $fecha === $fechasUnicas->first() ? '' : 'display: none;' }}">
                            
                            @foreach($funcionesSala->filter(function($funcion) use ($fecha) {
                                return \Carbon\Carbon::parse($funcion->hora)->format('Y-m-d') === $fecha;
                            }) as $funcion)
                            <button class="showtime-btn" 
                                    onclick="reservarFuncion({{ $funcion->id }})"
                                    {{ $funcion->disponible ?? true ? '' : 'disabled' }}>
                                <span class="showtime-time">
                                    {{ \Carbon\Carbon::parse($funcion->hora)->format('H:i') }}
                                </span>
                                <span class="showtime-room">Sala {{ $funcion->sala_id }}</span>
                            </button>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <h3>😔 No hay funciones disponibles</h3>
                    <p>Por favor, vuelve más tarde o selecciona otra película</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        // Toggle cinema expansion
        function toggleCinema(header) {
            const container = header.nextElementSibling;
            const icon = header.querySelector('.expand-icon');
            
            container.classList.toggle('expanded');
            icon.classList.toggle('expanded');
        }

        // Filter by date
        function filterByDate(tab, fecha, sala) {
            // Update active tab
            const allTabs = tab.parentElement.querySelectorAll('.date-tab');
            allTabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            // Show/hide showtimes
            const allGrids = document.querySelectorAll(`[data-sala="${sala}"]`);
            allGrids.forEach(grid => {
                if (grid.dataset.fecha === fecha) {
                    grid.style.display = 'grid';
                } else {
                    grid.style.display = 'none';
                }
            });
        }

        // Reservar función
        function reservarFuncion(funcionId) {
            if (confirm('¿Deseas reservar esta función?')) {
                window.location.href = `/reservas/create/${funcionId}`;
            }
        }

        // Auto-expand first cinema
        window.addEventListener('load', () => {
            const firstCinema = document.querySelector('.cinema-header');
            if (firstCinema) {
                toggleCinema(firstCinema);
            }
        });
    </script>
</body>
</html>