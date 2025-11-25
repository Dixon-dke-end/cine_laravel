<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CineVel - Confitería</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #667eea;
            --primary-dark: #5568d3;
            --secondary: #764ba2;
            --accent: #f093fb;
            
            --bg-light: #ffffff;
            --bg-gray: #f8f9fc;
            --text-dark: #1a1a2e;
            --text-gray: #6b7280;
            --text-light: #9ca3af;
            
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-soft: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            
            --shadow-sm: 0 2px 8px rgba(102, 126, 234, 0.08);
            --shadow-md: 0 4px 16px rgba(102, 126, 234, 0.12);
            --shadow-lg: 0 8px 32px rgba(102, 126, 234, 0.16);
            --shadow-glow: 0 0 40px rgba(102, 126, 234, 0.3);
            
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-gray);
            color: var(--text-dark);
            line-height: 1.6;
            min-height: 100vh;
        }

        /* Navigation */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
            box-shadow: var(--shadow-sm);
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2rem;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.5rem;
            background: var(--gradient-primary);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: var(--transition);
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
        }

        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(102, 126, 234, 0.5);
        }

        .nav-title {
            font-size: 1.5rem;
            font-weight: 700;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
        }

        /* Cart */
        .cart-icon {
            position: relative;
            font-size: 1.75rem;
            cursor: pointer;
            transition: var(--transition);
            padding: 0.5rem;
            border-radius: 50%;
        }

        .cart-icon:hover {
            transform: scale(1.1);
            background: var(--gradient-soft);
        }

        .cart-count {
            position: absolute;
            top: 0;
            right: 0;
            background: var(--gradient-primary);
            color: white;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.4);
        }

        .cart-dropdown {
            position: absolute;
            top: calc(100% + 1rem);
            right: 0;
            background: var(--bg-light);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            min-width: 350px;
            display: none;
            border: 1px solid rgba(102, 126, 234, 0.1);
            overflow: hidden;
        }

        .cart-dropdown.active {
            display: block;
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

        .cart-header {
            padding: 1.25rem;
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
            font-weight: 700;
            font-size: 1.125rem;
            color: var(--text-dark);
            background: var(--gradient-soft);
        }

        .cart-items {
            max-height: 350px;
            overflow-y: auto;
        }

        .cart-item {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid rgba(102, 126, 234, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: var(--transition);
        }

        .cart-item:hover {
            background: var(--gradient-soft);
        }

        .cart-item-info {
            flex: 1;
        }

        .cart-item-name {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }

        .cart-item-qty {
            font-size: 0.875rem;
            color: var(--text-gray);
        }

        .cart-item-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .cart-item-price {
            font-weight: 700;
            color: var(--primary);
            min-width: 70px;
            text-align: right;
        }

        .btn-remove {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(239, 68, 68, 0.1);
            border: none;
            color: #ef4444;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
        }

        .btn-remove:hover {
            background: #ef4444;
            color: white;
            transform: scale(1.1);
        }

        .cart-empty {
            padding: 3rem 1.25rem;
            text-align: center;
            color: var(--text-gray);
        }

        .cart-total {
            display: flex;
            justify-content: space-between;
            padding: 1.25rem;
            border-top: 2px solid rgba(102, 126, 234, 0.1);
            background: var(--gradient-soft);
            font-weight: 700;
            font-size: 1.125rem;
        }

        .btn-checkout {
            width: calc(100% - 2.5rem);
            padding: 0.875rem;
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            margin: 1.25rem;
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
        }

        .btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(102, 126, 234, 0.5);
        }

        /* User Section */
        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: var(--gradient-soft);
            border-radius: 50px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .user-name {
            font-weight: 600;
            color: var(--text-dark);
        }

        .btn-logout {
            padding: 0.625rem 1.5rem;
            background: transparent;
            color: var(--primary);
            border: 2px solid rgba(102, 126, 234, 0.3);
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-logout:hover {
            border-color: var(--primary);
            background: rgba(102, 126, 234, 0.05);
        }

        .btn-login {
            padding: 0.625rem 1.5rem;
            background: var(--gradient-primary);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: var(--transition);
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(102, 126, 234, 0.5);
        }

        /* Main Content */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 3rem 2rem;
        }

        .hero-section {
            text-align: center;
            margin-bottom: 3rem;
        }

        .hero-title {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 900;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: clamp(1rem, 2vw, 1.25rem);
            color: var(--text-gray);
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Products Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
        }

        .product-card {
            background: var(--bg-light);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: var(--transition);
            border: 1px solid rgba(102, 126, 234, 0.1);
            box-shadow: var(--shadow-sm);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .product-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transition: var(--transition);
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-glow);
            border-color: transparent;
        }

        .product-card:hover::before {
            transform: scaleX(1);
        }

        .product-icon {
            font-size: 4rem;
            margin-bottom: 1.25rem;
            animation: float 3s ease-in-out infinite;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .product-name {
            font-size: 1.375rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.75rem;
        }

        .product-price {
            font-size: 2rem;
            font-weight: 800;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
        }

        .product-description {
            color: var(--text-gray);
            font-size: 0.9375rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            min-height: 45px;
        }

        .btn-add-cart {
            width: 100%;
            padding: 0.875rem 1.5rem;
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
        }

        .btn-add-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(102, 126, 234, 0.5);
        }

        .btn-add-cart:active {
            transform: scale(0.98);
        }

        /* No Auth Message */
        .no-auth-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 60vh;
        }

        .no-auth-message {
            text-align: center;
            padding: 4rem 3rem;
            background: var(--bg-light);
            border-radius: 24px;
            border: 1px solid rgba(102, 126, 234, 0.1);
            box-shadow: var(--shadow-lg);
            max-width: 600px;
        }

        .no-auth-icon {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            opacity: 0.6;
        }

        .no-auth-message h2 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }

        .no-auth-message p {
            font-size: 1.125rem;
            color: var(--text-gray);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
                gap: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .nav-container {
                flex-wrap: wrap;
                gap: 1rem;
            }

            .nav-title {
                font-size: 1.25rem;
            }

            .user-name {
                display: none;
            }

            .container {
                padding: 2rem 1rem;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 1.25rem;
            }

            .cart-dropdown {
                min-width: 300px;
                right: -50px;
            }

            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .products-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }

            .product-card {
                padding: 1.5rem 1rem;
            }

            .product-icon {
                font-size: 3rem;
            }

            .product-name {
                font-size: 1.125rem;
            }

            .product-price {
                font-size: 1.5rem;
            }

            .product-description {
                font-size: 0.875rem;
                min-height: auto;
            }

            .cart-dropdown {
                min-width: 280px;
            }
        }

        @media (max-width: 400px) {
            .nav-container {
                padding: 1rem;
            }

            .products-grid {
                gap: 0.75rem;
            }
        }
    </style>
