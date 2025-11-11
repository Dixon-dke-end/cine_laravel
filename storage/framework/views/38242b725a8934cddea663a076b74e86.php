<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Película</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/admin_edit.css', 'resources/js/app.js']); ?>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="<?php echo e(route('movies.index')); ?>" class="navbar-brand">
                🎬 CineVel (Admin)
            </a>
            
            <div class="navbar-user">
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

    <div class="container">
        <div class="form-card">
            <div class="header">
                <h1>✏️ Editar Película</h1>
                <p class="subtitle">Actualiza la información de tu película</p>
            </div>

            <form action="<?php echo e(route('movies.update', $registro->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="form-group">
                    <label for="titulo">📝 Título</label>
                    <input type="text" id="titulo" name="titulo" value="<?php echo e($registro->titulo); ?>" required>
                </div>

                <div class="form-group">
                    <label for="descripcion">📄 Descripción</label>
                    <textarea id="descripcion" name="descripcion"><?php echo e($registro->descripcion); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="duracion">⏱️ Duración (minutos)</label>
                    <input type="number" id="duracion" name="duracion" value="<?php echo e($registro->duracion); ?>">
                </div>
                
                <div class="form-group">
                    <label for="año">📅 Año</label>
                    <input type="number" id="año" name="año" value="<?php echo e($registro->año); ?>">
                </div>

                <div class="form-group">
                    <label for="autor">🎬 Director / Autor</label>
                    <input type="text" id="autor" name="autor" value="<?php echo e($registro->autor); ?>">
                </div>

                <div class="form-group">
                    <label for="age_suggest">⏱ Edad sugerida</label>
                    <input type="text" id="age_suggest" name="age_suggest" value="<?php echo e($registro->age_suggest); ?>">
                </div>

                <div class="form-group">
                    <label for="genero">🎬 Género</label>
                    <select id="genero" name="genero">
                        <option value="">Selecciona un género</option>
                        <option value="Acción" <?php echo e($registro->genero == 'Acción' ? 'selected' : ''); ?>>Acción</option>
                        <option value="Aventura" <?php echo e($registro->genero == 'Aventura' ? 'selected' : ''); ?>>Aventura</option>
                        <option value="Comedia" <?php echo e($registro->genero == 'Comedia' ? 'selected' : ''); ?>>Comedia</option>
                        <option value="Drama" <?php echo e($registro->genero == 'Drama' ? 'selected' : ''); ?>>Drama</option>
                        <option value="Terror" <?php echo e($registro->genero == 'Terror' ? 'selected' : ''); ?>>Terror</option>
                        <option value="Ciencia Ficción" <?php echo e($registro->genero == 'Ciencia Ficción' ? 'selected' : ''); ?>>Ciencia Ficción</option>
                        <option value="Romance" <?php echo e($registro->genero == 'Romance' ? 'selected' : ''); ?>>Romance</option>
                        <option value="Animación" <?php echo e($registro->genero == 'Animación' ? 'selected' : ''); ?>>Animación</option>
                        <option value="Documental" <?php echo e($registro->genero == 'Documental' ? 'selected' : ''); ?>>Documental</option>
                    </select>
                </div>

                <?php if($registro->ruta_imagen): ?>
                <div class="form-group">
                    <label>🖼️ Imagen actual</label>
                    <div class="image-preview">
                        <p>Vista previa de la imagen actual</p>
                        <img src="<?php echo e(asset('storage/' . $registro->ruta_imagen)); ?>" 
                             alt="Imagen de <?php echo e($registro->titulo); ?>">
                    </div>
                </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="imagen">📷 Cambiar imagen</label>
                    <input type="file" name="imagen" id="imagen" accept="image/*">
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <span>💾 Actualizar Película</span>
                    </button>
                    <a href="<?php echo e(route('movies.index')); ?>" class="btn btn-secondary">
                        <span>🔙 Volver al Catálogo</span>
                    </a>
                </div>
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

        // Preview de imagen al seleccionar archivo
        document.getElementById('imagen').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const existingPreview = document.querySelector('.image-preview');
                    if (!existingPreview) {
                        const preview = document.createElement('div');
                        preview.className = 'image-preview';
                        preview.innerHTML = `
                            <p>Vista previa de la nueva imagen</p>
                            <img src="${event.target.result}" alt="Nueva imagen">
                        `;
                        document.getElementById('imagen').parentElement.appendChild(preview);
                    } else {
                        existingPreview.querySelector('img').src = event.target.result;
                        existingPreview.querySelector('p').textContent = 'Vista previa de la nueva imagen';
                    }
                };
                reader.readAsDataURL(file);
            }
        });

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

        // Validación visual
        const inputs = document.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim() !== '') {
                    this.style.borderColor = '#98fb98';
                } else if (this.hasAttribute('required')) {
                    this.style.borderColor = '#ff6b6b';
                }
            });

            input.addEventListener('focus', function() {
                this.style.borderColor = '#87ceeb';
            });
        });
    </script>
</body>
</html><?php /**PATH C:\backup\cine_laravel\resources\views/movies/edit.blade.php ENDPATH**/ ?>