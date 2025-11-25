<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Selecciona tus asientos - {{ $funcion->movies->titulo }}</title>
    <style>* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #333;
    min-height: 100vh;
}

/* Top Bar */
.top-bar {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 10px 0;
    text-align: center;
    font-size: 0.85rem;
    color: #ffd700;
    font-weight: 500;
}

/* Navbar */
.navbar {
    background: rgba(255, 255, 255, 0.98);
    padding: 0;
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
    backdrop-filter: blur(10px);
}

.navbar-container {
    max-width: 1600px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 40px;
}

.navbar-brand {
    font-size: 2.2rem;
    font-weight: bold;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-decoration: none;
}

.navbar-user {
    display: flex;
    align-items: center;
    gap: 15px;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 16px;
    background: rgba(102, 126, 234, 0.08);
    border-radius: 25px;
}

.user-avatar {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: white;
    font-size: 0.9rem;
}

.user-name {
    color: #333;
    font-weight: 600;
    font-size: 0.9rem;
}

.btn-logout {
    padding: 8px 20px;
    border-radius: 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
}

.btn-logout:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.5);
}

/* Progress Bar */
.progress-bar {
    background: rgba(255, 255, 255, 0.95);
    border-bottom: 2px solid rgba(102, 126, 234, 0.2);
    padding: 20px 0;
    box-shadow: 0 2px 10px rgba(102, 126, 234, 0.1);
}

.progress-container {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 40px;
    position: relative;
}

.progress-container::before {
    content: '';
    position: absolute;
    top: 17px;
    left: 60px;
    right: 60px;
    height: 2px;
    background: rgba(102, 126, 234, 0.2);
    z-index: 0;
}

.progress-step {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #999;
    font-size: 0.85rem;
    font-weight: 600;
    position: relative;
    z-index: 1;
}

.progress-step.active {
    color: #667eea;
}

.progress-step.completed {
    color: #4caf50;
}

.step-number {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: white;
    border: 2px solid #e0e4e8;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: #999;
    transition: all 0.3s ease;
}

.progress-step.active .step-number {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: #667eea;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.progress-step.completed .step-number {
    background: #4caf50;
    color: white;
    border-color: #4caf50;
}

/* Main Container */
.main-container {
    max-width: 1600px;
    margin: 40px auto;
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 30px;
    padding: 0 40px;
    min-height: calc(100vh - 250px);
}

/* Left Sidebar */
.left-sidebar {
    background: rgba(255, 255, 255, 0.96);
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.5);
    height: fit-content;
    position: sticky;
    top: 20px;
}

.movie-poster {
    width: 100%;
    border-radius: 15px;
    box-shadow: 0 8px 30px rgba(102, 126, 234, 0.2);
    margin-bottom: 20px;
    aspect-ratio: 2/3;
    object-fit: cover;
    border: 2px solid rgba(102, 126, 234, 0.1);
}

.movie-info {
    margin-bottom: 20px;
}

.info-badge {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: bold;
    margin-bottom: 12px;
    margin-right: 8px;
}

