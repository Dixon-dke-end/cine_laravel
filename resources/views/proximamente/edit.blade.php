<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Próximamente</title>
    @vite(['resources/css/admin_edit.css', 'resources/js/app.js'])
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
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('movies.index') }}" class="navbar-brand">
                🎬 CineVel (Admin)
            </a>
            
            <div class="navbar-user">
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

    <div class="main-container">
        <!-- Sidebar Acordeón -->
        <aside class="sidebar">
            <div class="sidebar-title">Menú Principal</div>

            @auth
                <!-- Sección Películas -->
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>🎬 Películas</span>
                        <span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="{{ route('movies.index') }}" class="accordion-link">📋 Ver Todas</a>
                            <a href="{{ route('movies.create') }}" class="accordion-link">➕ Agregar Nueva</a>
                        </div>
                    </div>
                </div>

                <!-- Sección Funciones -->
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>📅 Funciones</span>
                        <span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="{{ route('funciones.index') }}" class="accordion-link">📋 Ver Funciones</a>
                            <a href="{{ route('funciones.create') }}" class="accordion-link">➕ Agregar Función</a>
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
                            <a href="{{ route('confiteria.index') }}" class="accordion-link">📋 Ver Catálogo</a>
                            <a href="{{ route('confiteria.create') }}" class="accordion-link">➕ Agregar Producto</a>
                        </div>
                    </div>
                </div>

                <!-- Sección Próximamente -->
                <div class="accordion-item">
                    <button class="accordion-header active" onclick="toggleAccordion(this)">
                        <span>🎥 Próximamente</span>
                        <span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content active">
                        <div class="accordion-links">
                            <a href="{{ route('proximamente.index') }}" class="accordion-link">📋 Próximos Estrenos</a>
                            <a href="{{ route('proximamente.create') }}" class="accordion-link">➕ Agregar Película</a>
                        </div>
                    </div>
                </div>

                <!-- Sección Usuarios -->
                @if(Auth::user()->role === 'admin')
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>👥 Usuarios</span>
                        <span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="{{ route('user.index') }}" class="accordion-link">👤 Vista Usuario</a>
                        </div>
                    </div>
                </div>
                @endif
            @endauth
        </aside>

    <div class="content-wrapper">
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
                    <label for="url">📄 Url</label>
                    <textarea id="trailer_url" name="trailer_url">{{ $registro->trailer_url }}</textarea>
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

                <div class="form-group">
                    <label for="age_suggest">⏱ Edad sugerida</label>
                    <input type="text" id="age_suggest" name="age_suggest" value="{{ $registro->age_suggest }}">
                </div>

                <div class="form-group">
                    <label for="genero">🎬 Género</label>
                    <select id="genero" name="genero">
                        <option value="">Selecciona un género</option>
                        <option value="Acción" {{ $registro->genero == 'Acción' ? 'selected' : '' }}>Acción</option>
                        <option value="Aventura" {{ $registro->genero == 'Aventura' ? 'selected' : '' }}>Aventura</option>
                        <option value="Comedia" {{ $registro->genero == 'Comedia' ? 'selected' : '' }}>Comedia</option>
                        <option value="Drama" {{ $registro->genero == 'Drama' ? 'selected' : '' }}>Drama</option>
                        <option value="Terror" {{ $registro->genero == 'Terror' ? 'selected' : '' }}>Terror</option>
                        <option value="Ciencia Ficción" {{ $registro->genero == 'Ciencia Ficción' ? 'selected' : '' }}>Ciencia Ficción</option>
                        <option value="Romance" {{ $registro->genero == 'Romance' ? 'selected' : '' }}>Romance</option>
                        <option value="Animación" {{ $registro->genero == 'Animación' ? 'selected' : '' }}>Animación</option>
                        <option value="Documental" {{ $registro->genero == 'Documental' ? 'selected' : '' }}>Documental</option>
                    </select>
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
</html>