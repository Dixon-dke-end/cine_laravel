asd<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Función</title>
    <!-- Importación de estilos y scripts de Laravel con Vite -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/admin_create.css', 'resources/js/app.js']); ?>
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
                    <?php if(Auth::user()->role === 'admin'): ?>
                        <a href="<?php echo e(route('user.index')); ?>" style="padding: 8px 20px; border-radius: 20px; text-decoration: none; background: rgba(255, 255, 255, 0.2); color: #fff; transition: all 0.3s ease;" title="Ver vista de usuario">
                            👤 Vista Usuario
                        </a>
                    <?php endif; ?>
                    
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

    <div class="container">
        <div class="form-card">
            <div class="header">
                <h1>📅 Crear Nueva Función</h1>
                <p class="subtitle">Programa una nueva función de cine</p>
            </div>

            <form action="<?php echo e(route('funciones.update',$registro->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
            </form>
        </div>
    </div>

    <script>
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

        // Confirmación antes de enviar
        document.querySelector('form').addEventListener('submit', function(e) {
            const movieId = document.getElementById('movie_id').value;
            const salaId = document.getElementById('sala_id').value;
            const hora = document.getElementById('hora').value;
            
            if (!movieId || !salaId || !hora) {
                e.preventDefault();
                alert('⚠️ Por favor completa todos los campos requeridos');
                return false;
            }
        });
    </script>
</body>
</html>

<?php /**PATH C:\backup\cine_laravel\resources\views/movies/funciones_update.blade.php ENDPATH**/ ?>