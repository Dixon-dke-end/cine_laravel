<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Películas</title>
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
            padding: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            padding: 15px 0;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            animation: slideDown 0.8s ease;
        }

        .navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.5rem;
            font-weight: bold;
            color: #fff;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
            filter: drop-shadow(0 0 10px rgba(255,255,255,0.5));
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
            background: rgba(255, 255, 255, 0.1);
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .user-info:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
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
            font-size: 1.1rem;
        }

        .user-name {
            font-weight: 600;
            color: #fff;
        }

        .btn-dashboard,
        .btn-logout {
            padding: 8px 20px;
            border-radius: 20px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 0.95rem;
        }

        .btn-dashboard {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-dashboard:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.5);
        }

        .btn-logout {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: #333;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(250, 112, 154, 0.5);
        }

        .content-wrapper {
            padding: 20px;
        }

        /* Partículas de fondo */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 15s infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) translateX(0); }
            25% { transform: translateY(-100px) translateX(50px); }
            50% { transform: translateY(-200px) translateX(-50px); }
            75% { transform: translateY(-100px) translateX(100px); }
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 20px;
            animation: slideDown 0.8s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h1 {
            font-size: 2.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            background: linear-gradient(45deg, #fff, #87ceeb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from { filter: drop-shadow(0 0 5px rgba(255,255,255,0.3)); }
            to { filter: drop-shadow(0 0 20px rgba(255,255,255,0.6)); }
        }

        .btn-add {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
        }

        .btn-add::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .btn-add:hover::before {
            left: 100%;
        }

        .btn-add:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        .movies-wrapper {
            position: relative;
            overflow: hidden;
            padding: 20px 0;
        }

        .movies-container {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 20px 10px;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.3) transparent;
        }

        .movies-container::-webkit-scrollbar {
            height: 8px;
        }

        .movies-container::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
        }

        .movies-container::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 10px;
        }

        .movies-container::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }

        .movie-card {
            min-width: 320px;
            max-width: 320px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            position: relative;
            border: 2px solid transparent;
        }

        .movie-card::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #667eea, #764ba2, #f093fb, #f5576c);
            border-radius: 15px;
            opacity: 0;
            z-index: -1;
            transition: opacity 0.3s;
            animation: borderRotate 3s linear infinite;
        }

        @keyframes borderRotate {
            0% { filter: hue-rotate(0deg); }
            100% { filter: hue-rotate(360deg); }
        }

        .movie-card:hover::before {
            opacity: 1;
        }

        .movie-card:hover {
            transform: translateY(-15px) scale(1.08) rotateY(5deg);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6);
        }

        .movie-card.clicked {
            animation: bounce 0.6s ease;
        }

        @keyframes bounce {
            0%, 100% { transform: scale(1) rotate(0deg); }
            25% { transform: scale(1.1) rotate(-5deg); }
            50% { transform: scale(0.95) rotate(5deg); }
            75% { transform: scale(1.05) rotate(-3deg); }
        }

        .movie-poster-container {
            position: relative;
            overflow: hidden;
        }

        .movie-poster {
            width: 100%;
            height: auto;
            max-height: 400px;
            object-fit: cover;
            display: block;
            transition: transform 0.5s ease;
        }

        .movie-card:hover .movie-poster {
            transform: scale(1.15);
        }

        .movie-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.8) 100%);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .movie-card:hover .movie-overlay {
            opacity: 1;
        }

        .movie-info {
            padding: 15px;
            position: relative;
        }

        .movie-title {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 8px;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .movie-meta {
            display: flex;
            gap: 15px;
            margin-bottom: 10px;
            font-size: 0.85rem;
        }

        .movie-year, .movie-duration {
            padding: 4px 10px;
            border-radius: 12px;
            backdrop-filter: blur(5px);
            animation: slideIn 0.6s ease;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .movie-year {
            background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
            color: #333;
        }

        .movie-duration {
            background: linear-gradient(135deg, #87ceeb 0%, #4facfe 100%);
            color: #fff;
        }

        .movie-author {
            color: #98fb98;
            font-size: 0.85rem;
            margin-bottom: 10px;
            font-style: italic;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }

        .movie-description {
            font-size: 0.9rem;
            line-height: 1.4;
            color: rgba(255,255,255,0.9);
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            margin-bottom: 15px;
            animation: fadeIn 0.7s ease;
        }

        .movie-actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .btn {
            flex: 1;
            padding: 8px 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: bold;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: inline-block;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn span {
            position: relative;
            z-index: 1;
        }

        .btn-edit {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .btn-edit:hover {
            transform: scale(1.1) translateY(-2px);
            box-shadow: 0 8px 20px rgba(245, 87, 108, 0.5);
        }

        .btn-delete {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: #333;
        }

        .btn-delete:hover {
            transform: scale(1.1) translateY(-2px);
            box-shadow: 0 8px 20px rgba(250, 112, 154, 0.5);
        }

        .nav-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 10;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            animation: pulse-button 2s infinite;
        }

        @keyframes pulse-button {
            0%, 100% { box-shadow: 0 0 0 0 rgba(255,255,255,0.4); }
            50% { box-shadow: 0 0 0 10px rgba(255,255,255,0); }
        }

        .nav-button:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transform: translateY(-50%) scale(1.2) rotate(360deg);
        }

        .nav-button.left {
            left: 10px;
        }

        .nav-button.right {
            right: 10px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            backdrop-filter: blur(10px);
            animation: fadeIn 1s ease;
        }

        .empty-state h2 {
            margin-bottom: 20px;
            font-size: 2rem;
            animation: bounce 2s infinite;
        }

        .empty-state p {
            margin-bottom: 20px;
            opacity: 0.5;
        }

        /* Efecto de brillo en hover */
        .shine {
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .movie-card:hover .shine {
            left: 100%;
        }

        @media (max-width: 768px) {
            .movie-card {
                min-width: 240px;
                max-width: 240px;
            }

            .movie-poster {
                max-height: 320px;
            }

            h1 {
                font-size: 2rem;
            }

            .header {
                flex-direction: column;
                text-align: center;
            }

            .navbar-container {
                flex-direction: column;
                gap: 10px;
            }

            .navbar-user {
                flex-wrap: wrap;
                justify-content: center;
            }

            .user-name {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('movies.index') }}" class="navbar-brand">
                🎬 MoviesCatalog
            </a>
            
            <div class="navbar-user">
                <div class="user-info">
                    <div class="user-avatar">
                        @auth
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        @else
                            I
                        @endauth
                    </div>
                    <span class="user-name">
                        @auth
                            {{ Auth::user()->name }}
                        @else
                            Invitado
                        @endauth
                    </span>
                </div>
                
                @guest
                    <a href="{{ route('login') }}" class="btn-dashboard">
                        🔐 Iniciar Sesión
                    </a>
                @endguest
                
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-dashboard">
                        📊 Dashboard
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-logout">
                            🚪 Cerrar Sesión
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Partículas de fondo -->
    <div class="particles" id="particles"></div>

    <div class="content-wrapper">

    <div class="container">
        <div class="header">
            <h1>🎬 Catálogo de Películas</h1>
            <a href="{{ route('movies.create') }}" class="btn-add">
                <span>➕ Agregar Película</span>
            </a>
        </div>
        
        @if($movies->isEmpty())
            <div class="empty-state">
                <h2>📽️ No hay películas registradas</h2>
                <p>Comienza agregando tu primera película al catálogo</p>
                <a href="{{ route('movies.create') }}" class="btn-add">Agregar Primera Película</a>
            </div>
        @else
            <div class="movies-wrapper">
                <button class="nav-button left" onclick="scrollMovies('left')">‹</button>
                <button class="nav-button right" onclick="scrollMovies('right')">›</button>
                
                <div class="movies-container" id="moviesContainer">
                    @foreach($movies as $peli)
                        <div class="movie-card" onclick="selectMovie(this)" data-movie-id="{{ $peli->id }}">
                            <div class="shine"></div>
                            <div class="movie-poster-container">
                                <img src="{{ asset('storage/'.$peli->ruta_imagen) }}" 
                                     alt="Imagen de {{ $peli->titulo }}" 
                                     class="movie-poster"
                                     onerror="this.src='https://via.placeholder.com/320x400?text=Sin+Imagen'">
                                <div class="movie-overlay"></div>
                            </div>
                            
                            <div class="movie-info">
                                <div class="movie-title">{{ $peli->titulo }}</div>
                                
                                <div class="movie-meta">
                                    @if($peli->año)
                                        <span class="movie-year">📅 {{ $peli->año }}</span>
                                    @endif
                                    @if($peli->duracion)
                                        <span class="movie-duration">⏱️ {{ $peli->duracion }} min</span>
                                    @endif
                                </div>

                                @if($peli->autor)
                                    <div class="movie-author">🎬 {{ $peli->autor }}</div>
                                @endif
                                
                                <div class="movie-description">
                                    {{ $peli->descripcion ?? 'Sin descripción disponible' }}
                                </div>

                                <div class="movie-actions">
                                    <a href="{{ route('movies.edit', $peli->id) }}" class="btn btn-edit">
                                        <span>✏️ Editar</span>
                                    </a>
                                    
                                    <form action="{{ route('movies.destroy', $peli->id) }}" 
                                          method="POST" 
                                          style="flex: 1;"
                                          onsubmit="return confirmDelete(event, '{{ $peli->titulo }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete" style="width: 100%;">
                                            <span>🗑️ Eliminar</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
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
</html>