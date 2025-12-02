<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - CineVel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #2d3748;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
        }

        .navbar-menu {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .navbar-menu a {
            color: #4a5568;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .navbar-menu a:hover {
            color: #667eea;
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
        }

        .user-name {
            color: #2d3748;
            font-weight: 600;
        }

        .btn-auth {
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            background: none;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .btn-logout {
            color: #667eea;
            border: 2px solid #667eea;
            background: white;
        }

        .btn-logout:hover {
            background: #667eea;
            color: white;
        }

        .profile-wrapper {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .profile-header {
            background: white;
            border-radius: 24px;
            padding: 2rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 2rem;
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.15);
        }

        .profile-avatar-large {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            font-weight: 700;
            color: white;
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
        }

        .profile-info h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            color: #2d3748;
        }

        .profile-meta {
            display: flex;
            gap: 2rem;
            color: #718096;
            font-size: 0.95rem;
        }

        .tabs-container {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            background: white;
            padding: 0.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.1);
        }

        .tab-btn {
            flex: 1;
            padding: 1rem 2rem;
            background: transparent;
            border: none;
            color: #718096;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .tab-btn:hover {
            color: #667eea;
            background: #f7fafc;
        }

        .tab-btn.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
        }

        .content-section {
            display: none;
            animation: fadeIn 0.4s ease;
        }

        .content-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        .card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.1);
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(102, 126, 234, 0.2);
        }

        .card:hover::before {
            transform: scaleX(1);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1.5rem;
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2d3748;
            line-height: 1.3;
        }

        .status-badge {
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-confirmada {
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
            box-shadow: 0 4px 12px rgba(72, 187, 120, 0.3);
        }

        .status-pendiente {
            background: linear-gradient(135deg, #ed8936, #dd6b20);
            color: white;
            box-shadow: 0 4px 12px rgba(237, 137, 54, 0.3);
        }

        .status-cancelada {
            background: linear-gradient(135deg, #f56565, #e53e3e);
            color: white;
            box-shadow: 0 4px 12px rgba(245, 101, 101, 0.3);
        }

        .card-details {
            display: grid;
            gap: 1rem;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            background: #f7fafc;
            border-radius: 10px;
            border-left: 3px solid #667eea;
        }

        .detail-label {
            color: #718096;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .detail-value {
            color: #2d3748;
            font-weight: 600;
            font-size: 1rem;
        }

        .seats-container {
            margin-top: 1rem;
            padding: 1rem;
            background: #f7fafc;
            border-radius: 12px;
        }

        .seats-label {
            color: #718096;
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
            display: block;
        }

        .seats-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .seat-badge {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 0.4rem 0.9rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
        }

        .products-list {
            margin-top: 1rem;
            display: grid;
            gap: 0.75rem;
        }

        .product-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background: #f7fafc;
            border-radius: 10px;
            border-left: 3px solid #764ba2;
        }

        .product-name {
            color: #2d3748;
            font-weight: 500;
        }

        .product-price {
            color: #667eea;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border: 2px dashed #cbd5e0;
            border-radius: 20px;
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: #2d3748;
        }

        .empty-state p {
            color: #718096;
            margin-bottom: 2rem;
        }

        .btn-action {
            display: inline-block;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(102, 126, 234, 0.4);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .info-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.1);
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(102, 126, 234, 0.2);
        }

        .info-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .info-label {
            color: #718096;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .info-value {
            color: #2d3748;
            font-size: 1.3rem;
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .cards-grid {
                grid-template-columns: 1fr;
            }

            .profile-header {
                flex-direction: column;
                text-align: center;
            }

            .tabs-container {
                flex-direction: column;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .navbar-menu {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('user.index') }}" class="navbar-brand">
                CineVel
            </a>
            
            <ul class="navbar-menu">
                <li><a href="{{ route('user.index') }}">CARTELERA</a></li>
                <li><a href="{{route('promociones.user')}}">PROMOCIONES</a></li>
                <li><a href="{{route('confiteria.user')}}">CONFITERÍA</a></li>
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
                    <a href="{{ route('user.perfil') }}" style="text-decoration: none;">
                        <div class="user-info">
                            <div class="user-avatar">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="user-name">{{ Auth::user()->name }}</span>
                        </div>
                    </a>
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

    <!-- Profile Content -->
    <div class="profile-wrapper">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-avatar-large">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="profile-info">
                <h1>{{ $user->name }}</h1>
                <div class="profile-meta">
                    <span>📧 {{ $user->email }}</span>
                    <span>👤 {{ $user->role === 'admin' ? 'Administrador' : 'Usuario' }}</span>
                    <span>📅 Miembro desde {{ $user->created_at->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="tabs-container">
            <button class="tab-btn active" onclick="showTab('info')">
                <span>📋</span> MI PERFIL
            </button>
            <button class="tab-btn" onclick="showTab('reservas')">
                <span>🎬</span> MIS RESERVAS
            </button>
            <button class="tab-btn" onclick="showTab('confiteria')">
                <span>🍿</span> MIS COMPRAS
            </button>
        </div>

        <!-- Info Section -->
        <div id="info-section" class="content-section active">
            <div class="info-grid">
                <div class="info-card">
                    <div class="info-icon">🎟️</div>
                    <div class="info-label">Total Reservas</div>
                    <div class="info-value">{{ $reservas->count() }}</div>
                </div>
                <div class="info-card">
                    <div class="info-icon">🍿</div>
                    <div class="info-label">Compras Confitería</div>
                    <div class="info-value">{{ $pedidosConfiteria->count() }}</div>
                </div>
                <div class="info-card">
                    <div class="info-icon">🗓️</div>
                    <div class="info-label">Reservas Próximas</div>
                    <div class="info-value">
                        {{ $reservas->filter(function($reserva) {
                            return $reserva->estado === 'confirmada' && 
                                   \Carbon\Carbon::parse($reserva->funcion->hora)->isFuture();
                        })->count() }}
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-icon">⭐</div>
                    <div class="info-label">Producto Favorito</div>
                    <div class="info-value" style="font-size: 1rem;">
                        @php
                            $productosMasComprados = [];
                            foreach($pedidosConfiteria as $pedido) {
                                foreach($pedido->productos as $item) {
                                    $nombre = $item->confiteria->nombre;
                                    if(!isset($productosMasComprados[$nombre])) {
                                        $productosMasComprados[$nombre] = 0;
                                    }
                                    $productosMasComprados[$nombre] += $item->cantidad;
                                }
                            }
                            arsort($productosMasComprados);
                            $favorito = array_key_first($productosMasComprados);
                        @endphp
                        {{ $favorito ?? 'Sin compras' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Reservas Section -->
        <div id="reservas-section" class="content-section">
            @if($reservas->count() > 0)
                <div class="cards-grid">
                    @foreach($reservas as $reserva)
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ $reserva->funcion->movie->titulo }}</h3>
                                <span class="status-badge status-{{ $reserva->estado }}">
                                    {{ ucfirst($reserva->estado) }}
                                </span>
                            </div>
                            <div class="card-details">
                                <div class="detail-row">
                                    <span class="detail-label">📅 Fecha y Hora</span>
                                    <span class="detail-value">{{ \Carbon\Carbon::parse($reserva->funcion->hora)->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">🎭 Sala</span>
                                    <span class="detail-value">{{ $reserva->funcion->sala->nombre }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">🪑 Asientos</span>
                                    <span class="detail-value">{{ $reserva->cantidad_asientos }} asientos</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">💰 Total</span>
                                    <span class="detail-value">${{ number_format($reserva->precio_total, 2) }}</span>
                                </div>
                            </div>
                            @if($reserva->asientos && count($reserva->asientos) > 0)
                                <div class="seats-container">
                                    <span class="seats-label">Tus asientos:</span>
                                    <div class="seats-grid">
                                        @foreach($reserva->asientos as $asiento)
                                            <span class="seat-badge">{{ $asiento }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if($reserva->metodo_pago)
                                <div class="detail-row" style="margin-top: 1rem;">
                                    <span class="detail-label">Método de Pago</span>
                                    <span class="detail-value">{{ ucfirst($reserva->metodo_pago) }}</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">🎬</div>
                    <h3>No tienes reservas aún</h3>
                    <p>Explora nuestra cartelera y reserva tus asientos para las mejores películas</p>
                    <a href="{{ route('user.index') }}" class="btn-action">
                        Ver Cartelera
                    </a>
                </div>
            @endif
        </div>

        <!-- Confitería Section -->
        <div id="confiteria-section" class="content-section">
            @if($pedidosConfiteria->count() > 0)
                <div class="cards-grid">
                    @foreach($pedidosConfiteria as $pedido)
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Pedido #{{ $pedido->id }}</h3>
                                <span class="status-badge status-{{ $pedido->estado }}">
                                    {{ ucfirst($pedido->estado) }}
                                </span>
                            </div>
                            <div class="card-details">
                                <div class="detail-row">
                                    <span class="detail-label">📅 Fecha</span>
                                    <span class="detail-value">{{ $pedido->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">💰 Subtotal</span>
                                    <span class="detail-value">${{ number_format($pedido->subtotal, 2) }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">🎫 Cargo Servicio</span>
                                    <span class="detail-value">${{ number_format($pedido->cargo_servicio, 2) }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">💵 Total</span>
                                    <span class="detail-value">${{ number_format($pedido->total, 2) }}</span>
                                </div>
                            </div>
                            @if($pedido->productos && $pedido->productos->count() > 0)
                                <div class="products-list">
                                    @foreach($pedido->productos as $item)
                                        <div class="product-item">
                                            <span class="product-name">{{ $item->confiteria->nombre }} x{{ $item->cantidad }}</span>
                                            <span class="product-price">${{ number_format($item->precio_unitario * $item->cantidad, 2) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">🍿</div>
                    <h3>No tienes compras de confitería</h3>
                    <p>Visita nuestra confitería y disfruta de deliciosos snacks</p>
                    <a href="{{ route('confiteria.user') }}" class="btn-action">
                        Ver Confitería
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        function showTab(tab) {
            // Update tab buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.closest('.tab-btn').classList.add('active');

            // Update sections
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.remove('active');
            });
            document.getElementById(tab + '-section').classList.add('active');
        }
    </script>
</body>
</html>