<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes Mensuales - CineVel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f1419 0%, #1a2942 100%);
            color: #fff;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* NAVBAR */
        .navbar {
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            background: rgba(22, 33, 62, 0.98);
            border-bottom: 2px solid #00d4ff;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
        }

        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            gap: 2rem;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #00d4ff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            color: #fff;
            text-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #000;
        }

        /* MAIN CONTAINER */
        .main-container {
            display: flex;
            margin-top: 70px;
            min-height: calc(100vh - 70px);
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            left: 0;
            top: 70px;
            width: 280px;
            height: calc(100vh - 70px);
            background: rgba(22, 33, 62, 0.95);
            border-right: 2px solid #00d4ff;
            padding: 2rem 0;
            overflow-y: auto;
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

        /* CONTENT WRAPPER */
        .content-wrapper {
            margin-left: 280px;
            flex: 1;
            width: calc(100% - 280px);
            padding: 2rem;
            overflow-y: auto;
        }

        .content {
            max-width: 1400px;
            margin: 0 auto;
        }

        .content h1 {
            margin-bottom: 2rem;
            color: #00d4ff;
            font-size: 2.2rem;
        }

        /* FORM SECTION */
        .form-section {
            background: rgba(0, 212, 255, 0.05);
            border: 2px solid rgba(0, 212, 255, 0.2);
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .form-section h2 {
            color: #00d4ff;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 1rem;
            align-items: end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-group label {
            font-weight: 600;
            color: #00d4ff;
            font-size: 0.95rem;
        }

        .form-group select {
            padding: 0.8rem;
            background: rgba(0, 212, 255, 0.1);
            border: 2px solid rgba(0, 212, 255, 0.3);
            border-radius: 8px;
            color: #fff;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group select:focus {
            outline: none;
            border-color: #00d4ff;
            background: rgba(0, 212, 255, 0.15);
        }

        .form-group select option {
            background: #16213e;
            color: #fff;
        }

        .btn-generate {
            padding: 0.8rem 2rem;
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            color: #000;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-generate:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 212, 255, 0.3);
        }

        .btn-export-pdf {
            padding: 0.8rem 2rem;
            background: linear-gradient(135deg, #00d4ff, #0099cc);
            color: #000;
            border: 2px solid #00d4ff;
            border-radius: 8px;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-top: 1rem;
        }

        .btn-export-pdf:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 212, 255, 0.3);
            background: linear-gradient(135deg, #00b8e6, #007ba3);
        }

        /* REPORT SECTION */
        .report-header {
            text-align: center;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: rgba(0, 212, 255, 0.05);
            border: 2px solid rgba(0, 212, 255, 0.2);
            border-radius: 12px;
        }

        .report-header h2 {
            color: #00d4ff;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .report-header p {
            color: #b0b0b0;
            font-size: 1.1rem;
        }

        /* SUMMARY CARDS */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .summary-card {
            background: rgba(0, 212, 255, 0.05);
            border: 2px solid rgba(0, 212, 255, 0.2);
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .summary-card:hover {
            border-color: #00d4ff;
            box-shadow: 0 5px 15px rgba(0, 212, 255, 0.2);
            transform: translateY(-5px);
        }

        .summary-card-icon {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .summary-card-label {
            color: #b0b0b0;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .summary-card-value {
            color: #00d4ff;
            font-size: 2rem;
            font-weight: bold;
        }

        /* TABLES */
        .table-section {
            margin-bottom: 2rem;
        }

        .table-section h3 {
            color: #00d4ff;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        table {
            width: 100%;
            background: rgba(0, 212, 255, 0.05);
            border: 2px solid rgba(0, 212, 255, 0.2);
            border-radius: 12px;
            border-collapse: collapse;
            overflow: hidden;
        }

        thead {
            background: rgba(0, 212, 255, 0.2);
        }

        thead th {
            padding: 1rem;
            color: #00d4ff;
            font-weight: bold;
            text-align: left;
            font-size: 1rem;
        }

        tbody tr {
            border-bottom: 1px solid rgba(0, 212, 255, 0.1);
            transition: all 0.3s ease;
        }

        tbody tr:hover {
            background: rgba(0, 212, 255, 0.1);
        }

        tbody td {
            padding: 1rem;
            color: #fff;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .no-data {
            text-align: center;
            padding: 3rem 2rem;
            color: #b0b0b0;
            font-size: 1.1rem;
        }

        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            background: rgba(0, 212, 255, 0.1);
            border-radius: 12px;
            border: 2px dashed #00d4ff;
            margin-top: 2rem;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #00d4ff;
        }

        .empty-state p {
            font-size: 1rem;
            color: #b0b0b0;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .content-wrapper {
                margin-left: 0;
                width: 100%;
                padding: 1rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .summary-grid {
                grid-template-columns: 1fr;
            }

            table {
                font-size: 0.85rem;
            }

            thead th, tbody td {
                padding: 0.6rem;
            }
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('movies.index') }}" class="navbar-brand">
                📊 CineVel - Reportes
            </a>
            
            <div class="navbar-user">
                <div class="user-info">
                    <div class="user-avatar">
                        @auth
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        @else
                            I
                        @endauth
                    </div>
                    <span>{{ Auth::user()->name ?? 'Invitado' }}</span>
                </div>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTAINER -->
    <div class="main-container">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-title">Menú Principal</div>

            @auth
                <!-- Sección Películas -->
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>🎬 Películas</span>
                        <span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="{{ route('movies.index') }}" class="accordion-link">📋 Ver Todas</a>
                            <a href="{{ route('movies.create') }}" class="accordion-link">➕ Agregar Nueva</a>
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
                            <a href="{{ route('funciones.index') }}" class="accordion-link">📋 Ver Funciones</a>
                            <a href="{{ route('funciones.create') }}" class="accordion-link">➕ Agregar Función</a>
                        </div>
                    </div>
                </div>

                <!-- Sección Confitería -->
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>🍿 Confitería</span>
                        <span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="{{ route('confiteria.index') }}" class="accordion-link">📋 Ver Confitería</a>
                            <a href="{{ route('confiteria.create') }}" class="accordion-link">➕ Agregar Confitería</a>
                        </div>
                    </div>
                </div>

                <!-- Sección Promociones -->
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>🏷️ Promociones</span>
                        <span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="{{ route('promociones.index') }}" class="accordion-link">📋 Ver Promociones</a>
                            <a href="{{ route('promociones.create') }}" class="accordion-link">➕ Agregar Promoción</a>
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
                            <a href="{{ route('proximamente.admin') }}" class="accordion-link">📋 Próximos Estrenos</a>
                            <a href="{{ route('proximamente.create') }}" class="accordion-link">➕ Agregar Película</a>
                        </div>
                    </div>
                </div>

                <!-- Sección Reportes -->
                <div class="accordion-item">
                    <button class="accordion-header active" onclick="toggleAccordion(this)">
                        <span>📊 Reportes</span>
                        <span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content active">
                        <div class="accordion-links">
                            <a href="{{ route('reportes.index') }}" class="accordion-link">📈 Reporte Mensual</a>
                        </div>
                    </div>
                </div>

                <!-- Sección Usuarios -->
                @if(Auth::user()->role === 'admin')
                <div class="accordion-item">
                    <button class="accordion-header" onclick="toggleAccordion(this)">
                        <span>👥 Usuarios</span>
                        <span class="accordion-icon">▼</span>
                    </button>
                    <div class="accordion-content">
                        <div class="accordion-links">
                            <a href="{{ route('user.index') }}" class="accordion-link">👤 Vista Usuario</a>
                        </div>
                    </div>
                </div>
                @endif
            @endauth
        </aside>

        <!-- CONTENT WRAPPER -->
        <div class="content-wrapper">
            <div class="content">
                <h1>📊 Reportes Mensuales</h1>

                <!-- FORMULARIO DE SELECCIÓN -->
                <div class="form-section">
                    <h2>Seleccionar Período</h2>
                    <form action="{{ route('reportes.generar') }}" method="POST">
                        @csrf
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="mes">Mes</label>
                                <select name="mes" id="mes" required>
                                    <option value="1" {{ (isset($mesActual) && $mesActual == 1) ? 'selected' : '' }}>Enero</option>
                                    <option value="2" {{ (isset($mesActual) && $mesActual == 2) ? 'selected' : '' }}>Febrero</option>
                                    <option value="3" {{ (isset($mesActual) && $mesActual == 3) ? 'selected' : '' }}>Marzo</option>
                                    <option value="4" {{ (isset($mesActual) && $mesActual == 4) ? 'selected' : '' }}>Abril</option>
                                    <option value="5" {{ (isset($mesActual) && $mesActual == 5) ? 'selected' : '' }}>Mayo</option>
                                    <option value="6" {{ (isset($mesActual) && $mesActual == 6) ? 'selected' : '' }}>Junio</option>
                                    <option value="7" {{ (isset($mesActual) && $mesActual == 7) ? 'selected' : '' }}>Julio</option>
                                    <option value="8" {{ (isset($mesActual) && $mesActual == 8) ? 'selected' : '' }}>Agosto</option>
                                    <option value="9" {{ (isset($mesActual) && $mesActual == 9) ? 'selected' : '' }}>Septiembre</option>
                                    <option value="10" {{ (isset($mesActual) && $mesActual == 10) ? 'selected' : '' }}>Octubre</option>
                                    <option value="11" {{ (isset($mesActual) && $mesActual == 11) ? 'selected' : '' }}>Noviembre</option>
                                    <option value="12" {{ (isset($mesActual) && $mesActual == 12) ? 'selected' : '' }}>Diciembre</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="año">Año</label>
                                <select name="año" id="año" required>
                                    <option value="2023" {{ (isset($añoActual) && $añoActual == 2023) ? 'selected' : '' }}>2023</option>
                                    <option value="2024" {{ (isset($añoActual) && $añoActual == 2024) ? 'selected' : '' }}>2024</option>
                                    <option value="2025" {{ (isset($añoActual) && $añoActual == 2025) ? 'selected' : '' }}>2025</option>
                                    <option value="2026" {{ (isset($añoActual) && $añoActual == 2026) ? 'selected' : '' }}>2026</option>
                                </select>
                            </div>

                            <button type="submit" class="btn-generate">🔍 Generar Reporte</button>
                        </div>
                    </form>
                </div>

                <!-- SECCIÓN DE RESULTADOS -->
                @if(isset($reporte))
                    <div class="report-header">
                        <h2>📈 Reporte: {{ $reporte['mes'] }} {{ $reporte['año'] }}</h2>
                        <p>Resumen de actividades y ventas del período seleccionado</p>
                        <a href="{{ route('reportes.exportarPDF', ['mes' => $mesActual, 'año' => $añoActual]) }}" 
                           class="btn-export-pdf">
                            📄 Exportar a PDF
                        </a>
                    </div>

                    <!-- TARJETAS DE RESUMEN -->
                    <div class="summary-grid">
                        <div class="summary-card">
                            <div class="summary-card-icon">🎬</div>
                            <div class="summary-card-label">Películas Exhibidas</div>
                            <div class="summary-card-value">{{ $reporte['resumen']['total_peliculas'] }}</div>
                        </div>

                        <div class="summary-card">
                            <div class="summary-card-icon">📅</div>
                            <div class="summary-card-label">Total de Funciones</div>
                            <div class="summary-card-value">{{ $reporte['resumen']['total_funciones'] }}</div>
                        </div>

                        <div class="summary-card">
                            <div class="summary-card-icon">🎫</div>
                            <div class="summary-card-label">Boletos Vendidos</div>
                            <div class="summary-card-value">{{ $reporte['resumen']['total_boletos'] }}</div>
                        </div>

                        <div class="summary-card">
                            <div class="summary-card-icon">💵</div>
                            <div class="summary-card-label">Ingresos por Boletos</div>
                            <div class="summary-card-value">${{ $reporte['resumen']['ingresos_boletos'] }}</div>
                        </div>

                        <div class="summary-card">
                            <div class="summary-card-icon">🍿</div>
                            <div class="summary-card-label">Ingresos por Confitería</div>
                            <div class="summary-card-value">${{ $reporte['resumen']['ingresos_confiteria'] }}</div>
                        </div>

                        <div class="summary-card">
                            <div class="summary-card-icon">💰</div>
                            <div class="summary-card-label">Ingresos Totales</div>
                            <div class="summary-card-value">${{ $reporte['resumen']['ingresos_totales'] }}</div>
                        </div>
                    </div>

                    <!-- TABLA DE PELÍCULAS -->
                    <div class="table-section">
                        <h3>🎬 Detalles por Película</h3>
                        @if(count($reporte['peliculas']) > 0)
                            <table>
                                <thead>
                                    <tr>
                                        <th>Película</th>
                                        <th class="text-center">Funciones</th>
                                        <th class="text-center">Boletos Vendidos</th>
                                        <th class="text-right">Ingresos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reporte['peliculas'] as $pelicula)
                                        <tr>
                                            <td>{{ $pelicula['titulo'] }}</td>
                                            <td class="text-center">{{ $pelicula['funciones'] }}</td>
                                            <td class="text-center">{{ $pelicula['boletos_vendidos'] }}</td>
                                            <td class="text-right">${{ number_format($pelicula['ingresos'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="no-data">No hay datos de películas para este período</div>
                        @endif
                    </div>

                    <!-- TABLA DE CONFITERÍA -->
                    <div class="table-section">
                        <h3>🍿 Ventas de Confitería</h3>
                        @if(count($reporte['confiteria']) > 0)
                            <table>
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th class="text-center">Cantidad Vendida</th>
                                        <th class="text-right">Ingresos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reporte['confiteria'] as $item)
                                        <tr>
                                            <td>{{ $item['producto'] }}</td>
                                            <td class="text-center">{{ $item['cantidad'] }}</td>
                                            <td class="text-right">${{ number_format($item['ingresos'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="no-data">No hay ventas de confitería para este período</div>
                        @endif
                    </div>
                @else
                    <!-- ESTADO VACÍO -->
                    <div class="empty-state">
                        <h3>📊 Selecciona un período</h3>
                        <p>Usa el formulario arriba para generar un reporte del mes y año que desees consultar</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Toggle Acordeón
        function toggleAccordion(header) {
            const content = header.nextElementSibling;
            const isActive = header.classList.contains('active');

            // Cerrar todos los acordeones
            document.querySelectorAll('.accordion-header').forEach(h => {
                h.classList.remove('active');
                h.nextElementSibling.classList.remove('active');
            });

            // Abrir el seleccionado si no estaba activo
            if (!isActive) {
                header.classList.add('active');
                content.classList.add('active');
            }
        }
    </script>
</body>
</html>
