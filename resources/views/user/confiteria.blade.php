<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Confitería - CineVel</title>
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
            background-image: url(/storage/movies/portada.jpg);
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

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-auth {
            padding: 0.5rem 1.25rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
            display: inline-block;
        }

        .btn-login {
            color: var(--primary);
            background: rgba(102, 126, 234, 0.1);
        }

        .btn-login:hover {
            background: rgba(102, 126, 234, 0.2);
        }

        .btn-logout {
            background: var(--gradient-main);
            color: white;
            box-shadow: var(--shadow-md);
        }

        .btn-logout:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-lg);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--gradient-main);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .user-name {
            font-weight: 600;
            color: var(--text-main);
            font-size: 0.95rem;
        }

        .cart-button {
            position: relative;
            background: var(--gradient-main);
            color: white;
            border: none;
            padding: 0.65rem 1.5rem;
            border-radius: 9999px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-md);
            text-decoration: none;
            font-size: 0.95rem;
        }

        .cart-button:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 800;
            border: 2px solid white;
        }

        /* Alerts */
        .alert {
            max-width: 1200px;
            margin: 1.5rem auto;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border: 2px solid #22c55e;
            color: #16a34a;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 2px solid #ef4444;
            color: #dc2626;
        }

        /* Header Section */
        .confiteria-header {
            background: var(--gradient-main);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
            margin-bottom: 2rem;
        }

        .confiteria-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .confiteria-header p {
            font-size: 1.1rem;
            opacity: 0.95;
        }

        /* Main Container */
        .main-container {
            max-width: 1400px;
            margin: 0 auto 4rem;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 2rem;
        }

        /* Products Section */
        .products-section {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 2rem;
            box-shadow: var(--shadow-sm);
        }

        .section-header {
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.5rem;
        }

        .section-subtitle {
            color: var(--text-muted);
            font-size: 1rem;
        }

        /* Products Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1.5rem;
        }

        .product-card {
            background: white;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        .product-info {
            padding: 1.5rem;
        }

        .product-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.5rem;
        }

        .product-description {
            color: var(--text-muted);
            font-size: 0.875rem;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.5;
        }

        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 800;
            background: var(--gradient-main);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .product-stock {
            font-size: 0.8rem;
            color: var(--text-muted);
            background: rgba(102, 126, 234, 0.1);
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
        }

        .product-actions {
            display: flex;
            gap: 0.75rem;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #f5f7fa;
            border-radius: 10px;
            padding: 0.25rem;
        }

        .qty-btn {
            width: 32px;
            height: 32px;
            border: none;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
            color: var(--primary);
            transition: all 0.2s ease;
            font-size: 1.1rem;
        }

        .qty-btn:hover {
            background: var(--primary);
            color: white;
        }

        .qty-input {
            width: 45px;
            text-align: center;
            border: none;
            background: transparent;
            font-weight: 700;
            font-size: 1rem;
            color: var(--text-main);
        }

        .btn-add-cart {
            flex: 1;
            background: #10b981;
            color: white;
            border: none;
            padding: 0.75rem 1.25rem;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .btn-add-cart:hover {
            background: #059669;
            transform: scale(1.02);
        }

        /* Cart Sidebar */
        .cart-sidebar {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 2rem;
            box-shadow: var(--shadow-sm);
            height: fit-content;
            position: sticky;
            top: 100px;
        }

        .cart-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #eee;
        }

        .cart-icon {
            font-size: 2rem;
        }

        .cart-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .cart-empty {
            text-align: center;
            padding: 3rem 1.5rem;
            color: var(--text-muted);
        }

        .cart-empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }

        .cart-items {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 1.5rem;
            padding-right: 0.5rem;
        }

        .cart-items::-webkit-scrollbar {
            width: 6px;
        }

        .cart-items::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .cart-items::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }

        .cart-item {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            background: #f5f7fa;
            border-radius: 12px;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .cart-item:hover {
            background: #edf2f7;
        }

        .cart-item-image {
            width: 70px;
            height: 70px;
            border-radius: 10px;
            object-fit: cover;
        }

        .cart-item-info {
            flex: 1;
        }

        .cart-item-name {
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.25rem;
            font-size: 0.95rem;
        }

        .cart-item-price {
            color: var(--primary);
            font-weight: 700;
            font-size: 1.1rem;
        }

        .cart-item-quantity {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .cart-qty-btn {
            width: 24px;
            height: 24px;
            border: none;
            background: var(--primary);
            color: white;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 700;
            transition: all 0.2s;
        }

        .cart-qty-btn:hover {
            background: var(--primary-dark);
        }

        .cart-item-remove {
            background: #ef4444;
            color: white;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            cursor: pointer;
            align-self: flex-start;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .cart-item-remove:hover {
            background: #dc2626;
            transform: scale(1.1);
        }

        .cart-summary {
            border-top: 2px solid #eee;
            padding-top: 1.5rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .summary-row.total {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-main);
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 2px solid #eee;
        }

        .btn-checkout {
            width: 100%;
            background: var(--gradient-main);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            margin-top: 1.5rem;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-md);
        }

        .btn-checkout:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-checkout:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-clear-cart {
            width: 100%;
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 2px solid #ef4444;
            padding: 0.75rem;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 0.75rem;
            transition: all 0.3s ease;
        }

        .btn-clear-cart:hover {
            background: #ef4444;
            color: white;
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
        @media (max-width: 1200px) {
            .main-container {
                grid-template-columns: 1fr;
            }

            .cart-sidebar {
                position: static;
            }
        }

        @media (max-width: 768px) {
            .navbar-menu {
                display: none;
            }

            .confiteria-header h1 {
                font-size: 2rem;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 1rem;
            }

            .main-container {
                padding: 0 1rem;
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
                <li><a href="{{ route('promociones.user') }}">PROMOCIONES</a></li>
                <li><a href="{{ route('confiteria.user') }}" class="active">CONFITERÍA</a></li>
            </ul>

            <div class="navbar-user">
                <a href="#carrito" class="cart-button">
                    🛒 Carrito
                    @if($carrito->sum('cantidad') > 0)
                        <span class="cart-badge">{{ $carrito->sum('cantidad') }}</span>
                    @endif
                </a>
                
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

    <!-- Alerts -->
    @if(session('success'))
    <div class="alert alert-success">
        ✅ {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        ❌ {{ session('error') }}
    </div>
    @endif

    <!-- Header -->
    <div class="confiteria-header">
        <h1>🍿 Confitería CineVel</h1>
        <p>Disfruta de tus snacks favoritos con los mejores precios</p>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Products Section -->
        <div class="products-section">
            <div class="section-header">
                <h2 class="section-title">Nuestros Productos</h2>
                <p class="section-subtitle">Selecciona tus favoritos y agrégalos al carrito</p>
            </div>

            <div class="products-grid">
                @forelse($productos as $producto)
                <div class="product-card">
                    <img src="{{ $producto->imagen ? asset('storage/' . $producto->imagen) : 'https://images.unsplash.com/photo-1585647347384-2593bc35786b?w=400&h=300&fit=crop' }}" 
                         alt="{{ $producto->nombre }}" 
                         class="product-image">
                    
                    <div class="product-info">
                        <h3 class="product-name">{{ $producto->nombre }}</h3>
                        <p class="product-description">{{ $producto->descripcion ?? 'Delicioso producto para disfrutar en el cine' }}</p>
                        
                        <div class="product-footer">
                            <div class="product-price">${{ number_format($producto->precio, 0, ',', '.') }}</div>
                            <div class="product-stock">📦 Stock: {{ $producto->stock }}</div>
                        </div>

                        <form action="{{ route('carrito.agregar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                            
                            <div class="product-actions">
                                <div class="quantity-selector">
                                    <button type="button" class="qty-btn" onclick="cambiarCantidad({{ $producto->id }}, -1)">−</button>
                                    <input type="number" class="qty-input" id="qty-{{ $producto->id }}" name="cantidad" value="1" min="1" max="{{ $producto->stock }}" readonly>
                                    <button type="button" class="qty-btn" onclick="cambiarCantidad({{ $producto->id }}, 1)">+</button>
                                </div>
                                <button type="submit" class="btn-add-cart">
                                    🛒 Agregar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 3rem; color: var(--text-muted);">
                    <p style="font-size: 3rem; margin-bottom: 1rem;">🍿</p>
                    <h3>No hay productos disponibles</h3>
                    <p>Pronto tendremos nuevos productos para ti</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Cart Sidebar -->
        <div class="cart-sidebar" id="carrito">
            <div class="cart-header">
                <span class="cart-icon">🛒</span>
                <h2 class="cart-title">Mi Carrito</h2>
            </div>

            @if($carrito->isEmpty())
                <div class="cart-empty">
                    <div class="cart-empty-icon">🛒</div>
                    <h3>Tu carrito está vacío</h3>
                    <p>Agrega productos para comenzar</p>
                </div>
            @else
                <div class="cart-items">
                    @foreach($carrito as $item)
                    <div class="cart-item">
                        <img src="{{ $item->producto->imagen ? asset('storage/' . $item->producto->imagen) : 'https://images.unsplash.com/photo-1585647347384-2593bc35786b?w=100&h=100&fit=crop' }}" 
                             alt="{{ $item->producto->nombre }}" 
                             class="cart-item-image">
                        
                        <div class="cart-item-info">
                            <div class="cart-item-name">{{ $item->producto->nombre }}</div>
                            <div class="cart-item-price">${{ number_format($item->producto->precio, 0, ',', '.') }}</div>
                            <div class="cart-item-quantity">
                                <form action="{{ route('carrito.actualizar', $item->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="cantidad" value="{{ $item->cantidad - 1 }}">
                                    <button type="submit" class="cart-qty-btn" {{ $item->cantidad <= 1 ? 'disabled' : '' }}>−</button>
                                </form>
                                <span style="font-weight: 700;">{{ $item->cantidad }}</span>
                                <form action="{{ route('carrito.actualizar', $item->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="cantidad" value="{{ $item->cantidad + 1 }}">
                                    <button type="submit" class="cart-qty-btn">+</button>
                                </form>
                            </div>
                        </div>
                        
                        <form action="{{ route('carrito.eliminar', $item->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="cart-item-remove" onclick="return confirm('¿Eliminar este producto?')">🗑️</button>
                        </form>
                    </div>
                    @endforeach
                </div>

                <div class="cart-summary">
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span>${{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Cargo servicio (5%):</span>
                        <span>${{ number_format($cargoServicio, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total:</span>
                        <span>${{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <form action="{{ route('pedidos.confiteria.crear') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-checkout">
                            💳 Proceder al Pago
                        </button>
                    </form>

                    <form action="{{ route('carrito.limpiar') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-clear-cart" onclick="return confirm('¿Vaciar el carrito?')">
                            🗑️ Vaciar Carrito
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 CineVel. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        function cambiarCantidad(productoId, cambio) {
            const input = document.getElementById(`qty-${productoId}`);
            let cantidad = parseInt(input.value) + cambio;
            const max = parseInt(input.max);
            
            if (cantidad < 1) cantidad = 1;
            if (cantidad > max) cantidad = max;
            
            input.value = cantidad;
        }

        // Auto-ocultar alertas después de 4 segundos
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 500);
            });
        }, 4000);

// Smooth scroll al carrito
        document.querySelector('.cart-button').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('carrito').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        });
    </script>
</body>
</html>