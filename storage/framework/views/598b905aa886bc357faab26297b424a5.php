<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funciones de Cine</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/admin_index.css', 'resources/js/app.js']); ?>
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
                    <?php if(Auth::user()->role === 'admin'): ?>
                        <a href="<?php echo e(route('user.index')); ?>" class="btn-dashboard" title="Ver vista de usuario">
                            👤 Vista Usuario
                        </a>
                    <?php endif; ?>
                    
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
                <h1>📅 Funciones de Cine</h1>
                <div style="display: flex; gap: 10px;">
                    <a href="<?php echo e(route('funciones.create')); ?>" class="btn-add">
                        <span>➕ Agregar Función</span>
                    </a>
                    <a href="<?php echo e(route('movies.index')); ?>" class="btn-add">
                        <span>🔙 Volver a Películas</span>
                    </a>
                </div>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success" style="background: rgba(152, 251, 152, 0.2); border: 2px solid #98fb98; color: #98fb98; padding: 15px; border-radius: 10px; margin: 20px 0; text-align: center;">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>
            
            <?php
                $peliculasConFunciones = $peliculas->filter(function($pelicula) {
                    return $pelicula->funciones->isNotEmpty();
                });
            ?>

            <?php if($peliculasConFunciones->isEmpty()): ?>
                <div class="empty-state">
                    <h2>📽️ No hay funciones registradas</h2>
                    <p>No se han programado funciones aún</p>
                    <a href="<?php echo e(route('funciones.create')); ?>" class="btn-add">Crear Primera Función</a>
                </div>
            <?php else: ?>
                <div class="peliculas-funciones-container">
                    <?php $__currentLoopData = $peliculasConFunciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pelicula): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="pelicula-section">
                            <div class="pelicula-header">
                                <div class="pelicula-info-header">
                                    <?php if($pelicula->ruta_imagen): ?>
                                        <img src="<?php echo e(asset('storage/'.$pelicula->ruta_imagen)); ?>" 
                                             alt="<?php echo e($pelicula->titulo); ?>" 
                                             class="pelicula-thumbnail"
                                             onerror="this.src='https://via.placeholder.com/100x150?text=Sin+Imagen'">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/100x150?text=Sin+Imagen" 
                                             alt="Sin imagen" 
                                             class="pelicula-thumbnail">
                                    <?php endif; ?>
                                    <div class="pelicula-title-info">
                                        <h2 class="pelicula-title"><?php echo e($pelicula->titulo); ?></h2>
                                        <?php if($pelicula->año): ?>
                                            <span class="pelicula-year">📅 <?php echo e($pelicula->año); ?></span>
                                        <?php endif; ?>
                                        <?php if($pelicula->duracion): ?>
                                            <span class="pelicula-duration">⏱️ <?php echo e($pelicula->duracion); ?> min</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="funciones-count">
                                    <?php echo e($pelicula->funciones->count()); ?> función(es)
                                </div>
                            </div>
                            
                            <div class="funciones-grid">
                                <?php $__currentLoopData = $pelicula->funciones->sortBy('hora'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $funcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="funcion-card">
                                        <div class="funcion-time">
                                            🕐 <?php echo e(\Carbon\Carbon::parse($funcion->hora)->format('d/m/Y H:i')); ?>

                                        </div>
                                        <div class="funcion-sala">
                                            🎭 <?php echo e($funcion->salas->nombre_sala ?? 'Sala no disponible'); ?>

                                            <?php if($funcion->salas && $funcion->salas->capacidad): ?>
                                                <span class="funcion-capacidad">(<?php echo e($funcion->salas->capacidad); ?> personas)</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="funcion-actions">
                                            <a href="<?php echo e(route('funciones.edit', $funcion->id)); ?>" class="btn-funcion btn-edit-funcion">
                                                ✏️ Editar
                                            </a>
                                            <form action="<?php echo e(route('funciones.destroy', $funcion->id)); ?>" 
                                                  method="POST" 
                                                  style="display: inline;"
                                                  onsubmit="return confirmDelete(event, 'Función del <?php echo e(\Carbon\Carbon::parse($funcion->hora)->format('d/m/Y H:i')); ?>')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn-funcion btn-delete-funcion">
                                                    🗑️ Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <style>
        .peliculas-funciones-container {
            display: flex;
            flex-direction: column;
            gap: 40px;
            padding: 20px 0;
        }

        .pelicula-section {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 25px;
            border: 2px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .pelicula-section:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .pelicula-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        }

        .pelicula-info-header {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .pelicula-thumbnail {
            width: 100px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .pelicula-title-info {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .pelicula-title {
            font-size: 1.8rem;
            margin: 0;
            color: #fff;
        }

        .pelicula-year,
        .pelicula-duration {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
            margin-right: 15px;
        }

        .funciones-count {
            background: rgba(135, 206, 235, 0.2);
            padding: 10px 20px;
            border-radius: 20px;
            font-weight: bold;
            color: #87ceeb;
        }

        .funciones-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .funcion-card {
            background: rgba(255, 255, 255, 0.08);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .funcion-card:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(135, 206, 235, 0.5);
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }

        .funcion-time {
            font-size: 1.2rem;
            font-weight: bold;
            color: #87ceeb;
            margin-bottom: 10px;
        }

        .funcion-sala {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 15px;
        }

        .funcion-capacidad {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.6);
        }

        .funcion-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-funcion {
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            flex: 1;
            text-align: center;
        }

        .btn-edit-funcion {
            background: rgba(152, 251, 152, 0.2);
            color: #98fb98;
            border: 2px solid rgba(152, 251, 152, 0.3);
        }

        .btn-edit-funcion:hover {
            background: rgba(152, 251, 152, 0.3);
            border-color: #98fb98;
            transform: scale(1.05);
        }

        .btn-delete-funcion {
            background: rgba(255, 107, 107, 0.2);
            color: #ff6b6b;
            border: 2px solid rgba(255, 107, 107, 0.3);
        }

        .btn-delete-funcion:hover {
            background: rgba(255, 107, 107, 0.3);
            border-color: #ff6b6b;
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .pelicula-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .funciones-grid {
                grid-template-columns: 1fr;
            }

            .pelicula-info-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .funcion-actions {
                flex-direction: column;
            }
        }
    </style>

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

        // Función para confirmar eliminación con efecto
        function confirmDelete(event, descripcion) {
            event.preventDefault();
            
            const card = event.target.closest('.funcion-card');
            if (card) {
                card.style.filter = 'brightness(0.5)';
            }
            
            if (confirm('¿Estás seguro de que quieres eliminar "' + descripcion + '"?')) {
                // Animación de salida
                if (card) {
                    card.style.transition = 'all 0.5s ease';
                    card.style.transform = 'scale(0) rotate(180deg)';
                    card.style.opacity = '0';
                    
                    setTimeout(() => {
                        event.target.closest('form').submit();
                    }, 500);
                } else {
                    event.target.closest('form').submit();
                }
            } else {
                if (card) {
                    card.style.filter = 'brightness(1)';
                }
            }
            
            return false;
        }

        // Animación de entrada escalonada
        window.addEventListener('load', () => {
            createParticles();
            
            const sections = document.querySelectorAll('.pelicula-section');
            sections.forEach((section, index) => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(30px)';
                
                setTimeout(() => {
                    section.style.transition = 'all 0.6s ease';
                    section.style.opacity = '1';
                    section.style.transform = 'translateY(0)';
                }, index * 200);
            });

            const funcionCards = document.querySelectorAll('.funcion-card');
            funcionCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'scale(0.9)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.4s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'scale(1)';
                }, 300 + (index * 100));
            });
        });
    </script>
</body>
</html>

<?php /**PATH C:\backup\cine_laravel\resources\views/movies/funciones.blade.php ENDPATH**/ ?>