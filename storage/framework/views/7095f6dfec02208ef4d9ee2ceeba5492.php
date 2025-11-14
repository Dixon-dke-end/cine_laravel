<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - MoviesCatalog</title>
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

        .login-container {
            max-width: 450px;
            width: 100%;
            position: relative;
            z-index: 1;
            animation: slideIn 0.8s ease;
            margin: 0 auto;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 45px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.4);
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 25px 20px;
                border-radius: 20px;
            }

            h1 {
                font-size: 1.8rem;
            }

            .login-icon {
                font-size: 2.5rem;
            }

            .subtitle {
                font-size: 0.9rem;
            }

            input[type="email"],
            input[type="password"] {
                padding: 12px 14px;
                font-size: 0.95rem;
            }

            .btn-primary {
                padding: 12px 24px;
                font-size: 1rem;
            }

            label {
                font-size: 0.9rem;
            }

            .form-group {
                margin-bottom: 20px;
            }
        }

        @media (min-width: 481px) and (max-width: 768px) {
            .login-card {
                padding: 35px 30px;
            }

            h1 {
                font-size: 2.2rem;
            }

            .login-icon {
                font-size: 3.5rem;
            }
        }

        @media (min-width: 1024px) {
            .login-container {
                max-width: 500px;
            }

            .login-card {
                padding: 50px;
            }
        }

        @media (max-height: 700px) {
            body {
                padding: 10px;
            }

            .login-card {
                padding: 30px;
            }

            .login-icon {
                font-size: 3rem;
                margin-bottom: 10px;
            }

            h1 {
                font-size: 2rem;
                margin-bottom: 5px;
            }

            .form-group {
                margin-bottom: 18px;
            }

            .login-header {
                margin-bottom: 25px;
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .login-icon {
            font-size: 4rem;
            margin-bottom: 15px;
            animation: glow 2s ease-in-out infinite alternate;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: bold;
            background: linear-gradient(45deg, #fff, #87ceeb, #ffd700);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
        }

        .subtitle {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.5);
            opacity: 0.7;
        }

        /* Status messages */
        .status-message {
            background: rgba(152, 251, 152, 0.2);
            border: 2px solid #98fb98;
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 20px;
            color: #98fb98;
            text-align: center;
            animation: slideIn 0.5s ease;
        }

        .form-group {
            margin-bottom: 25px;
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

        input[type="email"],
        input[type="password"] {
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

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #87ceeb;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 15px rgba(135, 206, 235, 0.4);
            transform: scale(1.02);
        }

        input[type="email"]::placeholder,
        input[type="password"]::placeholder {
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

        /* Checkbox Remember Me */
        .remember-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
        }

        input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: #87ceeb;
        }

        .remember-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
            cursor: pointer;
            user-select: none;
        }

        /* Links */
        .forgot-password {
            color: #87ceeb;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .forgot-password:hover {
            color: #ffd700;
            transform: translateX(3px);
        }

        .actions-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 10px;
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

        /* Register link */
        .register-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .register-link span {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.95rem;
        }

        .register-link a {
            color: #ffd700;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .register-link a:hover {
            color: #87ceeb;
            text-decoration: underline;
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
            /* Ya cubierto por los nuevos media queries más específicos */
        }
    </style>
</head>
<body>
    <!-- Partículas de fondo -->
    <div class="particles" id="particles"></div>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-icon">🎬</div>
                <h1>Bienvenido</h1>
                <p class="subtitle">Inicia sesión en MoviesCatalog</p>
            </div>

            <!-- Session Status -->
            <?php if(session('status')): ?>
                <div class="status-message">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">📧 Correo Electrónico</label>
                    <input id="email" 
                           type="email" 
                           name="email" 
                           value="<?php echo e(old('email')); ?>" 
                           placeholder="tu@email.com"
                           required 
                           autofocus 
                           autocomplete="username">
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="error-message"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">🔒 Contraseña</label>
                    <input id="password" 
                           type="password" 
                           name="password" 
                           placeholder="••••••••"
                           required 
                           autocomplete="current-password">
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="error-message"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Remember Me -->
                <div class="remember-group">
                    <input id="remember_me" 
                           type="checkbox" 
                           name="remember">
                    <label for="remember_me" class="remember-label">
                        Recordarme
                    </label>
                </div>

                <!-- Actions -->
                <div class="actions-group">
                    <?php if(Route::has('password.request')): ?>
                        <a href="<?php echo e(route('password.request')); ?>" class="forgot-password">
                            ¿Olvidaste tu contraseña?
                        </a>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary">
                    <span>🚀 Iniciar Sesión</span>
                </button>

                <!-- Register Link -->
                <div class="register-link">
                    <span>¿No estás registrado?</span>
                    <a href="<?php echo e(route('register')); ?>">Crear cuenta aquí</a>
                </div>
            </form>
        </div>

        <!-- Back to catalog -->
        <div class="back-link">
            <a href="<?php echo e(route('movies.index')); ?>">
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
        const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.trim() !== '') {
                    this.style.borderColor = '#98fb98';
                } else {
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

        // Animación de shake para campos vacíos
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
</html><?php /**PATH C:\Users\Dixon\Desktop\cine_laravel\resources\views/auth/login.blade.php ENDPATH**/ ?>