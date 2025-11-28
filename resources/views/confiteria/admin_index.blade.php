<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confitería - Admin</title>
    @vite(['resources/css/admin_index.css', 'resources/js/app.js'])
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

        .product-card {
            background: rgba(30, 41, 59, 0.95);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 2px solid rgba(0, 212, 255, 0.2);
            transition: all 0.3s ease;
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .product-card:hover {
            border-color: #00d4ff;
            box-shadow: 0 8px 30px rgba(0, 212, 255, 0.3);
            transform: translateY(-5px);
        }

        .product-image {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid rgba(0, 212, 255, 0.3);
        }

        .product-info {
            flex: 1;
        }

        .product-name {
            font-size: 1.5rem;
            font-weight: bold;
            color: #00d4ff;
            margin-bottom: 0.5rem;
        }

        .product-description {
            color: #b0b0b0;
            margin-bottom: 0.5rem;
            line-height: 1.5;
        }

        .product-meta {
            display: flex;
            gap: 1.5rem;
            margin-top: 0.5rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(0, 212, 255, 0.1);
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .product-actions {
            display: flex;
            gap: 0.5rem;
            flex-direction: column;
        }

        .stock-low {
            color: #ff6b6b;
        }

        .stock-ok {
            color: #98fb98;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('confiteria.index') }}" class="navbar-brand">
                🍿 Confitería (Admin)
            </a>
            
            <div class="navbar-user">
                <div class="user-info">
                    <div class="user-avatar">
                        @auth
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        @else
                            I
                        @endauth
                    </div>
                    <span class="user-name">
                        @auth
                            {{ Auth::user()->name }}
                        @else
                            Invitado
                        @endauth
                    </span>
                </div>
                
                @auth
                    <a href="{{ route('movies.index') }}" class="btn-dashboard">
                        🎬 Películas
                    </a>
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
            <div class="sidebar-title">Menú Confitería</div>

            @auth
                <!-- Sección Confitería -->
                <div class="accordion-item">
                    <button class="accordion-header active" onclick="toggleAccordion(this)">
                        <span>🍿 Confitería</span>
                        <span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content active">
                        <div class="accordion-links">
                            <a href="{{ route('confiteria.index') }}" class="accordion-link">📋 Ver Catálogo</a>
                            <a href="{{ route('confiteria.create') }}" class="accordion-link">➕ Agregar Producto</a>
                        </div>
                    </div>
                </div>

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

                <!-- Sección Promociones -->
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>🏷️ Promociones</span>
                        <span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="{{ route('promociones.index') }}" class="accordion-link">📋 Ver Promociones</a>
                            <a href="{{ route('promociones.create') }}" class="accordion-link">➕ Agregar Promoción</a>
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
                <div class="header">
                    <h1>🍿 Catálogo de Confitería</h1>
                    <a href="{{ route('confiteria.create') }}" class="btn-add">
                        <span>➕ Agregar Producto</span>
                    </a>
                </div>

                @if(session('success'))
                    <div style="background: rgba(152, 251, 152, 0.2); border: 2px solid #98fb98; border-radius: 10px; padding: 1rem; margin-bottom: 1.5rem; color: #98fb98;">
                        ✅ {{ session('success') }}
                    </div>
                @endif
                
                @if($confiteria->isEmpty())
                    <div class="empty-state">
                        <h2>🍿 No hay productos registrados</h2>
                        <p>Comienza agregando tu primer producto de confitería</p>
                        <a href="{{ route('confiteria.create') }}" class="btn-add">
                            ➕ Agregar Primer Producto
                        </a>
                    </div>
                @else
                    @foreach($confiteria as $producto)
                        <div class="product-card">
                            @if($producto->imagen)
                                <img src="{{ asset('storage/' . $producto->imagen) }}" 
                                     alt="{{ $producto->nombre }}" 
                                     class="product-image">
                            @else
                                <div class="product-image" style="display: flex; align-items: center; justify-content: center; background: rgba(0, 212, 255, 0.1); font-size: 3rem;">
                                    🍿
                                </div>
                            @endif

                            <div class="product-info">
                                <div class="product-name">{{ $producto->nombre }}</div>
                                <div class="product-description">
                                    {{ $producto->descripcion ?? 'Sin descripción' }}
                                </div>
                                
                                <div class="product-meta">
                                    <div class="meta-item">
                                        <span>💵</span>
                                        <span>${{ number_format($producto->precio, 2) }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <span>📦</span>
                                        <span class="{{ $producto->stock < 10 ? 'stock-low' : 'stock-ok' }}">
                                            Stock: {{ $producto->stock }}
                                            @if($producto->stock < 10)
                                                (⚠️ Bajo)
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="product-actions">
                                <a href="{{ route('confiteria.edit', $producto->id) }}" class="btn btn-edit">
                                    <span>✏️ Editar</span>
                                </a>
                                <form action="{{ route('confiteria.destroy', $producto->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('¿Eliminar {{ $producto->nombre }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete" style="width: 100%;">
                                        <span>🗑️ Eliminar</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif
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

        window.addEventListener('load', () => {
            createParticles();
            
            // Animación de entrada
            const cards = document.querySelectorAll('.product-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateX(-50px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateX(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>
