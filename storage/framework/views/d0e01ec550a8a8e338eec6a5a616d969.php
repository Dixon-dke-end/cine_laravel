<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($movie->titulo); ?> - Funciones Disponibles</title>
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
            overflow-x: hidden;
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
            padding-bottom: 56.25%;
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

        /* Schedule Section - MEJORADO */
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
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Calendario de Días - CARRUSEL COMPACTO */
        .calendar-container {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            max-width: 650px;
        }

        .calendar-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .carousel-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.3);
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            flex-shrink: 0;
            color: white;
            font-size: 1.2rem;
        }

        .carousel-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: #87ceeb;
            transform: scale(1.1);
        }

        .carousel-btn:disabled {
            opacity: 0.3;
            cursor: not-allowed;
            transform: none;
        }

        .calendar-days-container {
            overflow: hidden;
            flex: 1;
            max-width: 500px;
        }

        .calendar-days {
            display: flex;
            gap: 12px;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .day-card {
            background: rgba(255, 255, 255, 0.08);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 12px 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            min-width: 90px;
            max-width: 90px;
            flex-shrink: 0;
        }

        .day-card:hover:not(.disabled) {
            transform: translateY(-3px);
            border-color: #87ceeb;
            background: rgba(255, 255, 255, 0.15);
        }

        .day-card.active {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            border: 3px solid white;
            box-shadow: 0 6px 20px rgba(30, 60, 114, 0.6);
            transform: translateY(-3px);
        }

        .day-card.disabled {
            opacity: 0.4;
            cursor: not-allowed;
            background: rgba(100, 100, 100, 0.2);
            pointer-events: none;
        }

        .day-name {
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            margin-bottom: 5px;
            color: rgba(255, 255, 255, 0.7);
        }

        .day-card.active .day-name {
            color: white;
            font-weight: bold;
        }

        .day-number {
            font-size: 1.6rem;
            font-weight: bold;
            margin: 5px 0;
            color: white;
        }

        .day-month {
            font-size: 0.8rem;
            opacity: 0.7;
            text-transform: lowercase;
        }

        .day-card.active .day-month {
            opacity: 1;
        }

        /* Cinema Cards - SIMPLIFICADO */
        .cinema-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .cinema-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(5px);
            border-radius: 12px;
            padding: 25px;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .cinema-info {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .cinema-name {
            font-size: 1.4rem;
            font-weight: bold;
            color: #fff;
            margin-bottom: 5px;
        }

        .cinema-address {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.95rem;
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

        .showtime-btn:disabled {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
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
            padding: 80px 40px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            backdrop-filter: blur(10px);
            border: 2px dashed rgba(255, 255, 255, 0.3);
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h3 {
            color: #ffd700;
            margin-bottom: 10px;
            font-size: 1.8rem;
        }

        .empty-state p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.1rem;
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

            .calendar-container {
                max-width: 100%;
            }

            .calendar-days-container {
                max-width: 100%;
            }

            .day-card {
                min-width: 75px;
                max-width: 75px;
                padding: 10px 6px;
            }

            .day-number {
                font-size: 1.4rem;
            }

            .day-name {
                font-size: 0.75rem;
            }

            .day-month {
                font-size: 0.7rem;
            }

            .carousel-btn {
                width: 38px;
                height: 38px;
                font-size: 1rem;
            }

            .calendar-wrapper {
                gap: 8px;
            }

            .showtimes-grid {
                grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="<?php echo e(route('user.index')); ?>" class="navbar-brand">
                CINEVEL
            </a>
            <a href="<?php echo e(route('user.index')); ?>" class="btn-back">
                ← Volver al Catálogo
            </a>
        </div>
    </nav>

    <!-- Movie Header with 2 Columns -->
    <div class="movie-header">
        <!-- Left Column: Poster + Details -->
        <div class="left-column">
            <img src="<?php echo e(asset('storage/' . $movie->ruta_imagen)); ?>" 
                 alt="<?php echo e($movie->titulo); ?>" 
                 class="movie-poster-large"
                 onerror="this.src='https://via.placeholder.com/400x600?text=<?php echo e($movie->titulo); ?>'">
            
            <div class="movie-details">
                <h1 class="movie-title"><?php echo e($movie->titulo); ?></h1>
                
                <div class="movie-badges">
                    <span class="badge badge-age"><?php echo e($movie->age_suggest); ?></span>
                    <span class="badge badge-genre"><?php echo e($movie->genero); ?></span>
                </div>

                <div class="movie-info-item">
                    <span class="movie-info-label">📝 TÍTULO ORIGINAL</span>
                    <span><?php echo e($movie->titulo); ?></span>
                </div>

                <?php if($movie->autor): ?>
                <div class="movie-info-item">
                    <span class="movie-info-label">🎬 DIRECTOR</span>
                    <span><?php echo e($movie->autor); ?></span>
                </div>
                <?php endif; ?>

                <?php if($movie->duracion): ?>
                <div class="movie-info-item">
                    <span class="movie-info-label">⏱️ DURACIÓN</span>
                    <span><?php echo e($movie->duracion); ?> minutos</span>
                </div>
                <?php endif; ?>

                <?php if($movie->año): ?>
                <div class="movie-info-item">
                    <span class="movie-info-label">📅 AÑO</span>
                    <span><?php echo e($movie->año); ?></span>
                </div>
                <?php endif; ?>

                <?php if($movie->descripcion): ?>
                <div class="movie-synopsis">
                    <span class="movie-info-label">📄 SINOPSIS</span>
                    <p><?php echo e($movie->descripcion); ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right Column: Trailer + Schedule -->
        <div class="right-column">
            <!-- Trailer Section -->
            <?php if($movie->trailer_url): ?>
            <div class="trailer-section">
                <h2 class="trailer-title">🎥 Trailer Oficial</h2>
                <div class="trailer-container">
                    <iframe 
                        src="<?php echo e($movie->trailer_url); ?>" 
                        allowfullscreen
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                    </iframe>
                </div>
            </div>
            <?php endif; ?>

            <!-- Schedule Section con Calendario -->
            <div class="schedule-section">
                <h2 class="schedule-title">
                    📅 Selecciona un día para ver las funciones
                </h2>

                <?php
                    // Obtener todas las fechas únicas con funciones
                    $todasLasFechas = $funciones->pluck('hora')
                        ->map(function($hora) {
                            return \Carbon\Carbon::parse($hora)->format('Y-m-d');
                        })
                        ->unique()
                        ->sort()
                        ->values();

                    // Crear un rango de 14 días desde hoy, le reste -1 al for para que no sea desde hoy sino desde el mismo dia porque no estaba tomando en cuenta el dia de hoy :D
                    $fechasCalendario = collect();
                    for ($i = -1; $i < 14; $i++) {
                        $fechasCalendario->push(\Carbon\Carbon::now()->addDays($i)->format('Y-m-d'));
                    }
                ?>

                <!-- Calendario de Días con Carrusel -->
                <div class="calendar-container">
                    <div class="calendar-wrapper">
                        <button class="carousel-btn" id="prevBtn" onclick="moveCarousel(-1)">
                            ◄
                        </button>
                        
                        <div class="calendar-days-container">
                            <div class="calendar-days" id="calendarDays">
                                <?php $__currentLoopData = $fechasCalendario; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $fecha): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $carbon = \Carbon\Carbon::parse($fecha);
                                        $tieneFunciones = $todasLasFechas->contains($fecha);
                                    ?>
                                    
                                    <div class="day-card <?php echo e($index === 0 && $tieneFunciones ? 'active' : ''); ?>" 
                                         data-fecha="<?php echo e($fecha); ?>"
                                         data-tiene-funciones="<?php echo e($tieneFunciones ? 'true' : 'false'); ?>"
                                         onclick="selectDay(this)">
                                        <div class="day-name"><?php echo e($carbon->locale('es')->isoFormat('ddd')); ?></div>
                                        <div class="day-number"><?php echo e($carbon->format('d')); ?></div>
                                        <div class="day-month"><?php echo e($carbon->locale('es')->isoFormat('MMM')); ?></div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <button class="carousel-btn" id="nextBtn" onclick="moveCarousel(1)">
                            ►
                        </button>
                    </div>
                </div>

                <!-- Lista de Cines y Funciones -->
                <div class="cinema-list" id="cinemaList">
                    <?php
                        // Mostrar funciones del primer día por defecto
                        $primeraFecha = $todasLasFechas->first();
                        $funcionesPrimerDia = $funciones->filter(function($funcion) use ($primeraFecha) {
                            return \Carbon\Carbon::parse($funcion->hora)->format('Y-m-d') === $primeraFecha;
                        })->groupBy('sala.nombre_sala');
                    ?>

                    <?php if($funcionesPrimerDia->count() > 0): ?>
                        <?php $__currentLoopData = $funcionesPrimerDia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salaNombre => $funcionesSala): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="cinema-card">
                                <div class="cinema-info">
                                    <div class="cinema-name">🎭 <?php echo e($salaNombre); ?></div>
                                    <div class="cinema-address">📍 Sala Principal</div>
                                </div>

                                <div class="showtimes-grid">
                                    <?php $__currentLoopData = $funcionesSala; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $funcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <button class="showtime-btn" 
                                            href="<?php echo e(route('reservas.show', $funcion->id )); ?>"
                                            <?php echo e(($funcion->disponible ?? true) ? '' : 'disabled'); ?>>
                                        <span class="showtime-time">
                                            <?php echo e(\Carbon\Carbon::parse($funcion->hora)->format('H:i')); ?>

                                        </span>
                                        <span class="showtime-room">Sala <?php echo e($funcion->sala_id); ?></span>
                                    </button>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <div class="empty-state-icon">🎬</div>
                            <h3>No hay funciones disponibles</h3>
                            <p>Selecciona otro día para ver las funciones disponibles</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentPosition = 0;
        const cardsPerPage = 4; // Mostrar solo 4 tarjetas a la vez

        // Mover carrusel
        function moveCarousel(direction) {
            const container = document.getElementById('calendarDays');
            const cards = container.querySelectorAll('.day-card');
            const totalCards = cards.length;
            
            if (cards.length === 0) return;
            
            const cardWidth = cards[0].offsetWidth + 12; // width + gap

            // Calcular nueva posición
            currentPosition += direction;
            
            // Limitar el rango
            const maxPosition = Math.max(0, totalCards - cardsPerPage);
            currentPosition = Math.max(0, Math.min(currentPosition, maxPosition));

            // Aplicar transformación
            container.style.transform = `translateX(-${currentPosition * cardWidth}px)`;

            // Actualizar botones
            updateCarouselButtons(totalCards);
        }

        // Actualizar estado de botones del carrusel
        function updateCarouselButtons(totalCards) {
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            
            prevBtn.disabled = currentPosition === 0;
            nextBtn.disabled = currentPosition >= totalCards - cardsPerPage;
        }

        // Seleccionar día con AJAX
        function selectDay(dayCard) {
            // Actualizar día activo
            document.querySelectorAll('.day-card').forEach(card => {
                card.classList.remove('active');
            });
            dayCard.classList.add('active');

            // Obtener fecha seleccionada
            const fechaSeleccionada = dayCard.dataset.fecha;
            
            // Obtener movie_id de la URL actual
            const urlParts = window.location.pathname.split('/');
            const movieId = urlParts[urlParts.length - 1];
            
            // Mostrar loading
            const cinemaList = document.getElementById('cinemaList');
            cinemaList.innerHTML = `
                <div style="text-align: center; padding: 60px;">
                    <div style="font-size: 3rem; margin-bottom: 20px;">⏳</div>
                    <h3 style="color: #ffd700;">Cargando funciones...</h3>
                </div>
            `;

            // Hacer petición AJAX
            fetch(`/movies/${movieId}/funciones-por-fecha?fecha=${fechaSeleccionada}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.empty) {
                            // Mostrar mensaje vacío
                            cinemaList.innerHTML = `
                                <div class="empty-state">
                                    <div class="empty-state-icon">🎬</div>
                                    <h3>No hay funciones disponibles</h3>
                                    <p>Selecciona otro día para ver las funciones disponibles</p>
                                </div>
                            `;
                        } else {
                            // Mostrar funciones
                            cinemaList.innerHTML = data.html;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    cinemaList.innerHTML = `
                        <div class="empty-state">
                            <div class="empty-state-icon">⚠️</div>
                            <h3>Error al cargar funciones</h3>
                            <p>Por favor, intenta nuevamente</p>
                        </div>
                    `;
                });
        }

        // Reservar función
        function reservarFuncion(funcionId) {
            if (confirm('¿Deseas reservar esta función?')) {
                window.location.href = `/reservas/create/${funcionId}`;
            }
        }

        // Inicialización
        window.addEventListener('load', () => {
            // Auto-seleccionar el primer día con funciones
            const primerDiaConFunciones = document.querySelector('.day-card:not(.disabled)');
            if (primerDiaConFunciones && !primerDiaConFunciones.classList.contains('active')) {
                selectDay(primerDiaConFunciones);
            }

            // Actualizar botones del carrusel
            const cards = document.querySelectorAll('.day-card');
            updateCarouselButtons(cards.length);

            // Ajustar carrusel en resize
            window.addEventListener('resize', () => {
                const container = document.getElementById('calendarDays');
                const cards = container.querySelectorAll('.day-card');
                if (cards.length > 0) {
                    const cardWidth = cards[0].offsetWidth + 12;
                    // Recalcular posición si es necesario
                    const maxPosition = Math.max(0, cards.length - cardsPerPage);
                    if (currentPosition > maxPosition) {
                        currentPosition = maxPosition;
                    }
                    container.style.transform = `translateX(-${currentPosition * cardWidth}px)`;
                    updateCarouselButtons(cards.length);
                }
            });
        });
    </script>
</body>
</html><?php /**PATH C:\Users\Dixon\Desktop\cine_laravel\resources\views/user/user_func.blade.php ENDPATH**/ ?>