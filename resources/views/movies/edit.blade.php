<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Película</title>
    @vite(['resources/css/admin_edit.css', 'resources/js/app.js'])

    <style>
        
    </style>
</head>
<body>
    <!-- Partículas de fondo -->
    <div class="particles" id="particles"></div>

    <div class="container">
        <div class="form-card">
            <div class="header">
                <h1>✏️ Editar Película</h1>
                <p class="subtitle">Actualiza la información de tu película</p>
            </div>

            <form action="{{ route('movies.update', $registro->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="titulo">📝 Título</label>
                    <input type="text" id="titulo" name="titulo" value="{{ $registro->titulo }}" required>
                </div>

                <div class="form-group">
                    <label for="descripcion">📄 Descripción</label>
                    <textarea id="descripcion" name="descripcion">{{ $registro->descripcion }}</textarea>
                </div>

                <div class="form-group">
                    <label for="duracion">⏱️ Duración (minutos)</label>
                    <input type="number" id="duracion" name="duracion" value="{{ $registro->duracion }}">
                </div>

                <div class="form-group">
                    <label for="año">📅 Año</label>
                    <input type="number" id="año" name="año" value="{{ $registro->año }}">
                </div>

                <div class="form-group">
                    <label for="autor">🎬 Director / Autor</label>
                    <input type="text" id="autor" name="autor" value="{{ $registro->autor }}">
                </div>

                @if($registro->ruta_imagen)
                <div class="form-group">
                    <label>🖼️ Imagen actual</label>
                    <div class="image-preview">
                        <p>Vista previa de la imagen actual</p>
                        <img src="{{ asset('storage/' . $registro->ruta_imagen) }}" 
                             alt="Imagen de {{ $registro->titulo }}">
                    </div>
                </div>
                @endif

                <div class="form-group">
                    <label for="imagen">📷 Cambiar imagen</label>
                    <input type="file" name="imagen" id="imagen" accept="image/*">
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <span>💾 Actualizar Película</span>
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
        const inputs = document.querySelectorAll('input, textarea');
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
</html>