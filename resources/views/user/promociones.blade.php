<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promociones - CineVel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        :root {
            --primary: #667eea;
            --primary-dark: #5a67d8;
            --secondary: #764ba2;
            --accent: #f093fb;
            --bg-body: #f4f6f9;
            --bg-card: #ffffff;
            --text-main: #1a202c;
            --text-muted: #718096;
            --gradient-main: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --radius: 16px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-body);
            color: var(--text-main);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: var(--shadow-sm);
        }

        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-size: 1.75rem;
            font-weight: 800;
            background: var(--gradient-main);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
            letter-spacing: -0.025em;
        }

        .navbar-menu {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .navbar-menu a {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: color 0.2s;
        }

        .navbar-menu a:hover,
        .navbar-menu a.active {
            color: var(--primary);
        }

        /* Header Section */
        .promo-header {
            background: var(--gradient-main);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
            margin-bottom: 2rem;
        }

        .promo-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .promo-header p {
            font-size: 1.1rem;
            opacity: 0.95;
        }

        /* Filter Section */
        .filter-section {
            max-width: 1200px;
            margin: 0 auto 2rem;
            padding: 0 2rem;
        }

        .filter-sidebar {
            background: white;
            border-radius: var(--radius);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            margin-bottom: 2rem;
        }

        .filter-title {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-options {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .filter-chip {
            padding: 0.5rem 1.25rem;
            border: 2px solid #e2e8f0;
            border-radius: 9999px;
            background: white;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-chip:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .filter-chip.active {
            background: var(--gradient-main);
            color: white;
            border-color: transparent;
            box-shadow: var(--shadow-md);
        }

        /* Promociones Grid */
        .promociones-section {
            max-width: 1200px;
            margin: 0 auto 4rem;
            padding: 0 2rem;
        }

        .promociones-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 2rem;
        }

        .promo-card {
            background: white;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .promo-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .promo-image-container {
            position: relative;
            padding-top: 60%;
            overflow: hidden;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .promo-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .promo-card:hover .promo-image {
            transform: scale(1.08);
        }

        .promo-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            z-index: 10;
            backdrop-filter: blur(8px);
        }

        .badge-descuento {
            background: rgba(239, 68, 68, 0.9);
            color: white;
        }

        .badge-boleteria {
            background: rgba(59, 130, 246, 0.9);
            color: white;
        }

        .badge-confiteria {
            background: rgba(249, 115, 22, 0.9);
            color: white;
        }

        .badge-combos {
            background: rgba(34, 197, 94, 0.9);
            color: white;
        }

        .badge-general {
            background: rgba(102, 126, 234, 0.9);
            color: white;
        }

        .promo-discount-overlay {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: rgba(220, 38, 38, 0.95);
            color: white;
            padding: 0.75rem 1.25rem;
            border-radius: 12px;
            font-weight: 800;
            font-size: 1.5rem;
            box-shadow: var(--shadow-lg);
        }

        .promo-content {
            padding: 1.5rem;
        }

        .promo-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--text-main);
            line-height: 1.3;
        }

        .promo-description {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .promo-meta {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .promo-date {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .promo-code {
            background: rgba(102, 126, 234, 0.1);
            color: var(--primary);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.9rem;
            letter-spacing: 0.05em;
        }

        .promo-actions {
            display: flex;
            gap: 0.75rem;
        }

        .btn-promo {
            flex: 1;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            text-align: center;
        }

        .btn-primary {
            background: var(--gradient-main);
            color: white;
            box-shadow: var(--shadow-md);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .status-indicator {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-active {
            background: rgba(34, 197, 94, 0.1);
            color: #16a34a;
        }

        .status-inactive {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-muted);
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        /* Footer */
        .footer {
            background: white;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            padding: 3rem 0;
            text-align: center;
            color: var(--text-muted);
            margin-top: 4rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .promo-header h1 {
                font-size: 2rem;
            }

            .promociones-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .filter-options {
                gap: 0.5rem;
            }

            .filter-chip {
                font-size: 0.85rem;
                padding: 0.4rem 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('user.index') }}" class="navbar-brand">CineVel</a>
            <ul class="navbar-menu">
                <li><a href="{{ route('user.index') }}#cartelera">CARTELERA</a></li>
                <li><a href="{{ route('promociones.user') }}" class="active">PROMOCIONES</a></li>
                <li><a href="{{ route('confiteria.user') }}">CONFITERÍA</a></li>
            </ul>
            
            <div class="navbar-user">
                @guest
                    <a href="{{ route('login') }}" class="btn-auth btn-login">Iniciar Sesión</a>
                @else
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('movies.index') }}" class="btn-auth" style="background: #fff3cd; color: #856404;">
                            Admin
                        </a>
                    @endif
                    <div class="user-info">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="user-name">{{ Auth::user()->name }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-auth btn-logout">
                            Salir
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="promo-header">
        <h1>🎉 Promociones Disponibles</h1>
        <p>Todas las promociones están sujetas a términos y condiciones</p>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-sidebar">
            <div class="filter-title">
                🔍 Filtros
            </div>
            <div class="filter-options">
                <button class="filter-chip active" onclick="filterPromos('all')">Todas</button>
                <button class="filter-chip" onclick="filterPromos('boleteria')">Boletería</button>
                <button class="filter-chip" onclick="filterPromos('promociones')">Promociones</button>
                <button class="filter-chip" onclick="filterPromos('confiteria')">Confitería</button>
                <button class="filter-chip" onclick="filterPromos('combos')">Combos</button>
                <button class="filter-chip" onclick="filterPromos('descuento')">Descuentos</button>
            </div>
        </div>
    </div>

    <!-- Promociones Grid -->
    <div class="promociones-section">
        <div class="promociones-grid">
            @forelse($promociones as $promocion)
                <div class="promo-card" data-tipo="{{ $promocion->tipo }}">
                    <div class="promo-image-container">
                        @if($promocion->imagen)
                            <img src="{{ asset('storage/'.$promocion->imagen) }}" alt="{{ $promocion->titulo }}" class="promo-image">
                        @else
                            <img src="https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?w=800&h=500&fit=crop" alt="{{ $promocion->titulo }}" class="promo-image">
                        @endif
                        
                        @if($promocion->descuento)
                            <div class="promo-discount-overlay">{{ $promocion->descuento }}% OFF</div>
                        @endif
                        
                        <div class="promo-badge badge-{{ $promocion->tipo }}">
                            {{ ucfirst($promocion->tipo) }}
                        </div>
                    </div>
                    
                    <div class="promo-content">
                        <h3 class="promo-title">{{ $promocion->titulo }}</h3>
                        <p class="promo-description">{{ $promocion->descripcion }}</p>
                        
                        <div class="promo-meta">
                            <div class="promo-date">
                                📅 Válido hasta: {{ $promocion->fecha_fin->format('d/m/Y') }}
                            </div>
                            
                            @if($promocion->activo)
                                <span class="status-indicator status-active">● Activa</span>
                            @else
                                <span class="status-indicator status-inactive">● Inactiva</span>
                            @endif
                        </div>
                        
                        @if($promocion->codigo)
                            <div style="margin-bottom: 1rem;">
                                <span class="promo-code">{{ $promocion->codigo }}</span>
                            </div>
                        @endif
                        
                        <div class="promo-actions">
                            <button class="btn-promo btn-primary">Ver Detalles</button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state" style="grid-column: 1/-1;">
                    <div class="empty-state-icon">🎫</div>
                    <h3>No hay promociones disponibles</h3>
                    <p>Pronto tendremos nuevas ofertas para ti</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 CineVel. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        function filterPromos(tipo) {
            // Update active filter chip
            document.querySelectorAll('.filter-chip').forEach(chip => {
                chip.classList.remove('active');
            });
            event.target.classList.add('active');

            // Filter cards
            const cards = document.querySelectorAll('.promo-card');
            cards.forEach(card => {
                if (tipo === 'all') {
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'scale(1)';
                    }, 50);
                } else {
                    if (card.dataset.tipo === tipo) {
                        card.style.display = 'block';
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'scale(1)';
                        }, 50);
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.9)';
                        setTimeout(() => card.style.display = 'none', 300);
                    }
                }
            });
        }

        // Initialize card animations
        document.querySelectorAll('.promo-card').forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    </script>
</body>
</html>