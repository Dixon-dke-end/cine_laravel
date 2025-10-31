<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - MoviesCatalog</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow: hidden;
        }

        /* Partículas de fondo */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 15s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(50px, -100px) scale(1.1); }
            50% { transform: translate(-50px, -200px) scale(0.9); }
            75% { transform: translate(100px, -100px) scale(1.05); }
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes glow {
            0%, 100% { 
                filter: drop-shadow(0 0 10px rgba(255,255,255,0.3));
                text-shadow: 0 0 20px rgba(255,255,255,0.5);
            }
            50% { 
                filter: drop-shadow(0 0 25px rgba(255,255,255,0.6));
                text-shadow: 0 0 40px rgba(255,255,255,0.8);
            }
        }

        .forgot-container {
            max-width: 500px;
            width: 100%;
            position: relative;
            z-index: 1;
            animation: slideIn 0.8s ease;
        }

        .forgot-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 45px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.4);
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        .forgot-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .forgot-icon {
            font-size: 4rem;
            margin-bottom: 15px;
            animation: glow 2s ease-in-out infinite alternate;
        }

        h1 {
            font-size: 2.3rem;
            font-weight: bold;
            background: linear-gradient(45deg, #fff, #87ceeb, #ffd700);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 15px;
        }

        .description {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.6;
            margin-bottom: 30px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            border-left: 4px solid #87ceeb;
        }

        /* Status messages */
        .status-message {
            background: rgba(152, 251, 152, 0.2);
            border: 2px solid #98fb98;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 25px;
            color: #98fb98;
            text-align: center;
            animation: slideIn 0.5s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 30px;
        }

        label {
            display: block;
            font-size: 1rem;
            font-weight: bold;
            margin-bottom: 8px;
            color: #ffd700;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
        }

        .form-group:focus-within label {
            color: #87ceeb;
            transform: translateX(5px);
        }

        input[type="email"] {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            color: #fff;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        input[type="email"]:focus {
            outline: none;
            border-color: #87ceeb;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 15px rgba(135, 206, 235, 0.4);
            transform: scale(1.02);
        }

        input[type="email"]::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        /* Error messages */
        .error-message {
            color: #ff6b6b;
            font-size: 0.85rem;
            margin-top: 5px;
            display: block;
            animation: slideIn 0.3s ease;
        }

        /* Helper text */
        .helper-text {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.5);
            margin-top: 8px;
            font-style: italic;
        }

        /* Buttons */
        .btn {
            padding: 14px 32px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-size: 1.05rem;
            font-weight: bold;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.4);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn span {
            position: relative;
            z-index: 1;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            width: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.6);
        }

        .btn-primary:active {
            transform: translateY(-1px);
        }

        /* Links section */
        .links-section {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            flex-wrap: wrap;
        }

        .link {
            color: #87ceeb;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .link:hover {
            color: #ffd700;
            transform: translateX(-3px);
        }

        /* Back to catalog link */
        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .back-link a:hover {
            color: #fff;
            transform: translateX(-3px);
        }

        @media (max-width: 768px) {
            .forgot-card {
                padding: 30px 25px;
            }

            h1 {
                font-size: 2rem;
            }

            .forgot-icon {
                font-size: 3rem;
            }

            .links-section {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <!-- Partículas de fondo -->
    <div class="particles" id="particles"></div>

    <div class="forgot-container">
        <div class="forgot-card">
            <div class="forgot-header">
                <div class="forgot-icon">🔑</div>
                <h1>Recuperar Contraseña</h1>
            </div>

            <div class="description">
                💡 ¿Olvidaste tu contraseña? No hay problema. Solo indícanos tu dirección de correo electrónico y te enviaremos un enlace para restablecer tu contraseña y elegir una nueva.
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="status-message">
                    <span>✅</span>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">📧 Correo Electrónico</label>
                    <input id="email" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           placeholder="tu@email.com"
                           required 
                           autofocus>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                    <div class="helper-text">Ingresa el correo con el que te registraste</div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <span>📨 Enviar Enlace de Recuperación</span>
                </button>

                <!-- Links -->
                <div class="links-section">
                    <a href="{{ route('login') }}" class="link">
                        ← Volver al inicio de sesión
                    </a>
                    <span style="color: rgba(255,255,255,0.3);">|</span>
                    <a href="{{ route('register') }}" class="link">
                        Crear cuenta nueva →
                    </a>
                </div>
            </form>
        </div>

        <!-- Back to catalog -->
        <div class="back-link">
            <a href="{{ route('movies.index') }}">
                ← Volver al catálogo
            </a>
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

        // Animación de entrada del formulario
        window.addEventListener('load', () => {
            createParticles();
            
            const formGroup = document.querySelector('.form-group');
            formGroup.style.opacity = '0';
            formGroup.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                formGroup.style.transition = 'all 0.6s ease';
                formGroup.style.opacity = '1';
                formGroup.style.transform = 'translateY(0)';
            }, 100);
        });

        // Validación visual
        const emailInput = document.getElementById('email');
        
        emailInput.addEventListener('input', function() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (emailRegex.test(this.value)) {
                this.style.borderColor = '#98fb98';
            } else if (this.value.trim() !== '') {
                this.style.borderColor = '#ffd700';
            } else {
                this.style.borderColor = 'rgba(255, 255, 255, 0.2)';
            }
        });

        emailInput.addEventListener('blur', function() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (this.value.trim() === '') {
                this.style.borderColor = '#ff6b6b';
                this.style.animation = 'shake 0.3s ease';
            } else if (!emailRegex.test(this.value)) {
                this.style.borderColor = '#ff6b6b';
            }
        });

        emailInput.addEventListener('focus', function() {
            this.style.borderColor = '#87ceeb';
            this.style.animation = 'none';
        });

        // Animación de shake
        const style = document.createElement('style');
        style.textContent = `
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-10px); }
                75% { transform: translateX(10px); }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>