.badge-format {
    background: linear-gradient(135deg, #ff6b6b 0%, #ff8e53 100%);
    color: white;
}

.badge-duration {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.info-item {
    margin-bottom: 12px;
    padding: 10px;
    background: rgba(102, 126, 234, 0.05);
    border-left: 3px solid #667eea;
    border-radius: 6px;
}

.info-label {
    font-size: 0.7rem;
    color: #888;
    text-transform: uppercase;
    margin-bottom: 3px;
    font-weight: 700;
    letter-spacing: 0.5px;
}

.info-value {
    font-size: 0.95rem;
    color: #333;
    font-weight: 600;
}

.timer {
    background: linear-gradient(135deg, #ff6b6b 0%, #ff8e53 100%);
    color: white;
    padding: 18px;
    border-radius: 12px;
    text-align: center;
    margin-top: 20px;
    box-shadow: 0 6px 20px rgba(255, 107, 107, 0.3);
}

.timer-label {
    font-size: 0.8rem;
    opacity: 0.95;
    margin-bottom: 5px;
    font-weight: 600;
}

.timer-value {
    font-size: 1.8rem;
    font-weight: bold;
    letter-spacing: 1px;
}

/* Cinema Hall */
.cinema-hall {
    background: rgba(255, 255, 255, 0.96);
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.5);
    overflow-y: auto;
}

.cinema-header {
    text-align: center;
    margin-bottom: 30px;
}

.cinema-title {
    font-size: 1.6rem;
    font-weight: bold;
    color: #1a1a1a;
    letter-spacing: 1px;
}

.screen {
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    border-radius: 50% 50% 0 0 / 15px 15px 0 0;
    padding: 12px;
    margin: 0 auto 40px;
    max-width: 100%;
    text-align: center;
    font-weight: bold;
    color: white;
    font-size: 1rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    letter-spacing: 2px;
}

/* Seats Grid */
.seats-grid {
    max-width: 100%;
    margin: 0 auto 35px;
}

.seats-row {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 6px;
    margin-bottom: 6px;
}

.row-letter {
    width: 30px;
    font-weight: 600;
    color: #888;
    text-align: center;
    font-size: 0.85rem;
}

.seats-row-content {
    display: flex;
    gap: 6px;
}

.seat {
    width: 30px;
    height: 30px;
    border: 2px solid #e0e4e8;
    border-radius: 5px;
    background: white;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.65rem;
    font-weight: 700;
    color: #666;
}

.seat:hover:not(.occupied):not(.disabled) {
    transform: scale(1.1);
    border-color: #667eea;
    box-shadow: 0 3px 10px rgba(102, 126, 234, 0.3);
}

.seat.available {
    background: white;
    border-color: #4caf50;
}

.seat.selected {
    background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
    border-color: #4caf50;
    color: white;
    transform: scale(1.12);
    box-shadow: 0 4px 15px rgba(76, 175, 80, 0.4);
}

.seat.occupied {
    background: #e8eaed;
    border-color: #ccc;
    cursor: not-allowed;
    opacity: 0.5;
}

.seat.disabled {
    background: #f5f7fa;
    border-color: #f5f7fa;
    cursor: default;
}

.seat.discapacitado {
    border-color: #2196F3;
    background: #e3f2fd;
}

.seat.acompanante {
    border-color: #9c27b0;
    background: #f3e5f5;
}

/* Legend */
.legend {
    display: flex;
    justify-content: center;
    gap: 25px;
    flex-wrap: wrap;
    padding: 20px 25px;
    background: rgba(102, 126, 234, 0.06);
    border: 2px solid rgba(102, 126, 234, 0.15);
    border-radius: 12px;
    margin-top: 20px;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.legend-box {
    width: 25px;
    height: 25px;
    border-radius: 4px;
    border: 2px solid;
    flex-shrink: 0;
}

.legend-box.available {
    background: white;
    border-color: #4caf50;
}

.legend-box.selected {
    background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
    border-color: #4caf50;
}

.legend-box.occupied {
    background: #e8eaed;
    border-color: #ccc;
}

.legend-box.discapacitado {
    background: #e3f2fd;
    border-color: #2196F3;
}

.legend-box.acompanante {
    background: #f3e5f5;
    border-color: #9c27b0;
}

.legend-text {
    color: #666;
    font-size: 0.8rem;
    font-weight: 600;
}

/* Bottom Bar */
.bottom-bar {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(255, 255, 255, 0.98);
    border-top: 2px solid rgba(102, 126, 234, 0.2);
    padding: 20px 40px;
    box-shadow: 0 -4px 25px rgba(102, 126, 234, 0.2);
    backdrop-filter: blur(10px);
    z-index: 100;
}

.bottom-content {
    max-width: 1600px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 30px;
}

.summary {
    display: flex;
    align-items: center;
    gap: 35px;
}

.summary-item {
    display: flex;
    align-items: center;
    gap: 12px;
}

.summary-icon {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    box-shadow: 0 2px 10px rgba(102, 126, 234, 0.3);
}

.summary-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.summary-label {
    font-size: 0.7rem;
    color: #999;
    text-transform: uppercase;
    font-weight: 700;
    letter-spacing: 0.5px;
}

.summary-value {
    font-size: 1.1rem;
    font-weight: bold;
    color: #333;
}

.price-display {
    font-size: 2.2rem;
    font-weight: bold;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    min-width: 120px;
}

.action-buttons {
    display: flex;
    gap: 12px;
}

.btn {
    padding: 12px 28px;
    border: none;
    border-radius: 10px;
    font-size: 0.95rem;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
}

.btn-back {
    background: rgba(102, 126, 234, 0.08);
    color: #667eea;
    border: 2px solid rgba(102, 126, 234, 0.2);
}

.btn-back:hover {
    background: rgba(102, 126, 234, 0.15);
    border-color: #667eea;
    transform: translateY(-1px);
}

.btn-continue {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.btn-continue:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
}

.btn-continue:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
}

/* Responsive */
@media (max-width: 1200px) {
    .main-container {
        grid-template-columns: 280px 1fr;
        gap: 25px;
        padding: 0 20px;
        margin: 30px auto;
    }

    .seat {
        width: 28px;
        height: 28px;
        font-size: 0.6rem;
    }
}

@media (max-width: 968px) {
    .main-container {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .left-sidebar {
        position: static;
    }

    .bottom-content {
        flex-direction: column;
        gap: 15px;
    }

    .summary {
        flex-direction: row;
        gap: 25px;
        width: 100%;
        justify-content: space-between;
    }

    .action-buttons {
        width: 100%;
        gap: 10px;
    }

    .btn {
        flex: 1;
        padding: 14px 20px;
    }

    .price-display {
        font-size: 1.8rem;
    }
}

@media (max-width: 640px) {
    .main-container {
        padding: 0 15px;
        margin: 20px auto;
    }

    .cinema-hall {
        padding: 20px;
    }

    .seat {
        width: 24px;
        height: 24px;
        font-size: 0.55rem;
    }

    .seats-row {
        gap: 4px;
    }

    .row-letter {
        width: 25px;
        font-size: 0.75rem;
    }

    .bottom-bar {
        padding: 15px 20px;
    }

    .bottom-content {
        gap: 10px;
    }

    .summary-item {
        gap: 8px;
    }

    .summary-icon {
        width: 38px;
        height: 38px;
        font-size: 1.1rem;
    }

    .summary-value {
        font-size: 1rem;
    }

    .btn {
        padding: 12px 16px;
        font-size: 0.9rem;
    }
}
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        ✨ Bienvenido a CineVel - Tu experiencia cinematográfica premium
    </div>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('user.index') }}" class="navbar-brand">CINEVEL</a>

            <div class="navbar-user">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-login">INICIAR SESIÓN</a>
                @else
                    <div class="user-info">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="user-name">{{ Auth::user()->name }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-logout">CERRAR SESIÓN</button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Progress Bar -->
    <div class="progress-bar">
        <div class="progress-container">
            <div class="progress-step completed">
                <div class="step-number">✓</div>
                <span>Película</span>
            </div>
            <div class="progress-step active">
                <div class="step-number">2</div>
                <span>Asientos</span>
            </div>
            <div class="progress-step">
                <div class="step-number">3</div>
                <span>Alimentos</span>
            </div>
            <div class="progress-step">
                <div class="step-number">4</div>
                <span>Pago</span>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Left Sidebar -->
        <div class="left-sidebar">
            <img src="{{ asset('storage/' . $funcion->movies->ruta_imagen) }}" 
                 alt="{{ $funcion->movies->titulo }}"
                 class="movie-poster">
            
            <div class="movie-info">
                <div>
                    <span class="info-badge badge-format">{{ $funcion->movies->age_suggest }}</span>
                    <span class="info-badge badge-duration">{{ $funcion->movies->duracion }} MIN</span>
                </div>

                <div class="info-item">
                    <div class="info-label">Teatro</div>
                    <div class="info-value">{{ $funcion->sala->nombre_sala }}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">Fecha y Hora</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($funcion->hora)->locale('es')->isoFormat('dddd D [de] MMMM YYYY HH:mm') }}</div>
                </div>
            </div>

            <div class="timer">
                <div class="timer-label">Tiempo restante</div>
                <div class="timer-value" id="timer">10:00</div>
            </div>
        </div>

        <!-- Cinema Hall -->
        <div class="cinema-hall">
            <div class="cinema-header">
                <h1 class="cinema-title">PANTALLA</h1>
            </div>

            <div class="screen">🎬 PANTALLA</div>

            <div class="seats-grid" id="seatsGrid">
                <!-- Las sillas se cargarán aquí -->
            </div>

            <div class="legend">
                <div class="legend-item">
                    <div class="legend-box occupied"></div>
                    <span class="legend-text">Silla ocupada</span>
                </div>
                <div class="legend-item">
                    <div class="legend-box available"></div>
                    <span class="legend-text">No disponible</span>
                </div>
                <div class="legend-item">
                    <div class="legend-box selected"></div>
                    <span class="legend-text">Mi selección</span>
                </div>
                <div class="legend-item">
                    <div class="legend-box available"></div>
                    <span class="legend-text">General</span>
                </div>
                <div class="legend-item">
                    <div class="legend-box discapacitado"></div>
                    <span class="legend-text">Discapacitado</span>
                </div>
                <div class="legend-item">
                    <div class="legend-box acompanante"></div>
                    <span class="legend-text">Acompañante</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="bottom-bar">
        <div class="bottom-content">
            <div class="summary">
                <div class="summary-item">
                    <div class="summary-icon">🎟️</div>
                    <div class="summary-info">
                        <span class="summary-label">Sillas seleccionadas</span>
                        <span class="summary-value" id="selectedCount">0</span>
                    </div>
                </div>
                <div class="summary-item">
                    <div class="summary-icon">💰</div>
                    <div class="summary-info">
                        <span class="summary-label">Cargo por servicio</span>
                        <span class="summary-value" id="serviceCharge">$0</span>
                    </div>
                </div>
                <div class="price-display" id="totalPrice">$0</div>
            </div>

            <div class="action-buttons">
                <button class="btn btn-back" onclick="history.back()">← PASO ANTERIOR</button>
                <button class="btn btn-continue" id="confirmBtn" onclick="confirmarReserva()" disabled>
                    CONTINUAR →
                </button>
            </div>
        </div>
    </div>

    <script>
        const funcionId = {{ $funcion->id }};
        let selectedSeats = new Set();
        const pricePerSeat = 6000;
        const serviceCharge = 1500;
        let timeLeft = 600; // 10 minutos

        document.addEventListener('DOMContentLoaded', async () => {
            await loadSeats();
            startTimer();
        });

        async function loadSeats() {
            try {
                const response = await fetch(`/api/funciones/${funcionId}/sillas`);
                const data = await response.json();
                
                if (data.success) {
                    renderSeats(data.sillas);
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        function renderSeats(sillas) {
            const grid = document.getElementById('seatsGrid');
            const seatsByRow = {};

            // Agrupar por fila
            sillas.forEach(silla => {
                if (!seatsByRow[silla.fila]) {
                    seatsByRow[silla.fila] = [];
                }
                seatsByRow[silla.fila].push(silla);
            });

            // Renderizar por fila
            Object.keys(seatsByRow).sort().forEach(fila => {
                const row = document.createElement('div');
                row.className = 'seats-row';
                
                const letter = document.createElement('div');
                letter.className = 'row-letter';
                letter.textContent = fila;
                row.appendChild(letter);

                const rowContent = document.createElement('div');
                rowContent.className = 'seats-row-content';

                seatsByRow[fila].sort((a, b) => a.numero - b.numero).forEach(silla => {
                    const seat = document.createElement('div');
                    seat.className = 'seat';
                    
                    if (silla.ocupada) {
                        seat.classList.add('occupied');
                    } else {
                        seat.classList.add('available');
                    }

                    seat.textContent = silla.numero;
                    seat.dataset.id = silla.id;
                    seat.dataset.numero = `${fila}${silla.numero}`;

                    if (!silla.ocupada) {
                        seat.addEventListener('click', () => toggleSeat(seat, silla.id));
                    }

                    rowContent.appendChild(seat);
                });

                row.appendChild(rowContent);
                
                const rightLetter = document.createElement('div');
                rightLetter.className = 'row-letter';
                rightLetter.textContent = fila;
                row.appendChild(rightLetter);

                grid.appendChild(row);
            });
        }

        function toggleSeat(seatElement, seatId) {
            if (seatElement.classList.contains('occupied')) return;

            if (seatElement.classList.contains('selected')) {
                seatElement.classList.remove('selected');
                selectedSeats.delete(seatId);
            } else {
                seatElement.classList.add('selected');
                selectedSeats.add(seatId);
            }

            updateSummary();
        }

        function updateSummary() {
            const count = selectedSeats.size;
            const subtotal = count * pricePerSeat;
            const service = count * serviceCharge;
            const total = subtotal + service;

            document.getElementById('selectedCount').textContent = count;
            document.getElementById('serviceCharge').textContent = `$${service.toLocaleString('es-CO')}`;
            document.getElementById('totalPrice').textContent = `$${total.toLocaleString('es-CO')}`;
            document.getElementById('confirmBtn').disabled = count === 0;
        }

        function startTimer() {
            const timerDisplay = document.getElementById('timer');
            
            setInterval(() => {
                if (timeLeft <= 0) {
                    alert('¡Tiempo agotado! Serás redirigido.');
                    window.location.href = '/';
                    return;
                }

                timeLeft--;
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }, 1000);
        }
// REEMPLAZA tu función confirmarReserva con esta:

async function confirmarReserva() {
    if (selectedSeats.size === 0) return;

    const confirmBtn = document.getElementById('confirmBtn');
    confirmBtn.disabled = true;
    confirmBtn.textContent = '⏳ PROCESANDO...';

    try {
        const response = await fetch('/api/reservas', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                funcion_id: funcionId,
                sillas_ids: Array.from(selectedSeats),
                precio_total: selectedSeats.size * (pricePerSeat + serviceCharge)
            })
        });

        const responseText = await response.text();
        
        // 🔍 MOSTRAR RESPUESTA COMPLETA
        console.log('═══════════════════════════════════════');
        console.log('📊 STATUS CODE:', response.status);
        console.log('📄 RESPUESTA COMPLETA:');
        console.log(responseText.substring(0, 1000)); // Primeros 1000 caracteres
        console.log('═══════════════════════════════════════');

        // Si empieza con <!DOCTYPE o <html, es un error HTML
        if (responseText.trim().startsWith('<!DOCTYPE') || responseText.trim().startsWith('<html')) {
            alert('❌ ERROR: El servidor está devolviendo HTML en lugar de JSON\n\n' +
                  'Status: ' + response.status + '\n' +
                  'Revisa la consola para ver el error completo');
            confirmBtn.disabled = false;
            confirmBtn.textContent = 'CONTINUAR →';
            return;
        }

        const data = JSON.parse(responseText);

        if (data.success) {

            window.location.href = `/pagos/checkout/${data.reserva.id}`;
            alert('✅ ¡Reserva creada exitosamente!\n\nTe redirigiremos al detalle de tu reserva.');
        } else {
            alert(data.message || 'Error al crear la reserva');
            confirmBtn.disabled = false;
            confirmBtn.textContent = 'CONTINUAR →';
        }
    } catch (error) {
        console.error('💥 ERROR:', error);
        alert('Error: ' + error.message);
        confirmBtn.disabled = false;
        confirmBtn.textContent = 'CONTINUAR →';
    }
}
    </script>
</body>
</html>