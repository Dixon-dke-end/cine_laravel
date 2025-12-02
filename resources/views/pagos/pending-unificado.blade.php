<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Pendiente - CineVel</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        :root {
            --primary: #667eea;
            --warning: #f59e0b;
            --gradient-warning: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .pending-container {
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

        .pending-icon {
            width: 120px;
            height: 120px;
            background: var(--gradient-warning);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .pending-icon svg {
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
            background: #fffbeb;
            border: 2px solid #fbbf24;
            border-radius: 16px;
            padding: 2rem;
            margin: 2rem 0;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #fde68a;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #92400e;
            font-weight: 500;
        }

        .info-value {
            font-weight: 700;
            color: #78350f;
        }

        .alert-box {
            background: white;
            border: 2px solid #fbbf24;
            border-radius: 12px;
            padding: 1.5rem;
            margin: 1.5rem 0;
            text-align: left;
        }

        .alert-box strong {
            color: #92400e;
            display: block;
            margin-bottom: 0.5rem;
        }

        .alert-box p {
            color: #78350f;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
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
            background: var(--gradient-warning);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(245, 158, 11, 0.3);
        }

        .btn-secondary {
            background: white;
            border: 2px solid var(--warning);
            color: var(--warning);
        }

        .btn-secondary:hover {
            background: rgba(245, 158, 11, 0.1);
        }

        .steps {
            text-align: left;
            margin: 2rem 0;
        }

        .step {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            align-items: start;
        }

        .step-number {
            width: 30px;
            height: 30px;
            background: var(--warning);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            flex-shrink: 0;
        }
    </style>
</head>
<body>
    <div class="pending-container">
        <div class="pending-icon">
            <svg viewBox="0 0 24 24">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                <circle cx="12" cy="12" r="10" fill="none" stroke="white" stroke-width="2" stroke-dasharray="3 3">
                    <animateTransform attributeName="transform" type="rotate" from="0 12 12" to="360 12 12" dur="2s" repeatCount="indefinite"/>
                </circle>
            </svg>
        </div>

        <h1>⏳ Pago Pendiente</h1>
        <p class="subtitle">Tu reserva está siendo procesada</p>

        <div class="alert-box">
            <strong>⚠️ Importante</strong>
            <p>Tu pago está siendo verificado. Esto puede tomar unos minutos dependiendo del método de pago seleccionado.</p>
        </div>

        <div class="info-card">
            <div class="info-row">
                <span class="info-label">Estado del Pago</span>
                <span class="info-value">En Proceso</span>
            </div>
            <div class="info-row">
                <span class="info-label">Película</span>
                <span class="info-value">{{ $reserva->funcion->movies->titulo ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Asientos</span>
                <span class="info-value">
                    {{ $reserva->sillas->pluck('silla.nombre')->implode(', ') ?? 'N/A' }}
                </span>
            </div>
        </div>

        <div class="steps">
            <strong style="display: block; margin-bottom: 1rem; color: #1a202c;">Próximos pasos:</strong>
            
            <div class="step">
                <div class="step-number">1</div>
                <div>
                    <strong style="color: #1a202c;">Verificación del Pago</strong>
                    <p style="color: #718096; font-size: 0.9rem; margin-top: 0.25rem;">
                        Estamos confirmando tu pago con el proveedor
                    </p>
                </div>
            </div>

            <div class="step">
                <div class="step-number">2</div>
                <div>
                    <strong style="color: #1a202c;">Confirmación por Email</strong>
                    <p style="color: #718096; font-size: 0.9rem; margin-top: 0.25rem;">
                        Recibirás un correo cuando el pago sea confirmado
                    </p>
                </div>
            </div>

            <div class="step">
                <div class="step-number">3</div>
                <div>
                    <strong style="color: #1a202c;">Reserva Confirmada</strong>
                    <p style="color: #718096; font-size: 0.9rem; margin-top: 0.25rem;">
                        Podrás ver tu reserva en "Mis Reservas"
                    </p>
                </div>
            </div>
        </div>

        <div class="buttons">
            <a href="{{ route('reservas.show', $reserva->id) }}" class="btn btn-primary">
                Ver Estado de Mi Reserva
            </a>
            <a href="{{ route('user.index') }}" class="btn btn-secondary">
                Volver al Inicio
            </a>
        </div>
    </div>
</body>
</html>
