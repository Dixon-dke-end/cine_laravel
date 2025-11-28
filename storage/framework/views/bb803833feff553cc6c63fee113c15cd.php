<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Promociones</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/admin_index.css', 'resources/js/app.js']); ?>
    <style>
        /* Reutilizando estilos de movies/index.blade.php */
        body { display: flex; flex-direction: column; }
        .main-container { display: flex; margin-top: 70px; min-height: calc(100vh - 70px); }
        .sidebar { width: 280px; background: rgba(22, 33, 62, 0.95); padding: 2rem 0; border-right: 2px solid #00d4ff; overflow-y: auto; max-height: calc(100vh - 70px); position: fixed; left: 0; top: 70px; height: calc(100vh - 70px); z-index: 900; }
        .sidebar-title { padding: 1rem 1.5rem; font-size: 0.9rem; color: #00d4ff; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid rgba(0, 212, 255, 0.2); margin-bottom: 0.5rem; }
        .accordion-item { border-bottom: 1px solid rgba(0, 212, 255, 0.1); }
        .accordion-header { padding: 1rem 1.5rem; background: none; border: none; color: #fff; cursor: pointer; font-size: 0.95rem; width: 100%; text-align: left; display: flex; justify-content: space-between; align-items: center; transition: all 0.3s ease; font-weight: 500; }
        .accordion-header:hover { background: rgba(0, 212, 255, 0.1); padding-left: 1.8rem; }
        .accordion-header.active { color: #00d4ff; background: rgba(0, 212, 255, 0.15); }
        .accordion-icon { transition: transform 0.3s ease; font-size: 1.1rem; }
        .accordion-header.active .accordion-icon { transform: rotate(180deg); }
        .accordion-content { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; }
        .accordion-content.active { max-height: 500px; }
        .accordion-links { padding: 0.5rem 0; }
        .accordion-link { display: block; padding: 0.8rem 2rem; color: #b0b0b0; text-decoration: none; transition: all 0.3s ease; border-left: 3px solid transparent; font-size: 0.9rem; }
        .accordion-link:hover { color: #00d4ff; background: rgba(0, 212, 255, 0.1); border-left-color: #00d4ff; padding-left: 2.3rem; }
        .content-wrapper { margin-left: 280px; flex: 1; width: calc(100% - 280px); padding: 2rem; }
        .navbar { position: fixed; width: 100%; top: 0; z-index: 1000; }
        .navbar-user { display: flex; align-items: center; gap: 1rem; }
        
        /* Estilos específicos para la tabla de promociones */
        .promociones-table { width: 100%; border-collapse: collapse; margin-top: 2rem; background: rgba(22, 33, 62, 0.8); border-radius: 10px; overflow: hidden; }
        .promociones-table th, .promociones-table td { padding: 1rem; text-align: left; border-bottom: 1px solid rgba(0, 212, 255, 0.1); color: #fff; }
        .promociones-table th { background: rgba(0, 212, 255, 0.1); color: #00d4ff; font-weight: bold; }
        .promociones-table tr:hover { background: rgba(0, 212, 255, 0.05); }
        .btn-action { padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none; font-size: 0.9rem; margin-right: 0.5rem; display: inline-block; }
        .btn-edit { background: #ffc107; color: #000; }
        .btn-delete { background: #dc3545; color: #fff; border: none; cursor: pointer; }
        .btn-add-promo { background: #28a745; color: #fff; padding: 0.8rem 1.5rem; border-radius: 5px; text-decoration: none; display: inline-block; margin-bottom: 1rem; font-weight: bold; }
        
        @media (max-width: 768px) {
            .sidebar { width: 250px; }
            .content-wrapper { margin-left: 250px; width: calc(100% - 250px); }
        }
        @media (max-width: 600px) {
            .sidebar { display: none; }
            .content-wrapper { margin-left: 0; width: 100%; }
            .main-container { margin-top: 0; }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="<?php echo e(route('movies.index')); ?>" class="navbar-brand">🎬 CineVel (Admin)</a>
            <div class="navbar-user">
                <div class="user-info">
                    <div class="user-avatar">
                        <?php if(auth()->guard()->check()): ?> <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?> <?php else: ?> I <?php endif; ?>
                    </div>
                    <span class="user-name">
                        <?php if(auth()->guard()->check()): ?> <?php echo e(Auth::user()->name); ?> <?php else: ?> Invitado <?php endif; ?>
                    </span>
                </div>
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('dashboard')); ?>" class="btn-dashboard">📊 Dashboard</a>
                    <form method="POST" action="<?php echo e(route('logout')); ?>" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn-logout">🚪 Cerrar Sesión</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-title">Menú Principal</div>
            <?php if(auth()->guard()->check()): ?>
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>🎬 Películas</span><span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="<?php echo e(route('movies.index')); ?>" class="accordion-link">📋 Ver Todas</a>
                            <a href="<?php echo e(route('movies.create')); ?>" class="accordion-link">➕ Agregar Nueva</a>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>📅 Funciones</span><span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="<?php echo e(route('funciones.index')); ?>" class="accordion-link">📋 Ver Funciones</a>
                            <a href="<?php echo e(route('funciones.create')); ?>" class="accordion-link">➕ Agregar Función</a>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>Confiteria</span><span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="<?php echo e(route('confiteria.index')); ?>" class="accordion-link">📋 Ver Confiteria</a>
                            <a href="<?php echo e(route('confiteria.create')); ?>" class="accordion-link">➕ Agregar Confiteria</a>
                        </div>
                    </div>
                </div>
                <!-- Sección Promociones (Active) -->
                <div class="accordion-item">
                    <button class="accordion-header active" onclick="toggleAccordion(this)">
                        <span>🏷️ Promociones</span><span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content active">
                        <div class="accordion-links">
                            <a href="<?php echo e(route('promociones.index')); ?>" class="accordion-link" style="color: #00d4ff; border-left-color: #00d4ff; background: rgba(0, 212, 255, 0.1);">📋 Ver Promociones</a>
                            <a href="<?php echo e(route('promociones.create')); ?>" class="accordion-link">➕ Agregar Promoción</a>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>🎥 Próximamente</span><span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="<?php echo e(route('proximamente.admin')); ?>" class="accordion-link">📋 Próximos Estrenos</a>
                            <a href="<?php echo e(route('proximamente.create')); ?>" class="accordion-link">➕ Agregar Película</a>
                        </div>
                    </div>
                </div>
                <?php if(Auth::user()->role === 'admin'): ?>
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>👥 Usuarios</span><span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="<?php echo e(route('user.index')); ?>" class="accordion-link">👤 Vista Usuario</a>
                            <a href="<?php echo e(route('user.index')); ?>" class="accordion-link">👨‍💼 Gestionar</a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </aside>

        <div class="content-wrapper">
            <h1>🏷️ Gestión de Promociones</h1>
            
            <?php if(session('success')): ?>
                <div style="background: rgba(40, 167, 69, 0.2); color: #28a745; padding: 1rem; border-radius: 5px; margin-bottom: 1rem; border: 1px solid #28a745;">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <a href="<?php echo e(route('promociones.create')); ?>" class="btn-add-promo">➕ Nueva Promoción</a>

            <?php if($promociones->isEmpty()): ?>
                <p style="color: #b0b0b0; margin-top: 2rem;">No hay promociones registradas.</p>
            <?php else: ?>
                <table class="promociones-table">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Código</th>
                            <th>Descuento</th>
                            <th>Vigencia</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $promociones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($promo->titulo); ?></td>
                                <td><?php echo e($promo->codigo ?? 'N/A'); ?></td>
                                <td><?php echo e($promo->descuento ? $promo->descuento . '%' : 'N/A'); ?></td>
                                <td><?php echo e($promo->fecha_inicio); ?> - <?php echo e($promo->fecha_fin); ?></td>
                                <td>
                                    <?php if($promo->activo): ?>
                                        <span style="color: #28a745;">Activo</span>
                                    <?php else: ?>
                                        <span style="color: #dc3545;">Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('promociones.edit', $promo->id)); ?>" class="btn-action btn-edit">✏️ Editar</a>
                                    <form action="<?php echo e(route('promociones.destroy', $promo->id)); ?>" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar esta promoción?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn-action btn-delete">🗑️ Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function toggleAccordion(header) {
            const content = header.nextElementSibling;
            document.querySelectorAll('.accordion-header').forEach(h => {
                if (h !== header) {
                    h.classList.remove('active');
                    h.nextElementSibling.classList.remove('active');
                }
            });
            header.classList.toggle('active');
            content.classList.toggle('active');
        }
    </script>
</body>
</html>
<?php /**PATH C:\Users\Dixon\Desktop\cine_laravel\resources\views/promociones/index.blade.php ENDPATH**/ ?>