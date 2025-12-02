<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Función</title>
    <!-- Importación de estilos y scripts de Laravel con Vite -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/admin_edit.css', 'resources/js/app.js']); ?>
    <style>
        body {
            display: flex;
            flex-direction: column;
        }

        .main-container {
            display: flex;
            margin-top: 70px;
            min-height: calc(100vh - 70px);
        }

        .sidebar {
            width: 280px;
            background: rgba(22, 33, 62, 0.95);
            padding: 2rem 0;
            border-right: 2px solid #00d4ff;
            overflow-y: auto;
            max-height: calc(100vh - 70px);
            position: fixed;
            left: 0;
            top: 70px;
            height: calc(100vh - 70px);
            z-index: 900;
        }

        .sidebar-title {
            padding: 1rem 1.5rem;
            font-size: 0.9rem;
            color: #00d4ff;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(0, 212, 255, 0.2);
            margin-bottom: 0.5rem;
        }

        .accordion-item {
            border-bottom: 1px solid rgba(0, 212, 255, 0.1);
        }

        .accordion-header {
            padding: 1rem 1.5rem;
            background: none;
            border: none;
            color: #fff;
            cursor: pointer;
            font-size: 0.95rem;
            width: 100%;
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .accordion-header:hover {
            background: rgba(0, 212, 255, 0.1);
            padding-left: 1.8rem;
        }

        .accordion-header.active {
            color: #00d4ff;
            background: rgba(0, 212, 255, 0.15);
        }

        .accordion-icon {
            transition: transform 0.3s ease;
            font-size: 1.1rem;
        }

        .accordion-header.active .accordion-icon {
            transform: rotate(180deg);
        }

        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .accordion-content.active {
            max-height: 500px;
        }

        .accordion-links {
            padding: 0.5rem 0;
        }

        .accordion-link {
            display: block;
            padding: 0.8rem 2rem;
            color: #b0b0b0;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            font-size: 0.9rem;
        }

        .accordion-link:hover {
            color: #00d4ff;
            background: rgba(0, 212, 255, 0.1);
            border-left-color: #00d4ff;
            padding-left: 2.3rem;
        }

        .content-wrapper {
            margin-left: 280px;
            flex: 1;
            width: calc(100% - 280px);
        }

        .navbar {
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(20px); padding: 15px 0; border-bottom: 2px solid rgba(255, 255, 255, 0.1); position: sticky; top: 0; z-index: 1000;">
        <div style="max-width: 1400px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; gap: 20px;">
            <a href="<?php echo e(route('movies.index')); ?>" style="display: flex; align-items: center; gap: 10px; font-size: 1.5rem; font-weight: bold; color: #fff; text-decoration: none; transition: all 0.3s ease;">
                🎬 CineVel (Admin)
            </a>
            <div style="display: flex; align-items: center; gap: 15px;">
                <?php if(auth()->guard()->check()): ?>
                    
                    <a href="<?php echo e(route('dashboard')); ?>" style="padding: 8px 20px; border-radius: 20px; text-decoration: none; background: rgba(255, 255, 255, 0.2); color: #fff; transition: all 0.3s ease;">
                        📊 Dashboard
                    </a>
                    
                    <form method="POST" action="<?php echo e(route('logout')); ?>" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" style="padding: 8px 20px; border-radius: 20px; background: rgba(255, 107, 107, 0.3); color: #fff; border: none; cursor: pointer; transition: all 0.3s ease;">
                            🚪 Cerrar Sesión
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Partículas de fondo -->
    <div class="particles" id="particles"></div>

    <div class="main-container">
        <!-- Sidebar Acordeón -->
        <aside class="sidebar">
            <div class="sidebar-title">Menú Principal</div>

            <?php if(auth()->guard()->check()): ?>
                <!-- Sección Películas -->
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>🎬 Películas</span>
                        <span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="<?php echo e(route('movies.index')); ?>" class="accordion-link">📋 Ver Todas</a>
                            <a href="<?php echo e(route('movies.create')); ?>" class="accordion-link">➕ Agregar Nueva</a>
                        </div>
                    </div>
                </div>

                <!-- Sección Funciones -->
                <div class="accordion-item">
                    <button class="accordion-header active" onclick="toggleAccordion(this)">
                        <span>📅 Funciones</span>
                        <span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content active">
                        <div class="accordion-links">
                            <a href="<?php echo e(route('funciones.index')); ?>" class="accordion-link">📋 Ver Funciones</a>
                            <a href="<?php echo e(route('funciones.create')); ?>" class="accordion-link">➕ Agregar Función</a>
                        </div>
                    </div>
                </div>

                <!-- Sección Confitería -->
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>🍿 Confitería</span>
                        <span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="<?php echo e(route('confiteria.index')); ?>" class="accordion-link">📋 Ver Catálogo</a>
                            <a href="<?php echo e(route('confiteria.create')); ?>" class="accordion-link">➕ Agregar Producto</a>
                        </div>
                    </div>
                </div>

                <!-- Sección Próximamente -->
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>🎥 Próximamente</span>
                        <span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="<?php echo e(route('proximamente.index')); ?>" class="accordion-link">📋 Próximos Estrenos</a>
                            <a href="<?php echo e(route('proximamente.create')); ?>" class="accordion-link">➕ Agregar Película</a>
                        </div>
                    </div>
                </div>

                <!-- Sección Usuarios -->
                <?php if(Auth::user()->role === 'admin'): ?>
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>👥 Usuarios</span>
                        <span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="<?php echo e(route('user.index')); ?>" class="accordion-link">👤 Vista Usuario</a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </aside>

    <div class="content-wrapper">
    <div class="container">
        <div class="form-card">
            <div class="header">
                <h1>📅 Editar Función</h1>
                <p class="subtitle">Modifica los datos de la función de cine</p>
            </div>

        <form action="<?php echo e(route('funciones.update', $func->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

                <div class="form-group">
                    <label for="titulo">Dia y hora</label>
                    <input type="datetime-local" id="hora" name="hora" value="<?php echo e(\Carbon\Carbon::parse($func->hora)->format('Y-m-d\TH:i')); ?>" required>
                </div>
                <div class="form-group">
                    <label for="sala_id" class="required">🎭 Sala</label>
                    <select id="sala_id" 
                            name="sala_id" 
                            required>
                        <option value="">-- Seleccione una sala --</option>
                        <?php $__currentLoopData = $salas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sala): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($sala->id); ?>" <?php echo e($func->sala_id == $sala->id ? 'selected' : ''); ?>>
                                <?php echo e($sala->nombre_sala); ?> 
                                <?php if($sala->capacidad): ?>
                                    - Capacidad: <?php echo e($sala->capacidad); ?> personas
                                <?php endif; ?>
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <div class="helper-text">Selecciona la sala donde se proyectará la película</div>
                    <?php $__errorArgs = ['sala_id'];
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
                
                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <span>💾 Editar funciones</span>
                    </button>
                    <a href="<?php echo e(route('funciones.index')); ?>" class="btn btn-secondary">
                        <span>🔙 Volver a Funciones</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>

    <script>
        // Toggle Acordeón
        function toggleAccordion(header) {
            const content = header.nextElementSibling;
            const isActive = header.classList.contains('active');

            document.querySelectorAll('.accordion-header').forEach(h => {
                if (h !== header) {
                    h.classList.remove('active');
                    h.nextElementSibling.classList.remove('active');
                }
            });

            header.classList.toggle('active');
            content.classList.toggle('active');
        }
        // Crear partículas de fondo
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 25;

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

        // Animación de entrada de campos
        window.addEventListener('load', () => {
            createParticles();
            
            const formGroups = document.querySelectorAll('.form-group');
            formGroups.forEach((group, index) => {
                group.style.opacity = '0';
                group.style.transform = 'translateX(-30px)';
                
                setTimeout(() => {
                    group.style.transition = 'all 0.5s ease';
                    group.style.opacity = '1';
                    group.style.transform = 'translateX(0)';
                }, index * 100);
            });
        });

        // Validación visual en tiempo real
        const selects = document.querySelectorAll('select');
        selects.forEach(select => {
            select.addEventListener('change', function() {
                if (this.value !== '') {
                    this.style.borderColor = '#98fb98';
                } else {
                    this.style.borderColor = 'rgba(255, 255, 255, 0.2)';
                }
            });

            select.addEventListener('blur', function() {
                if (this.value === '' && this.hasAttribute('required')) {
                    this.style.borderColor = '#ff6b6b';
                    this.style.animation = 'shake 0.3s ease';
                }
            });

            select.addEventListener('focus', function() {
                this.style.borderColor = '#87ceeb';
                this.style.animation = 'none';
            });
        });

        const inputs = document.querySelectorAll('input[type="datetime-local"]');
        inputs.forEach(input => {
            input.addEventListener('change', function() {
                if (this.value.trim() !== '') {
                    this.style.borderColor = '#98fb98';
                } else {
                    this.style.borderColor = 'rgba(255, 255, 255, 0.2)';
                }
            });

            input.addEventListener('blur', function() {
                if (this.value.trim() === '' && this.hasAttribute('required')) {
                    this.style.borderColor = '#ff6b6b';
                    this.style.animation = 'shake 0.3s ease';
                }
            });

            input.addEventListener('focus', function() {
                this.style.borderColor = '#87ceeb';
                this.style.animation = 'none';
            });
        });

        // Animación de shake para campos requeridos vacíos
        const style = document.createElement('style');
        style.textContent = `
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-10px); }
                75% { transform: translateX(10px); }
            }
            .error-message {
                color: #ff6b6b;
                font-size: 0.875rem;
                margin-top: 5px;
                padding: 5px 10px;
                background: rgba(255, 107, 107, 0.1);
                border-radius: 5px;
                border-left: 3px solid #ff6b6b;
            }
            select {
                width: 100%;
                padding: 12px;
                border: 2px solid rgba(255, 255, 255, 0.2);
                border-radius: 10px;
                background: rgba(255, 255, 255, 0.1);
                color: #fff;
                font-size: 1rem;
                transition: all 0.3s ease;
                appearance: none;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23fff' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 12px center;
                padding-right: 40px;
            }
            select:focus {
                outline: none;
                border-color: #87ceeb;
                background-color: rgba(255, 255, 255, 0.15);
            }
            select option {
                background: #2a5298;
                color: #fff;
            }
            input[type="datetime-local"] {
                color: #000 !important;
                background: rgba(255, 255, 255, 0.95) !important;
            }
            input[type="datetime-local"]::-webkit-calendar-picker-indicator {
                filter: invert(0);
                cursor: pointer;
            }
            input[type="datetime-local"]::-webkit-datetime-edit-text,
            input[type="datetime-local"]::-webkit-datetime-edit-month-field,
            input[type="datetime-local"]::-webkit-datetime-edit-day-field,
            input[type="datetime-local"]::-webkit-datetime-edit-year-field,
            input[type="datetime-local"]::-webkit-datetime-edit-hour-field,
            input[type="datetime-local"]::-webkit-datetime-edit-minute-field {
                color: #000 !important;
            }
        `;
        document.head.appendChild(style);

    </script>
</body>
</html>

<?php /**PATH C:\Users\Dixon\Desktop\cine_laravel\resources\views/movies/funciones_update.blade.php ENDPATH**/ ?>