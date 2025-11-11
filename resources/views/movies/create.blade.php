<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Película</title>
    <!-- Importación de estilos y scripts de Laravel con Vite -->
    @vite(['resources/css/admin_create.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(20px); padding: 15px 0; border-bottom: 2px solid rgba(255, 255, 255, 0.1); position: sticky; top: 0; z-index: 1000;">
        <div style="max-width: 1400px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; gap: 20px;">
            <a href="{{ route('movies.index') }}" style="display: flex; align-items: center; gap: 10px; font-size: 1.5rem; font-weight: bold; color: #fff; text-decoration: none; transition: all 0.3s ease;">
                🎬 CineVel (Admin)
            </a>
            
            <div style="display: flex; align-items: center; gap: 15px;">
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('user.index') }}" style="padding: 8px 20px; border-radius: 20px; text-decoration: none; background: rgba(255, 255, 255, 0.2); color: #fff; transition: all 0.3s ease;" title="Ver vista de usuario">
                            👤 Vista Usuario
                        </a>
                    @endif
                    
                    <a href="{{ route('dashboard') }}" style="padding: 8px 20px; border-radius: 20px; text-decoration: none; background: rgba(255, 255, 255, 0.2); color: #fff; transition: all 0.3s ease;">
                        📊 Dashboard
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" style="padding: 8px 20px; border-radius: 20px; background: rgba(255, 107, 107, 0.3); color: #fff; border: none; cursor: pointer; transition: all 0.3s ease;">
                            🚪 Cerrar Sesión
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

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
                    <label for="url_trailer">📄Url del trailer</label>
                    <textarea id="descripcion" 
                              name="trailer_url" 
                              placeholder="Coloca una url valida https://www.youtube.com/embed">{{ old('trailer_url') }}</textarea>
                    <div class="helper-text">La url para mostrar al usuario</div>
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
                           max="240"
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
                    <label for="Edad sugerida">Edad Sugerida</label>
                    <input type="text" 
                           id="age_suggest" 
                           name="age_suggest"
                           value="{{ old('age_suggest') }}">
                    <div class="helper-text">Coloca la edad a la que va dirigida la pelicula</div>

                </div>
                           
                           
                    <label for="genero">Género</label>
                    <select id="genero" name="genero" class="form-control">
                        <option value="">Selecciona un género</option>
                        <option value="Acción" {{ old('genero') == 'Acción' ? 'selected' : '' }}>Acción</option>
                        <option value="Aventura" {{ old('genero') == 'Aventura' ? 'selected' : '' }}>Aventura</option>
                        <option value="Comedia" {{ old('genero') == 'Comedia' ? 'selected' : '' }}>Comedia</option>
                        <option value="Drama" {{ old('genero') == 'Drama' ? 'selected' : '' }}>Drama</option>
                        <option value="Terror" {{ old('genero') == 'Terror' ? 'selected' : '' }}>Terror</option>
                        <option value="Ciencia Ficción" {{ old('genero') == 'Ciencia Ficción' ? 'selected' : '' }}>Ciencia Ficción</option>
                        <option value="Romance" {{ old('genero') == 'Romance' ? 'selected' : '' }}>Romance</option>
                        <option value="Animación" {{ old('genero') == 'Animación' ? 'selected' : '' }}>Animación</option>
                        <option value="Documental" {{ old('genero') == 'Documental' ? 'selected' : '' }}>Documental</option>
                    </select>
                    
                    <div class="helper-text">Coloca el genero de la pelicula</div>
                
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