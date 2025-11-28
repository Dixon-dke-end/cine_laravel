<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Promoción</title>
    @vite(['resources/css/admin_index.css', 'resources/js/app.js'])
    <style>
        /* Reutilizando estilos */
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
        
        /* Estilos del formulario */
        .form-container { background: rgba(22, 33, 62, 0.8); padding: 2rem; border-radius: 10px; max-width: 800px; margin: 0 auto; }
        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; color: #00d4ff; margin-bottom: 0.5rem; font-weight: bold; }
        .form-control { width: 100%; padding: 0.8rem; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(0, 212, 255, 0.3); color: #fff; border-radius: 5px; }
        .form-control:focus { outline: none; border-color: #00d4ff; box-shadow: 0 0 5px rgba(0, 212, 255, 0.5); }
        .btn-submit { background: #00d4ff; color: #000; padding: 1rem 2rem; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; width: 100%; font-size: 1rem; transition: background 0.3s; }
        .btn-submit:hover { background: #00a0c0; }
        .text-danger { color: #dc3545; font-size: 0.85rem; margin-top: 0.25rem; }
        
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
            <a href="{{ route('movies.index') }}" class="navbar-brand">🎬 CineVel (Admin)</a>
            <div class="navbar-user">
                <div class="user-info">
                    <div class="user-avatar">
                        @auth {{ strtoupper(substr(Auth::user()->name, 0, 1)) }} @else I @endauth
                    </div>
                    <span class="user-name">
                        @auth {{ Auth::user()->name }} @else Invitado @endauth
                    </span>
                </div>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-dashboard">📊 Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-logout">🚪 Cerrar Sesión</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <div class="main-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-title">Menú Principal</div>
            @auth
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>🎬 Películas</span><span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="{{ route('movies.index') }}" class="accordion-link">📋 Ver Todas</a>
                            <a href="{{ route('movies.create') }}" class="accordion-link">➕ Agregar Nueva</a>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>📅 Funciones</span><span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="{{ route('funciones.index') }}" class="accordion-link">📋 Ver Funciones</a>
                            <a href="{{ route('funciones.create') }}" class="accordion-link">➕ Agregar Función</a>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>Confiteria</span><span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="{{ route('confiteria.index') }}" class="accordion-link">📋 Ver Confiteria</a>
                            <a href="{{ route('confiteria.create') }}" class="accordion-link">➕ Agregar Confiteria</a>
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
                            <a href="{{ route('promociones.index') }}" class="accordion-link">📋 Ver Promociones</a>
                            <a href="{{ route('promociones.create') }}" class="accordion-link" style="color: #00d4ff; border-left-color: #00d4ff; background: rgba(0, 212, 255, 0.1);">➕ Agregar Promoción</a>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>🎥 Próximamente</span><span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="{{ route('proximamente.admin') }}" class="accordion-link">📋 Próximos Estrenos</a>
                            <a href="{{ route('proximamente.create') }}" class="accordion-link">➕ Agregar Película</a>
                        </div>
                    </div>
                </div>
                @if(Auth::user()->role === 'admin')
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>👥 Usuarios</span><span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="{{ route('user.index') }}" class="accordion-link">👤 Vista Usuario</a>
                            <a href="{{ route('user.index') }}" class="accordion-link">👨‍💼 Gestionar</a>
                        </div>
                    </div>
                </div>
                @endif
            @endauth
        </aside>

        <div class="content-wrapper">
            <h1>➕ Nueva Promoción</h1>
            
            <div class="form-container">
                <form action="{{ route('promociones.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-group">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo') }}" required>
                        @error('titulo') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="4" required>{{ old('descripcion') }}</textarea>
                        @error('descripcion') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select name="tipo" id="tipo" class="form-control" required>
                            <option value="general" {{ old('tipo') == 'general' ? 'selected' : '' }}>General</option>
                            <option value="descuento" {{ old('tipo') == 'descuento' ? 'selected' : '' }}>Descuento</option>
                            <option value="boleteria" {{ old('tipo') == 'boleteria' ? 'selected' : '' }}>Boleteria</option>
                            <option value="promociones" {{ old('tipo') == 'promociones' ? 'selected' : '' }}>Promociones</option>
                            <option value="confiteria" {{ old('tipo') == 'confiteria' ? 'selected' : '' }}>Confiteria</option>
                            <option value="combos" {{ old('tipo') == 'combos' ? 'selected' : '' }}>Combos</option>

                        </select>
                        @error('tipo') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="codigo" class="form-label">Código (Opcional)</label>
                        <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo') }}">
                        @error('codigo') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="descuento" class="form-label">Descuento (%)</label>
                        <input type="number" step="0.01" name="descuento" id="descuento" class="form-control" value="{{ old('descuento') }}">
                        @error('descuento') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ old('fecha_inicio') }}" required>
                        @error('fecha_inicio') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="fecha_fin" class="form-label">Fecha Fin</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ old('fecha_fin') }}" required>
                        @error('fecha_fin') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="imagen" class="form-label">Imagen</label>
                        <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
                        @error('imagen') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="activo" class="form-label">Estado</label>
                        <select name="activo" id="activo" class="form-control" required>
                            <option value="1" {{ old('activo', 1) == 1 ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('activo') == 0 ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('activo') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn-submit">Guardar Promoción</button>
                </form>
            </div>
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
