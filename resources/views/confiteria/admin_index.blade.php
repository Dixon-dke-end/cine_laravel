<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confitería - Admin</title>
    @vite(['resources/css/admin_index.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f1419 0%, #1a2942 100%);
            color: #fff;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* NAVBAR */
        .navbar {
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            background: rgba(22, 33, 62, 0.98);
            border-bottom: 2px solid #00d4ff;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
        }

        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            gap: 2rem;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #00d4ff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            color: #fff;
            text-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #000;
        }

        .btn-add-navbar {
            padding: 0.6rem 1.2rem;
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            color: #000;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-add-navbar:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 212, 255, 0.3);
        }

        /* MAIN CONTAINER */
        .main-container {
            display: flex;
            margin-top: 70px;
            min-height: calc(100vh - 70px);
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            left: 0;
            top: 70px;
            width: 280px;
            height: calc(100vh - 70px);
            background: rgba(22, 33, 62, 0.95);
            border-right: 2px solid #00d4ff;
            padding: 2rem 0;
            overflow-y: auto;
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

        /* CONTENT WRAPPER */
        .content-wrapper {
            margin-left: 280px;
            flex: 1;
            width: calc(100% - 280px);
            padding: 2rem;
            overflow-y: auto;
        }

        .content {
            max-width: 1400px;
            margin: 0 auto;
        }

        .content h1 {
            margin-bottom: 2rem;
            color: #00d4ff;
            font-size: 2.2rem;
        }

        /* ALERTS */
        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 8px;
            border-left: 4px solid;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .alert-success {
            background: rgba(76, 175, 80, 0.15);
            border-left-color: #4CAF50;
            color: #fff;
        }

        .alert-error {
            background: rgba(244, 67, 54, 0.15);
            border-left-color: #f44336;
            color: #fff;
        }

        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            background: rgba(0, 212, 255, 0.1);
            border-radius: 12px;
            border: 2px dashed #00d4ff;
            margin-top: 2rem;
        }

        .empty-state h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #00d4ff;
        }

        .empty-state p {
            font-size: 1.1rem;
            color: #b0b0b0;
            margin-bottom: 1rem;
        }

        .btn-add {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            color: #000;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-add:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 212, 255, 0.3);
        }

        /* PRODUCTS GRID */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            padding: 20px 0;
        }

        .product-card {
            background: rgba(0, 212, 255, 0.05);
            border: 2px solid rgba(0, 212, 255, 0.2);
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            border-color: #00d4ff;
            box-shadow: 0 10px 30px rgba(0, 212, 255, 0.2);
            transform: translateY(-5px);
        }

        .product-image-container {
            height: 200px;
            overflow: hidden;
            position: relative;
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .product-placeholder {
            font-size: 4rem;
        }

        .product-info {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .product-name {
            font-size: 1.3rem;
            font-weight: bold;
            color: #00d4ff;
            margin-bottom: 0.5rem;
        }

        .product-description {
            font-size: 0.9rem;
            color: #b0b0b0;
            margin-bottom: 1rem;
            line-height: 1.4;
            flex: 1;
        }

        .product-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(0, 212, 255, 0.1);
        }

        .product-price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #fff;
        }

        .product-stock {
            font-size: 0.9rem;
            padding: 4px 8px;
            border-radius: 4px;
            background: rgba(255, 255, 255, 0.1);
        }

        .stock-low {
            color: #ff6b6b;
            background: rgba(255, 107, 107, 0.1);
        }

        .stock-ok {
            color: #4CAF50;
            background: rgba(76, 175, 80, 0.1);
        }

        .product-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 0.6rem;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            flex: 1;
        }

        .btn-edit {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: #fff;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
        }

        .btn-delete {
            background: linear-gradient(135deg, #f44336, #d32f2f);
            color: #fff;
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(244, 67, 54, 0.3);
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar {
                width: 250px;
            }

            .content-wrapper {
                margin-left: 250px;
                width: calc(100% - 250px);
                padding: 1rem;
            }

            .navbar {
                padding: 1rem;
                height: 70px;
            }

            .navbar-container {
                gap: 1rem;
            }

            .btn-add-navbar {
                padding: 0.5rem 0.8rem;
                font-size: 0.9rem;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            }
        }

        @media (max-width: 600px) {
            .sidebar {
                display: none;
            }

            .main-container {
                margin-top: 70px;
            }

            .content-wrapper {
                margin-left: 0;
                width: 100%;
                padding: 1rem;
            }

            .navbar {
                padding: 0.8rem;
                height: auto;
                flex-wrap: wrap;
            }

            .navbar-brand {
                font-size: 1.2rem;
            }

            .navbar-user {
                gap: 0.5rem;
            }

            .btn-add-navbar {
                font-size: 0.8rem;
                padding: 0.4rem 0.6rem;
            }

            .content h1 {
                font-size: 1.5rem;
            }
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
                    <span>{{ Auth::user()->name ?? 'Invitado' }}</span>
                </div>
                
                @auth
                    <a href="{{ route('confiteria.create') }}" class="btn-add-navbar">
                        ➕ Agregar Producto
                    </a>
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
                            <a href="{{ route('proximamente.admin') }}" class="accordion-link">📋 Próximos Estrenos</a>
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
                            <a href="{{ route('user.index') }}" class="accordion-link">👨‍💼 Gestionar</a>
                        </div>
                    </div>
                </div>
                @endif
            @endauth
        </aside>

        <div class="content-wrapper">
            <div class="content">
                <h1>🍿 Catálogo de Confitería</h1>

                @if(session('success'))
                    <div class="alert alert-success">
                        <span>✅</span>
                        <span>{{ session('success') }}</span>
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
                    <div class="products-grid">
                        @foreach($confiteria as $producto)
                            <div class="product-card">
                                <div class="product-image-container">
                                    @if($producto->imagen)
                                        <img src="{{ asset('storage/' . $producto->imagen) }}" 
                                             alt="{{ $producto->nombre }}" 
                                             class="product-image">
                                    @else
                                        <div class="product-placeholder">🍿</div>
                                    @endif
                                </div>

                                <div class="product-info">
                                    <div class="product-name">{{ $producto->nombre }}</div>
                                    <div class="product-description">
                                        {{ $producto->descripcion ?? 'Sin descripción' }}
                                    </div>
                                    
                                    <div class="product-meta">
                                        <div class="product-price">
                                            ${{ number_format($producto->precio, 2) }}
                                        </div>
                                        <div class="product-stock {{ $producto->stock < 10 ? 'stock-low' : 'stock-ok' }}">
                                            Stock: {{ $producto->stock }}
                                        </div>
                                    </div>

                                    <div class="product-actions">
                                        <a href="{{ route('confiteria.edit', $producto->id) }}" class="btn btn-edit">
                                            <span>✏️ Editar</span>
                                        </a>
                                        <form action="{{ route('confiteria.destroy', $producto->id) }}" 
                                              method="POST" 
                                              style="flex: 1; display: flex;"
                                              onsubmit="return confirmDelete(event, '{{ $producto->nombre }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-delete">
                                                <span>🗑️ Eliminar</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
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

        // Función para confirmar eliminación con efecto
        function confirmDelete(event, nombre) {
            event.preventDefault();
            
            const card = event.target.closest('.product-card');
            if (card) {
                card.style.filter = 'brightness(0.5)';
            }
            
            if (confirm('¿Estás seguro de que quieres eliminar "' + nombre + '"?')) {
                // Animación de salida
                if (card) {
                    card.style.transition = 'all 0.5s ease';
                    card.style.transform = 'scale(0) rotate(10deg)';
                    card.style.opacity = '0';
                    
                    setTimeout(() => {
                        event.target.submit();
                    }, 500);
                } else {
                    event.target.submit();
                }
            } else {
                if (card) {
                    card.style.filter = 'brightness(1)';
                }
            }
            
            return false;
        }

        window.addEventListener('load', () => {
            createParticles();
            
            // Animación de entrada
            const cards = document.querySelectorAll('.product-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>
