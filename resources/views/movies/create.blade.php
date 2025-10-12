<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Película</title>
    @vite(['resources/css/admin_create.css', 'resources/js/app.js'])
    <style>
    </style>
</head>
<body>
    <!-- Partículas de fondo -->
    <div class="particles" id="particles"></div>

    <div class="container">
        <div class="form-card">
            <div class="header">
                <h1>🎬 Crear Nueva Película</h1>
                <p class="subtitle">Añade una película al catálogo</p>
            </div>

            <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="titulo" class="required">📝 Título</label>
                    <input type="text" 
                           id="titulo" 
                           name="titulo" 
                           placeholder="Ej: Inception, Interstellar..." 
                           value="{{ old('titulo') }}" 
                           required>
                    <div class="helper-text">El título de la película es obligatorio</div>
                </div>

                <div class="form-group">
                    <label for="descripcion">📄 Descripción</label>
                    <textarea id="descripcion" 
                              name="descripcion" 
                              placeholder="Escribe una breve sinopsis de la película...">{{ old('descripcion') }}</textarea>
                    <div class="helper-text">Una breve descripción de la trama</div>
                </div>

                <div class="form-group">
                    <label for="duracion">⏱️ Duración (minutos)</label>
                    <input type="number" 
                           id="duracion" 
                           name="duracion" 
                           placeholder="Ej: 148" 
                           min="1" 
                           value="{{ old('duracion') }}">
                    <div class="helper-text">Duración total en minutos</div>
                </div>

                <div class="form-group">
                    <label for="año">📅 Año</label>
                    <input type="number" 
                           id="año" 
                           name="año" 
                           placeholder="Ej: 2024" 
                           min="1888" 
                           max="2100" 
                           value="{{ old('año') }}">
                    <div class="helper-text">Año de estreno de la película</div>
                </div>

                <div class="form-group">
                    <label for="autor">🎬 Director / Autor</label>
                    <input type="text" 
                           id="autor" 
                           name="autor" 
                           placeholder="Ej: Christopher Nolan" 
                           value="{{ old('autor') }}">
                    <div class="helper-text">Nombre del director o autor principal</div>
                </div>

                <div class="form-group">
                    <label for="ruta_imagen">📷 Imagen de la película</label>
                    <input type="file" 
                           id="ruta_imagen" 
                           name="ruta_imagen" 
                           accept="image/*">
                    <div class="helper-text">Selecciona una imagen representativa (JPG, PNG, etc.)</div>
                    <div class="image-preview-area" id="imagePreview">
                        <p>✨ Vista previa de la imagen</p>
                        <img id="previewImg" src="" alt="Preview">
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <span>💾 Crear Película</span>
                    </button>
                    <a href="{{ route('movies.index') }}" class="btn btn-secondary">
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
        document.getElementById('ruta_imagen').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const previewArea = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewImg.src = event.target.result;
                    previewArea.classList.add('active');
                };
                reader.readAsDataURL(file);
            } else {
                previewArea.classList.remove('active');
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

        // Validación visual en tiempo real
        const inputs = document.querySelectorAll('input[type="text"], input[type="number"], textarea');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.trim() !== '') {
                    this.style.borderColor = '#98fb98';
                } else if (this.hasAttribute('required')) {
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
        `;
        document.head.appendChild(style);

        // Confirmación antes de enviar
        document.querySelector('form').addEventListener('submit', function(e) {
            const titulo = document.getElementById('titulo').value.trim();
            if (!titulo) {
                e.preventDefault();
                alert('⚠️ Por favor ingresa un título para la película');
                document.getElementById('titulo').focus();
                return false;
            }
        });
    </script>
</body>
</html>