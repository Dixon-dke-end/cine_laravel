<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($pelicula->titulo); ?> - CineVel</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        body {
            background: #0a0e27;
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .movie-detail-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .movie-header {
            display: flex;
            gap: 40px;
            margin-bottom: 40px;
            background: rgba(255, 255, 255, 0.05);
            padding: 30px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }
        .movie-poster-large {
            width: 300px;
            height: 450px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }
        .movie-info-large {
            flex: 1;
        }
        .movie-title-large {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #fff;
        }
        .movie-meta-large {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .meta-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
        }
        .movie-description-large {
            font-size: 1.1rem;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 20px;
        }
        .funciones-section {
            margin-top: 40px;
        }
        .section-title {
            font-size: 2rem;
            margin-bottom: 30px;
            text-align: center;
        }
        .funciones-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        .funcion-card {
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 25px;
            transition: all 0.3s ease;
        }
        .funcion-card:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 193, 7, 0.5);
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        .funcion-time {
            font-size: 1.3rem;
            font-weight: bold;
            color: #ffc107;
            margin-bottom: 10px;
        }
        .funcion-sala-info {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 15px;
        }
        .funcion-capacidad-info {
            background: rgba(76, 175, 80, 0.2);
            color: #4caf50;
            padding: 8px 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            display: inline-block;
        }
        .reserva-form {
            margin-top: 15px;
        }
        .form-group-reserva {
            margin-bottom: 15px;
        }
        .form-group-reserva label {
            display: block;
            margin-bottom: 5px;
            color: rgba(255, 255, 255, 0.9);
        }
        .form-group-reserva input {
            width: 100%;
            padding: 10px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            font-size: 1rem;
        }
        .form-group-reserva input:focus {
            outline: none;
            border-color: #ffc107;
            background: rgba(255, 255, 255, 0.15);
        }
        .btn-reservar {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            color: #000;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-reservar:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(255, 193, 7, 0.4);
        }
        .btn-reservar:disabled {
            background: rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.5);
            cursor: not-allowed;
        }
        .no-funciones {
            text-align: center;
            padding: 40px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            color: rgba(255, 255, 255, 0.6);
        }
        .btn-volver {
            display: inline-block;
            padding: 12px 24px;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        .btn-volver:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(-5px);
        }
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: rgba(76, 175, 80, 0.2);
            border: 2px solid #4caf50;
            color: #4caf50;
        }
        .alert-error {
            background: rgba(244, 67, 54, 0.2);
            border: 2px solid #f44336;
            color: #f44336;
        }
        .error-message {
            color: #f44336;
            font-size: 0.9rem;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <!-- Navbar (mismo que user/index) -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="<?php echo e(route('user.index')); ?>" class="navbar-brand">
                CINEVEL
            </a>
            
            <ul class="navbar-menu">
                <li><a href="<?php echo e(route('user.index')); ?>" class="active">CARTELERA</a></li>
                <li><a href="#promociones">PROMOCIONES</a></li>
                <li><a href="#proximamente">PRÓXIMAMENTE</a></li>
                <li><a href="#confiteria">CONFITERÍA</a></li>
            </ul>

            <div class="navbar-user">
                <?php if(auth()->guard()->guest()): ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn-auth btn-login">INICIAR SESIÓN</a>
                <?php else: ?>
                    <?php if(Auth::user()->role === 'admin'): ?>
                        <a href="<?php echo e(route('movies.index')); ?>" class="btn-auth" style="background: rgba(255, 193, 7, 0.2); color: #ffc107; border: 2px solid rgba(255, 193, 7, 0.5);" title="Ver vista de administrador">
                            🔧 Vista Admin
                        </a>
                    <?php endif; ?>
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

    <div class="movie-detail-container">
        <!-- Botón volver -->
        <a href="<?php echo e(route('user.index')); ?>" class="btn-volver">← Volver al Catálogo</a>

        <!-- Mensajes de éxito/error -->
        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Información de la película -->
        <div class="movie-header">
            <div class="movie-poster">
                <?php if($pelicula->ruta_imagen): ?>
                    <img src="<?php echo e(asset('storage/'.$pelicula->ruta_imagen)); ?>" 
                         alt="<?php echo e($pelicula->titulo); ?>" 
                         class="movie-poster-large"
                         onerror="this.src='https://via.placeholder.com/300x450?text=Sin+Imagen'">
                <?php else: ?>
                    <img src="https://via.placeholder.com/300x450?text=Sin+Imagen" 
                         alt="Sin imagen" 
                         class="movie-poster-large">
                <?php endif; ?>
            </div>
            
            <div class="movie-info-large">
                <h1 class="movie-title-large"><?php echo e($pelicula->titulo); ?></h1>
                
                <div class="movie-meta-large">
                    <?php if($pelicula->año): ?>
                        <span class="meta-item">📅 <?php echo e($pelicula->año); ?></span>
                    <?php endif; ?>
                    <?php if($pelicula->duracion): ?>
                        <span class="meta-item">⏱️ <?php echo e($pelicula->duracion); ?> min</span>
                    <?php endif; ?>
                    <?php if($pelicula->autor): ?>
                        <span class="meta-item">🎬 <?php echo e($pelicula->autor); ?></span>
                    <?php endif; ?>
                </div>

                <div class="movie-description-large">
                    <?php echo e($pelicula->descripcion ?? 'Sin descripción disponible'); ?>

                </div>
            </div>
        </div>

        <!-- Funciones disponibles -->
        <div class="funciones-section">
            <h2 class="section-title">🎫 Funciones Disponibles</h2>
            
            <?php if($funciones->isEmpty()): ?>
                <div class="no-funciones">
                    <p>No hay funciones disponibles para esta película en este momento.</p>
                </div>
            <?php else: ?>
                <div class="funciones-grid">
                    <?php $__currentLoopData = $funciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $funcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            // Calcular asientos disponibles
                            $asientosOcupados = $funcion->reservas()->sum('cantidad_asientos');
                            $capacidad = $funcion->salas->capacidad ?? 0;
                            $asientosDisponibles = max(0, $capacidad - $asientosOcupados);
                        ?>

                        <div class="funcion-card">
                            <div class="funcion-time">
                                🕐 <?php echo e(\Carbon\Carbon::parse($funcion->hora)->format('d/m/Y H:i')); ?>

                            </div>
                            
                            <div class="funcion-sala-info">
                                🎭 Sala: <?php echo e($funcion->salas->nombre_sala ?? 'No disponible'); ?>

                            </div>
                            
                            <div class="funcion-capacidad-info">
                                💺 <?php echo e($asientosDisponibles); ?> asientos disponibles
                            </div>

                            <?php if(auth()->guard()->check()): ?>
                                <?php if($asientosDisponibles > 0): ?>
                                    <form action="<?php echo e(route('reservas.store')); ?>" method="POST" class="reserva-form">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="funcion_id" value="<?php echo e($funcion->id); ?>">
                                        
                                        <div class="form-group-reserva">
                                            <label for="cantidad_asientos_<?php echo e($funcion->id); ?>">Cantidad de asientos:</label>
                                            <input type="number" 
                                                   id="cantidad_asientos_<?php echo e($funcion->id); ?>" 
                                                   name="cantidad_asientos" 
                                                   min="1" 
                                                   max="<?php echo e(min($asientosDisponibles, 10)); ?>"
                                                   value="<?php echo e(old('cantidad_asientos', 1)); ?>"
                                                   required>
                                            <?php $__errorArgs = ['cantidad_asientos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="error-message"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        
                                        <button type="submit" class="btn-reservar">
                                            🎫 Reservar
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <button class="btn-reservar" disabled>
                                        ❌ Agotado
                                    </button>
                                <?php endif; ?>
                            <?php else: ?>
                                <a href="<?php echo e(route('login')); ?>" class="btn-reservar" style="text-decoration: none; display: block; text-align: center;">
                                    🔐 Inicia sesión para reservar
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>


<?php /**PATH C:\backup\cine_laravel\resources\views/movies/show.blade.php ENDPATH**/ ?>