<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto Confitería</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/admin_create.css', 'resources/js/app.js']); ?>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
            <!-- Logo a la izquierda -->
            <div style="display: flex; align-items: center; gap: 15px;">
                <a href="<?php echo e(route('user.index')); ?>" style="text-decoration: none; color: #fff; font-weight: bold; font-size: 1.2rem;">
                    🎬 CineVel
                </a>
            </div>
            
            <!-- Centro -->
            <div style="flex: 1; text-align: center;">
                <span style="color: #87CEEB; font-size: 1rem;">Bienvenido, <?php echo e(Auth::user()->name ?? 'Usuario'); ?></span>
            </div>
            
            <!-- Botón a la derecha -->
            <div>
                <form action="<?php echo e(route('logout')); ?>" method="POST" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" style="padding: 8px 20px; border-radius: 20px; background: rgba(255, 107, 107, 0.3); color: #fff; border: none; cursor: pointer; transition: all 0.3s ease;">
                        🚪 Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Partículas de fondo -->
    <div class="particles" id="particles"></div>

    <div class="main-container">
        <!-- Sidebar Acordeón -->
        <aside class="sidebar">
            <div class="sidebar-title">Menú Confitería</div>

            <?php if(auth()->guard()->check()): ?>
                <!-- Sección Confitería -->
                <div class="accordion-item">
                    <button class="accordion-header active" onclick="toggleAccordion(this)">
                        <span>🍿 Confitería</span>
                        <span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content active">
                        <div class="accordion-links">
                            <a href="<?php echo e(route('confiteria.index')); ?>" class="accordion-link">📋 Ver Catálogo</a>
                            <a href="<?php echo e(route('confiteria.create')); ?>" class="accordion-link">➕ Agregar Producto</a>
                        </div>
                    </div>
                </div>

                <!-- Sección Películas -->
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>🎬 Películas</span>
                        <span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="<?php echo e(route('movies.index')); ?>" class="accordion-link">📋 Ver Todas</a>
                            <a href="<?php echo e(route('movies.create')); ?>" class="accordion-link">➕ Agregar Nueva</a>
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
                            <a href="<?php echo e(route('funciones.index')); ?>" class="accordion-link">📋 Ver Funciones</a>
                            <a href="<?php echo e(route('funciones.create')); ?>" class="accordion-link">➕ Agregar Función</a>
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
                            <a href="<?php echo e(route('proximamente.index')); ?>" class="accordion-link">📋 Próximos Estrenos</a>
                            <a href="<?php echo e(route('proximamente.create')); ?>" class="accordion-link">➕ Agregar Película</a>
                        </div>
                    </div>
                </div>

                <!-- Sección Usuarios (Solo Admin) -->
                <?php if(Auth::user()->role === 'admin'): ?>
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>👥 Usuarios</span>
                        <span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="<?php echo e(route('user.index')); ?>" class="accordion-link">👤 Vista Usuario</a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </aside>

        <!-- Contenido Principal -->
        <div class="content-wrapper">
            <div class="container">
                <div class="form-card">
                    <div class="header">
                        <h1>🍿 Crear Producto de Confitería</h1>
                        <p class="subtitle">Añade un nuevo producto al catálogo</p>
                    </div>

                    <!-- Mostrar errores de validación -->
                    <?php if($errors->any()): ?>
                    <div style="background: rgba(255, 107, 107, 0.2); border: 2px solid #FF6B6B; border-radius: 12px; padding: 15px; margin-bottom: 25px;">
                        <h3 style="color: #FF6B6B; margin-bottom: 10px;">❌ Errores en el formulario:</h3>
                        <ul style="color: #FFB0B0; margin-left: 20px;">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('confiteria.store')); ?>" method="POST" enctype="multipart/form-data" id="confiteriaForm">
                        <?php echo csrf_field(); ?>

                        <!-- Nombre del Producto -->
                        <div class="form-group">
                            <label for="nombre" class="required">📝 Nombre del Producto</label>
                            <input type="text" 
                                   id="nombre" 
                                   name="nombre" 
                                   placeholder="Ej: Palomitas grandes, Refresco, Combo..." 
                                   value="<?php echo e(old('nombre')); ?>" 
                                   required>
                            <div class="helper-text">El nombre del producto es obligatorio</div>
                        </div>

                        <!-- Descripción -->
                        <div class="form-group">
                            <label for="descripcion">📄 Descripción</label>
                            <textarea id="descripcion" 
                                      name="descripcion" 
                                      placeholder="Descripción del producto..."><?php echo e(old('descripcion')); ?></textarea>
                            <div class="helper-text">Una breve descripción del producto</div>
                        </div>

                        <!-- Precio -->
                        <div class="form-group">
                            <label for="precio" class="required">💵 Precio</label>
                            <input type="number" 
                                   id="precio" 
                                   name="precio" 
                                   placeholder="Ej: 45.50" 
                                   step="0.01"
                                   min="0" 
                                   value="<?php echo e(old('precio')); ?>"
                                   required>
                            <div class="helper-text">Precio del producto en pesos</div>
                        </div>

                        <!-- Stock -->
                        <div class="form-group">
                            <label for="stock" class="required">📦 Stock</label>
                            <input type="number" 
                                   id="stock" 
                                   name="stock" 
                                   placeholder="Ej: 50" 
                                   min="0" 
                                   value="<?php echo e(old('stock', 0)); ?>"
                                   required>
                            <div class="helper-text">Cantidad disponible en inventario</div>
                        </div>

                        <!-- Imagen del Producto -->
                        <div class="form-group">
                            <label for="imagen">📷 Imagen del producto</label>
                            <input type="file" 
                                   id="imagen" 
                                   name="imagen" 
                                   accept="image/*">
                            <div class="helper-text">Selecciona una imagen del producto (JPG, PNG, etc.)</div>
                            <div class="image-preview-area" id="imagePreview">
                                <p>✨ Vista previa de la imagen</p>
                                <img id="previewImg" src="" alt="Preview" style="display: none;">
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="button-group">
                            <button type="submit" class="btn btn-primary">
                                <span>💾 Crear Producto</span>
                            </button>
                            <a href="<?php echo e(route('confiteria.index')); ?>" class="btn btn-secondary">
                                <span>🔙 Volver al Catálogo</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            display: flex;
            flex-direction: column;
        }

        .main-container {
            display: flex;
            margin-top: 70px;
            min-height: calc(100vh - 70px);
        }

        .sidebar {
            width: 280px;
            background: rgba(22, 33, 62, 0.95);
            padding: 2rem 0;
            border-right: 2px solid #00d4ff;
            overflow-y: auto;
            max-height: calc(100vh - 70px);
            position: fixed;
            left: 0;
            top: 70px;
            height: calc(100vh - 70px);
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

        .content-wrapper {
            margin-left: 280px;
            flex: 1;
            width: calc(100% - 280px);
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: static;
                height: auto;
                max-height: none;
            }

            .content-wrapper {
                margin-left: 0;
                width: 100%;
            }

            .main-container {
                flex-direction: column;
            }
        }
    </style>

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
            if (!particlesContainer) return;
            
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
            const previewArea = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewImg.src = event.target.result;
                    previewImg.style.display = 'block';
                    previewArea.classList.add('active');
                };
                reader.readAsDataURL(file);
            } else {
                previewArea.classList.remove('active');
                previewImg.style.display = 'none';
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

        // Confirmación antes de enviar
        document.getElementById('confiteriaForm').addEventListener('submit', function(e) {
            const nombre = document.getElementById('nombre').value.trim();
            const precio = document.getElementById('precio').value.trim();
            
            if (!nombre) {
                e.preventDefault();
                alert('⚠️ Por favor ingresa un nombre para el producto');
                document.getElementById('nombre').focus();
                return false;
            }
            
            if (!precio || parseFloat(precio) < 0) {
                e.preventDefault();
                alert('⚠️ Por favor ingresa un precio válido');
                document.getElementById('precio').focus();
                return false;
            }
        });
    </script>
</body>
</html><?php /**PATH C:\Users\Dixon\Desktop\cine_laravel\resources\views/confiteria/create.blade.php ENDPATH**/ ?>