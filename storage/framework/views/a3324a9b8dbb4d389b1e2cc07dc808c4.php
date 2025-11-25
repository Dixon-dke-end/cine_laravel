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
    <nav class="navbar" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(20px); padding: 15px 0; border-bottom: 2px solid rgba(255, 255, 255, 0.1); position: sticky; top: 0; z-index: 1000;">
        <div style="max-width: 1400px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center; gap: 20px;">
            <a href="<?php echo e(route('confiteria.index')); ?>" style="display: flex; align-items: center; gap: 10px; font-size: 1.5rem; font-weight: bold; color: #fff; text-decoration: none; transition: all 0.3s ease;">
                🍿 Confitería (Admin)
            </a>
            
            <div style="display: flex; align-items: center; gap: 15px;">
                <?php if(auth()->guard()->check()): ?>
                    <?php if(Auth::user()->role === 'admin'): ?>
                        <a href="<?php echo e(route('user.index')); ?>" style="padding: 8px 20px; border-radius: 20px; text-decoration: none; background: rgba(255, 255, 255, 0.2); color: #fff; transition: all 0.3s ease;" title="Ver vista de usuario">
                            👤 Vista Usuario
                        </a>
                    <?php endif; ?>
                    
                    <a href="<?php echo e(route('dashboard')); ?>" style="padding: 8px 20px; border-radius: 20px; text-decoration: none; background: rgba(255, 255, 255, 0.2); color: #fff; transition: all 0.3s ease;">
                        📊 Dashboard
                    </a>
                    
                    <form method="POST" action="<?php echo e(route('logout')); ?>" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" style="padding: 8px 20px; border-radius: 20px; background: rgba(255, 107, 107, 0.3); color: #fff; border: none; cursor: pointer; transition: all 0.3s ease;">
                            🚪 Cerrar Sesión
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Partículas de fondo -->
    <div class="particles" id="particles"></div>

    <div class="container">
        <div class="form-card">
            <div class="header">
                <h1>🍿 Crear Producto de Confitería</h1>
                <p class="subtitle">Añade un nuevo producto al catálogo</p>
            </div>

            <form action="<?php echo e(route('confiteria.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

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

                <div class="form-group">
                    <label for="descripcion">📄 Descripción</label>
                    <textarea id="descripcion" 
                              name="descripcion" 
                              placeholder="Descripción del producto..."><?php echo e(old('descripcion')); ?></textarea>
                    <div class="helper-text">Una breve descripción del producto</div>
                </div>

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

                <div class="form-group">
                    <label for="imagen">📷 Imagen del producto</label>
                    <input type="file" 
                           id="imagen" 
                           name="imagen" 
                           accept="image/*">
                    <div class="helper-text">Selecciona una imagen del producto (JPG, PNG, etc.)</div>
                    <div class="image-preview-area" id="imagePreview">
                        <p>✨ Vista previa de la imagen</p>
                        <img id="previewImg" src="" alt="Preview">
                    </div>
                </div>

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
</html>
<?php /**PATH C:\Users\Dixon\Desktop\cine_laravel\resources\views/confiteria/create.blade.php ENDPATH**/ ?>