</head>
<body><!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('user.index') }}" class="navbar-brand">
                CineVel
            </a>
            
            <ul class="navbar-menu">
                <li><a href="{{route('user.index')}}" >CARTELERA</a></li>
                <li><a href="#promociones">PROMOCIONES</a></li>
                <li><a href="#proximamente">PRÓXIMAMENTE</a></li>
                <li><a href="{{route('confiteria.index')}}" class="active">CONFITERÍA</a></li>
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

    <div class="container">
        @auth
            <div class="hero-section">
                <h1 class="hero-title">🍿 Confitería Premium</h1>
                <p class="hero-subtitle">Disfruta de nuestras deliciosas ofertas mientras ves tu película favorita</p>
            </div>

            <!-- Products Grid -->
            <div class="products-grid">
                <!-- Palomitas -->
                <div class="product-card">
                    <div class="product-icon">🍿</div>
                    <div class="product-name">Palomitas Clásicas</div>
                    <div class="product-price">$5.00</div>
                    <div class="product-description">Palomitas saladas recién hechas</div>
                    <button class="btn-add-cart" onclick="addToCart('Palomitas Clásicas', 5.00)">Agregar al Carrito</button>
                </div>

                <!-- Gaseosa -->
                <div class="product-card">
                    <div class="product-icon">🥤</div>
                    <div class="product-name">Gaseosa Grande</div>
                    <div class="product-price">$4.50</div>
                    <div class="product-description">Bebida fría refrescante de 32 oz</div>
                    <button class="btn-add-cart" onclick="addToCart('Gaseosa Grande', 4.50)">Agregar al Carrito</button>
                </div>

                <!-- Chocolate -->
                <div class="product-card">
                    <div class="product-icon">🍫</div>
                    <div class="product-name">Chocolate Premium</div>
                    <div class="product-price">$3.50</div>
                    <div class="product-description">Chocolate belga de alta calidad</div>
                    <button class="btn-add-cart" onclick="addToCart('Chocolate Premium', 3.50)">Agregar al Carrito</button>
                </div>

                <!-- Caramelos -->
                <div class="product-card">
                    <div class="product-icon">🍬</div>
                    <div class="product-name">Mix de Caramelos</div>
                    <div class="product-price">$3.00</div>
                    <div class="product-description">Variedad de caramelos surtidos</div>
                    <button class="btn-add-cart" onclick="addToCart('Mix de Caramelos', 3.00)">Agregar al Carrito</button>
                </div>

                <!-- Nachos -->
                <div class="product-card">
                    <div class="product-icon">🧀</div>
                    <div class="product-name">Nachos con Queso</div>
                    <div class="product-price">$6.50</div>
                    <div class="product-description">Nachos crujientes con salsa de queso caliente</div>
                    <button class="btn-add-cart" onclick="addToCart('Nachos con Queso', 6.50)">Agregar al Carrito</button>
                </div>

                <!-- Helado -->
                <div class="product-card">
                    <div class="product-icon">🍦</div>
                    <div class="product-name">Helado Gourmet</div>
                    <div class="product-price">$4.00</div>
                    <div class="product-description">Helado de diversos sabores premium</div>
                    <button class="btn-add-cart" onclick="addToCart('Helado Gourmet', 4.00)">Agregar al Carrito</button>
                </div>

                <!-- Hot Dog -->
                <div class="product-card">
                    <div class="product-icon">🌭</div>
                    <div class="product-name">Hot Dog Especial</div>
                    <div class="product-price">$5.50</div>
                    <div class="product-description">Hot dog gourmet con adiciones especiales</div>
                    <button class="btn-add-cart" onclick="addToCart('Hot Dog Especial', 5.50)">Agregar al Carrito</button>
                </div>

                <!-- Combo -->
                <div class="product-card">
                    <div class="product-icon">🎬</div>
                    <div class="product-name">Combo Cineasta</div>
                    <div class="product-price">$12.00</div>
                    <div class="product-description">Palomitas + Bebida Grande + Dulce</div>
                    <button class="btn-add-cart" onclick="addToCart('Combo Cineasta', 12.00)">Agregar al Carrito</button>
                </div>
            </div>
        @else
            <div class="no-auth-container">
                <div class="no-auth-message">
                    <div class="no-auth-icon">🔒</div>
                    <h2>Acceso Restringido</h2>
                    <p>Por favor, inicia sesión para ver los productos disponibles en nuestra confitería</p>
                    <a href="{{ route('login') }}" class="btn-login">Iniciar Sesión</a>
                </div>
            </div>
        @endauth
    </div>

    <script>
        let cartItems = [];
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

        function loadCart() {
            fetch('/carrito', {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    cartItems = data.items;
                    updateCartUI();
                }
            })
            .catch(error => console.error('Error al cargar carrito:', error));
        }

        function toggleCart() {
            const dropdown = document.getElementById('cart-dropdown');
            if (dropdown) {
                dropdown.classList.toggle('active');
            }
        }

        function updateCartUI() {
            const cartCount = document.getElementById('cart-count');
            const cartItemsDiv = document.getElementById('cart-items');
            const cartTotalSection = document.getElementById('cart-total-section');
            const cartTotal = document.getElementById('cart-total');

            if (!cartCount) return;

            cartCount.textContent = cartItems.length;

            if (cartItems.length === 0) {
                cartItemsDiv.innerHTML = '<div class="cart-empty">Tu carrito está vacío</div>';
                if (cartTotalSection) cartTotalSection.style.display = 'none';
            } else {
                let html = '';
                let total = 0;
                cartItems.forEach((item) => {
                    html += `
                        <div class="cart-item">
                            <div class="cart-item-info">
                                <div class="cart-item-name">${item.product_name}</div>
                                <div class="cart-item-qty">x${item.quantity}</div>
                            </div>
                            <div class="cart-item-actions">
                                <div class="cart-item-price">$${(item.product_price * item.quantity).toFixed(2)}</div>
                                <button class="btn-remove" onclick="removeFromCart(${item.id})">×</button>
                            </div>
                        </div>
                    `;
                    total += item.product_price * item.quantity;
                });
                cartItemsDiv.innerHTML = html;
                if (cartTotalSection) cartTotalSection.style.display = 'flex';
                cartTotal.textContent = '$' + total.toFixed(2);
            }
        }

        function removeFromCart(itemId) {
            fetch(`/carrito/${itemId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadCart();
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function addToCart(name, price) {
            fetch('/carrito/agregar', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    product_name: name,
                    product_price: price,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadCart();
                    // Show feedback
                    const btn = event.target;
                    const originalText = btn.textContent;
                    btn.textContent = '✓ Agregado';
                    btn.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
                    setTimeout(() => {
                        btn.textContent = originalText;
                        btn.style.background = '';
                    }, 1500);
                } else {
                    alert('Error al agregar al carrito');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al conectar con el servidor');
            });
        }

        // Close cart dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const cartIcon = document.querySelector('.cart-icon');
            const cartDropdown = document.getElementById('cart-dropdown');
            if (cartIcon && cartDropdown && !cartIcon.contains(event.target) && !cartDropdown.contains(event.target)) {
                cartDropdown.classList.remove('active');
            }
        });

        // Load cart on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadCart();
        });
    </script>
</body>
</html>