<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Película</title>
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
            padding: 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
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

        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }

        .container {
            max-width: 700px;
            width: 100%;
            position: relative;
            z-index: 1;
            animation: slideIn 0.8s ease;
        }

        .form-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.4);
            border: 2px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .form-card::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #667eea, #764ba2, #f093fb, #f5576c);
            border-radius: 25px;
            opacity: 0;
            z-index: -1;
            animation: rotate-gradient 3s linear infinite;
            transition: opacity 0.3s;
        }

        .form-card:hover::before {
            opacity: 0.3;
        }

        @keyframes rotate-gradient {
            0% { filter: hue-rotate(0deg); }
            100% { filter: hue-rotate(360deg); }
        }

        .header {
            text-align: center;
            margin-bottom: 35px;
        }

        h1 {
            font-size: 2.8rem;
            font-weight: bold;
            background: linear-gradient(45deg, #fff, #87ceeb, #ffd700);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: glow 2s ease-in-out infinite alternate;
            margin-bottom: 10px;
        }

        .subtitle {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.8);
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
        input[type="number"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 12px 16px;
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
        input[type="number"]:focus,
        textarea:focus {
            outline: none;
            border-color: #87ceeb;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 15px rgba(135, 206, 235, 0.4);
            transform: scale(1.02);
        }

        input[type="text"]::placeholder,
        input[type="number"]::placeholder,
        textarea::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        input[type="file"] {
            cursor: pointer;
            padding: 10px;
        }

        input[type="file"]::file-selector-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
            margin-right: 10px;
        }

        input[type="file"]::file-selector-button:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.5);
        }

        .image-preview-area {
            display: none;
            margin-top: 15px;
            padding: 20px;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 15px;
            border: 2px dashed rgba(255, 255, 255, 0.3);
            text-align: center;
        }

        .image-preview-area.active {
            display: block;
            animation: slideIn 0.5s ease;
        }

        .image-preview-area p {
            margin-bottom: 15px;
            font-weight: bold;
            color: #87ceeb;
        }

        .image-preview-area img {
            max-width: 100%;
            height: auto;
            max-height: 300px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s ease;
        }

        .image-preview-area img:hover {
            transform: scale(1.05);
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 35px;
        }

        .btn {
            flex: 1;
            padding: 14px 24px;
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
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(245, 87, 108, 0.6);
        }

        .btn-primary:active {
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.6);
        }

        .required::after {
            content: ' *';
            color: #ff6b6b;
        }

        .helper-text {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.6);
            margin-top: 5px;
            font-style: italic;
        }

        @media (max-width: 768px) {
            .form-card {
                padding: 25px;
            }

            h1 {
                font-size: 2rem;
            }

            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Partículas de fondo -->
    <div class="particles" id="particles"></div>

    <div class="container">
        <div class="form-card">
            <div class="header">
                <h1>🎬 Crear Nueva Película</h1>
                <p class="subtitle">Añade una película al catálogo</p>
            </div>

            <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="titulo" class="required">📝 Título</label>
                    <input type="text" 
                           id="titulo" 
                           name="titulo" 
                           placeholder="Ej: Inception, Interstellar..." 
                           value="{{ old('titulo') }}" 
                           required>
                    <div class="helper-text">El título de la película es obligatorio</div>
                </div>

                <div class="form-group">
                    <label for="descripcion">📄 Descripción</label>
                    <textarea id="descripcion" 
                              name="descripcion" 
                              placeholder="Escribe una breve sinopsis de la película...">{{ old('descripcion') }}</textarea>
                    <div class="helper-text">Una breve descripción de la trama</div>
                </div>

                <div class="form-group">
                    <label for="duracion">⏱️ Duración (minutos)</label>
                    <input type="number" 
                           id="duracion" 
                           name="duracion" 
                           placeholder="Ej: 148" 
                           min="1" 
                           value="{{ old('duracion') }}">
                    <div class="helper-text">Duración total en minutos</div>
                </div>

                <div class="form-group">
                    <label for="año">📅 Año</label>
                    <input type="number" 
                           id="año" 
                           name="año" 
                           placeholder="Ej: 2024" 
                           min="1888" 
                           max="2100" 
                           value="{{ old('año') }}">
                    <div class="helper-text">Año de estreno de la película</div>
                </div>

                <div class="form-group">
                    <label for="autor">🎬 Director / Autor</label>
                    <input type="text" 
                           id="autor" 
                           name="autor" 
                           placeholder="Ej: Christopher Nolan" 
                           value="{{ old('autor') }}">
                    <div class="helper-text">Nombre del director o autor principal</div>
                </div>

                <div class="form-group">
                    <label for="ruta_imagen">📷 Imagen de la película</label>
                    <input type="file" 
                           id="ruta_imagen" 
                           name="ruta_imagen" 
                           accept="image/*">
                    <div class="helper-text">Selecciona una imagen representativa (JPG, PNG, etc.)</div>
                    <div class="image-preview-area" id="imagePreview">
                        <p>✨ Vista previa de la imagen</p>
                        <img id="previewImg" src="" alt="Preview">
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <span>💾 Crear Película</span>
                    </button>
                    <a href="{{ route('movies.index') }}" class="btn btn-secondary">
                        <span>🔙 Volver al Catálogo</span>
                    </a>
                </div>
            </form>
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

        // Preview de imagen al seleccionar archivo
        document.getElementById('ruta_imagen').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const previewArea = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewImg.src = event.target.result;
                    previewArea.classList.add('active');
                };
                reader.readAsDataURL(file);
            } else {
                previewArea.classList.remove('active');
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

        // Validación visual en tiempo real
        const inputs = document.querySelectorAll('input[type="text"], input[type="number"], textarea');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.trim() !== '') {
                    this.style.borderColor = '#98fb98';
                } else if (this.hasAttribute('required')) {
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

        // Animación de shake para campos requeridos vacíos
        const style = document.createElement('style');
        style.textContent = `
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-10px); }
                75% { transform: translateX(10px); }
            }
        `;
        document.head.appendChild(style);

        // Confirmación antes de enviar
        document.querySelector('form').addEventListener('submit', function(e) {
            const titulo = document.getElementById('titulo').value.trim();
            if (!titulo) {
                e.preventDefault();
                alert('⚠️ Por favor ingresa un título para la película');
                document.getElementById('titulo').focus();
                return false;
            }
        });
    </script>
</body>
</html>