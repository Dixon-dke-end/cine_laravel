<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Película</title>
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
        }

        .header {
            text-align: center;
            margin-bottom: 35px;
        }

        h1 {
            font-size: 2.5rem;
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
        }

        input[type="file"]::file-selector-button:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.5);
        }

        .image-preview {
            margin-top: 15px;
            text-align: center;
            padding: 20px;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 15px;
            border: 2px dashed rgba(255, 255, 255, 0.3);
        }

        .image-preview p {
            margin-bottom: 15px;
            font-weight: bold;
            color: #87ceeb;
        }

        .image-preview img {
            max-width: 100%;
            height: auto;
            max-height: 300px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s ease;
        }

        .image-preview img:hover {
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

        .btn-secondary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.6);
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
                <h1>✏️ Editar Película</h1>
                <p class="subtitle">Actualiza la información de tu película</p>
            </div>

            <form action="{{ route('movies.update', $registro->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="titulo">📝 Título</label>
                    <input type="text" id="titulo" name="titulo" value="{{ $registro->titulo }}" required>
                </div>

                <div class="form-group">
                    <label for="descripcion">📄 Descripción</label>
                    <textarea id="descripcion" name="descripcion">{{ $registro->descripcion }}</textarea>
                </div>

                <div class="form-group">
                    <label for="duracion">⏱️ Duración (minutos)</label>
                    <input type="number" id="duracion" name="duracion" value="{{ $registro->duracion }}">
                </div>

                <div class="form-group">
                    <label for="año">📅 Año</label>
                    <input type="number" id="año" name="año" value="{{ $registro->año }}">
                </div>

                <div class="form-group">
                    <label for="autor">🎬 Director / Autor</label>
                    <input type="text" id="autor" name="autor" value="{{ $registro->autor }}">
                </div>

                @if($registro->ruta_imagen)
                <div class="form-group">
                    <label>🖼️ Imagen actual</label>
                    <div class="image-preview">
                        <p>Vista previa de la imagen actual</p>
                        <img src="{{ asset('storage/' . $registro->ruta_imagen) }}" 
                             alt="Imagen de {{ $registro->titulo }}">
                    </div>
                </div>
                @endif

                <div class="form-group">
                    <label for="imagen">📷 Cambiar imagen</label>
                    <input type="file" name="imagen" id="imagen" accept="image/*">
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <span>💾 Actualizar Película</span>
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
        document.getElementById('imagen').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const existingPreview = document.querySelector('.image-preview');
                    if (!existingPreview) {
                        const preview = document.createElement('div');
                        preview.className = 'image-preview';
                        preview.innerHTML = `
                            <p>Vista previa de la nueva imagen</p>
                            <img src="${event.target.result}" alt="Nueva imagen">
                        `;
                        document.getElementById('imagen').parentElement.appendChild(preview);
                    } else {
                        existingPreview.querySelector('img').src = event.target.result;
                        existingPreview.querySelector('p').textContent = 'Vista previa de la nueva imagen';
                    }
                };
                reader.readAsDataURL(file);
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

        // Validación visual
        const inputs = document.querySelectorAll('input, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim() !== '') {
                    this.style.borderColor = '#98fb98';
                } else if (this.hasAttribute('required')) {
                    this.style.borderColor = '#ff6b6b';
                }
            });

            input.addEventListener('focus', function() {
                this.style.borderColor = '#87ceeb';
            });
        });
    </script>
</body>
</html>