<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - MoviesCatalog</title>
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

        .register-container {
            max-width: 500px;
            width: 100%;
            position: relative;
            z-index: 1;
            animation: slideIn 0.8s ease;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 45px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.4);
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        .register-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .register-icon {
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

        input[type="text"],
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

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #87ceeb;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 15px rgba(135, 206, 235, 0.4);
            transform: scale(1.02);
        }

        input::placeholder {
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

        /* Password strength indicator */
        .password-strength {
            height: 4px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
            margin-top: 8px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-weak { 
            width: 33%; 
            background: #ff6b6b; 
        }

        .strength-medium { 
            width: 66%; 
            background: #ffd700; 
        }

        .strength-strong { 
            width: 100%; 
            background: #98fb98; 
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

        /* Login link */
        .login-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .login-link span {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.95rem;
        }

        .login-link a {
            color: #ffd700;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .login-link a:hover {
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

        /* Helper text */
        .helper-text {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.5);
            margin-top: 5px;
            font-style: italic;
        }

        @media (max-width: 768px) {
            .register-card {
                padding: 30px 25px;
            }

            h1 {
                font-size: 2rem;
            }

            .register-icon {
                font-size: 3rem;
            }
        }
    </style>
</head>
<body>
    <!-- Partículas de fondo -->
    <div class="particles" id="particles"></div>

    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <div class="register-icon">🎬</div>
                <h1>Únete a Nosotros</h1>
                <p class="subtitle">Crea tu cuenta en MoviesCatalog</p>
            </div>

            <form method="POST" action="<?php echo e(route('register')); ?>">
                <?php echo csrf_field(); ?>

                <!-- Name -->
                <div class="form-group">
                    <label for="name">👤 Nombre completo</label>
                    <input id="name" 
                           type="text" 
                           name="name" 
                           value="<?php echo e(old('name')); ?>" 
                           placeholder="Tu nombre"
                           required 
                           autofocus 
                           autocomplete="name">
                    <?php $__errorArgs = ['name'];
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

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">📧 Correo Electrónico</label>
                    <input id="email" 
                           type="email" 
                           name="email" 
                           value="<?php echo e(old('email')); ?>" 
                           placeholder="tu@email.com"
                           required 
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
                    <div class="helper-text">Usaremos este correo para tu cuenta</div>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">🔒 Contraseña</label>
                    <input id="password" 
                           type="password" 
                           name="password" 
                           placeholder="Mínimo 8 caracteres"
                           required 
                           autocomplete="new-password">
                    <div class="password-strength">
                        <div class="password-strength-bar" id="strengthBar"></div>
                    </div>
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
                    <div class="helper-text">Usa letras, números y símbolos para mayor seguridad</div>
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation">🔐 Confirmar Contraseña</label>
                    <input id="password_confirmation" 
                           type="password" 
                           name="password_confirmation" 
                           placeholder="Repite tu contraseña"
                           required 
                           autocomplete="new-password">
                    <?php $__errorArgs = ['password_confirmation'];
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

                <button type="submit" class="btn btn-primary">
                    <span>🚀 Crear Cuenta</span>
                </button>

                <!-- Login Link -->
                <div class="login-link">
                    <span>¿Ya tienes cuenta?</span>
                    <a href="<?php echo e(route('login')); ?>">Inicia sesión aquí</a>
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
        const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]');
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

        // Indicador de fortaleza de contraseña
        const passwordInput = document.getElementById('password');
        const strengthBar = document.getElementById('strengthBar');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;

            // Criterios de fortaleza
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]+/)) strength++;
            if (password.match(/[A-Z]+/)) strength++;
            if (password.match(/[0-9]+/)) strength++;
            if (password.match(/[$@#&!]+/)) strength++;

            // Actualizar barra visual
            strengthBar.className = 'password-strength-bar';
            
            if (strength <= 2) {
                strengthBar.classList.add('strength-weak');
            } else if (strength <= 4) {
                strengthBar.classList.add('strength-medium');
            } else {
                strengthBar.classList.add('strength-strong');
            }

            if (password.length === 0) {
                strengthBar.style.width = '0';
                strengthBar.className = 'password-strength-bar';
            }
        });

        // Validación de coincidencia de contraseñas
        const confirmPassword = document.getElementById('password_confirmation');
        
        confirmPassword.addEventListener('input', function() {
            if (this.value === passwordInput.value && this.value !== '') {
                this.style.borderColor = '#98fb98';
            } else if (this.value !== '') {
                this.style.borderColor = '#ff6b6b';
            }
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
</html><?php /**PATH C:\backup\cine_laravel\resources\views/auth/register.blade.php ENDPATH**/ ?>