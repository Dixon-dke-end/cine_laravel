<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Pago Exitoso! - CineVel</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        :root {
            --primary: #667eea;
            --success: #10b981;
            --gradient-main: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-success: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .success-container {
            background: white;
            border-radius: 24px;
            padding: 3rem;
            max-width: 600px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-icon {
            width: 120px;
            height: 120px;
            background: var(--gradient-success);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            animation: checkmark 0.6s ease-in-out;
        }

        @keyframes checkmark {
            0% {
                transform: scale(0);
            }
            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
            }
        }

        .success-icon svg {
            width: 60px;
            height: 60px;
            fill: white;
        }

        h1 {
            font-size: 2.5rem;
            color: #1a202c;
            margin-bottom: 1rem;
        }

        .subtitle {
            font-size: 1.1rem;
            color: #718096;
            margin-bottom: 2rem;
        }

        .info-card {
            background: #f7fafc;
            border-radius: 16px;
            padding: 2rem;
            margin: 2rem 0;
            text-align: left;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #718096;
            font-weight: 500;
        }

        .info-value {
            font-weight: 700;
            color: #1a202c;
        }

        .buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            flex: 1;
            padding: 1rem 2rem;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: var(--gradient-main);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background: white;
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .btn-secondary:hover {
            background: rgba(102, 126, 234, 0.1);
        }

        .confetti {
            position: fixed;
            width: 10px;
            height: 10px;
            background: #f0f;
            position: absolute;
            animation: confetti-fall 3s linear infinite;
        }

        @keyframes confetti-fall {
            to {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon">
            <svg viewBox="0 0 24 24">
                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
            </svg>
        </div>

        <h1>¡Pago Exitoso! 🎉</h1>
        <p class="subtitle">Tu compra ha sido confirmada correctamente</p>

        <div class="info-card">
            <div class="info-row">
                <span class="info-label">Película</span>
                <span class="info-value">{{ $reserva->funcion->movies->titulo }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Fecha y Hora</span>
                <span class="info-value">
                    {{ \Carbon\Carbon::parse($reserva->funcion->hora)->format('d/m/Y H:i') }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Sala</span>
                <span class="info-value">{{ $reserva->funcion->Sala->nombre_sala }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Asientos</span>
                <span class="info-value">
                    {{ $reserva->sillas->pluck('silla.nombre')->implode(', ') }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Total Pagado</span>
                <span class="info-value" style="color: var(--success); font-size: 1.25rem;">
                    ${{ number_format($reserva->precio_total + ($pedidoConfiteria->total ?? 0), 0, ',', '.') }}
                </span>
            </div>
        </div>

        <div style="background: #e6fffa; border: 2px solid #81e6d9; border-radius: 12px; padding: 1rem; margin: 1.5rem 0;">
            <strong style="color: #047857;">📧 Confirmación enviada</strong>
            <p style="color: #065f46; margin-top: 0.5rem; font-size: 0.9rem;">
                Hemos enviado los detalles de tu reserva a tu correo electrónico
            </p>
        </div>

        <div class="buttons">
            <a href="{{ route('reservas.show', $reserva->id) }}" class="btn btn-primary">
                Ver Mi Reserva
            </a>
            <a href="{{ route('user.index') }}" class="btn btn-secondary">
                Volver al Inicio
            </a>
        </div>
    </div>

    <script>
        // Crear confetti animado
        function createConfetti() {
            const colors = ['#667eea', '#764ba2', '#10b981', '#f59e0b', '#ec4899'];
            for (let i = 0; i < 50; i++) {
                setTimeout(() => {
                    const confetti = document.createElement('div');
                    confetti.className = 'confetti';
                    confetti.style.left = Math.random() * 100 + 'vw';
                    confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
                    confetti.style.animationDelay = Math.random() * 3 + 's';
                    document.body.appendChild(confetti);
                    
                    setTimeout(() => confetti.remove(), 3000);
                }, i * 30);
            }
        }

        createConfetti();
    </script>
</body>
</html>
