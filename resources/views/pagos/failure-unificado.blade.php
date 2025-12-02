<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Fallido - CineVel</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        :root {
            --primary: #667eea;
            --danger: #ef4444;
            --gradient-danger: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .failure-container {
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

        .failure-icon {
            width: 120px;
            height: 120px;
            background: var(--gradient-danger);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% {
                transform: translateX(0);
            }
            25% {
                transform: translateX(-10px);
            }
            75% {
                transform: translateX(10px);
            }
        }

        .failure-icon svg {
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

        .error-box {
            background: #fee;
            border: 2px solid #fca5a5;
            border-radius: 16px;
            padding: 1.5rem;
            margin: 2rem 0;
            text-align: left;
        }

        .error-box strong {
            color: #991b1b;
            display: block;
            margin-bottom: 0.5rem;
        }

        .error-box p {
            color: #7f1d1d;
            font-size: 0.95rem;
        }

        .reasons {
            background: #f7fafc;
            border-radius: 16px;
            padding: 2rem;
            margin: 2rem 0;
            text-align: left;
        }

        .reasons h3 {
            color: #1a202c;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .reason-item {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
            align-items: start;
        }

        .reason-item::before {
            content: "•";
            color: var(--danger);
            font-size: 1.5rem;
            font-weight: bold;
        }

        .reason-item p {
            color: #4a5568;
            font-size: 0.95rem;
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background: white;
            border: 2px solid #667eea;
            color: #667eea;
        }

        .btn-secondary:hover {
            background: rgba(102, 126, 234, 0.1);
        }

        .help-text {
            background: #e0e7ff;
            border-radius: 12px;
            padding: 1rem;
            margin-top: 2rem;
            font-size: 0.9rem;
            color: #3730a3;
        }
    </style>
</head>
<body>
    <div class="failure-container">
        <div class="failure-icon">
            <svg viewBox="0 0 24 24">
                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
            </svg>
        </div>

        <h1>❌ Pago No Procesado</h1>
        <p class="subtitle">No pudimos completar tu transacción</p>

        <div class="error-box">
            <strong>⚠️ ¿Qué sucedió?</strong>
            <p>El pago no pudo ser procesado. Tu reserva sigue activa por {{ \Carbon\Carbon::parse($reserva->expires_at)->diffInMinutes(now()) }} minutos más.</p>
        </div>

        <div class="reasons">
            <h3>Posibles causas:</h3>
            <div class="reason-item">
                <p><strong>Fondos insuficientes:</strong> Verifica el saldo de tu tarjeta o método de pago</p>
            </div>
            <div class="reason-item">
                <p><strong>Datos incorrectos:</strong> Revisa los datos de tu tarjeta (número, CVV, fecha)</p>
            </div>
            <div class="reason-item">
                <p><strong>Límite de compra:</strong> Puede que hayas alcanzado el límite de tu tarjeta</p>
            </div>
            <div class="reason-item">
                <p><strong>Restricciones del banco:</strong> Contacta a tu banco para verificar transacciones en línea</p>
            </div>
        </div>

        <div class="info-card">
            <div class="info-row">
                <span class="info-label">Película</span>
                <span class="info-value">{{ $reserva->funcion->movies->titulo ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Asientos Reservados</span>
                <span class="info-value">
                    {{ $reserva->sillas->pluck('silla.nombre')->implode(', ') ?? 'N/A' }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Total</span>
                <span class="info-value" style="color: var(--danger); font-size: 1.25rem;">
                    ${{ number_format($reserva->precio_total + ($pedidoConfiteria->total ?? 0), 0, ',', '.') }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Tiempo Restante</span>
                <span class="info-value" style="color: #f59e0b;">
                    {{ \Carbon\Carbon::parse($reserva->expires_at)->diffInMinutes(now()) }} minutos
                </span>
            </div>
        </div>

        <div class="buttons">
            <a href="{{ route('pagos.checkout.unificado', ['reserva_id' => $reserva->id, 'pedido_id' => $pedidoConfiteria->id ?? null]) }}" class="btn btn-primary">
                🔄 Intentar de Nuevo
            </a>
            <a href="{{ route('user.index') }}" class="btn btn-secondary">
                Volver al Inicio
            </a>
        </div>

        <div class="help-text">
            💡 <strong>Consejo:</strong> Si el problema persiste, intenta con otro método de pago o contacta a tu banco para autorizar la transacción.
        </div>
    </div>
</body>
</html>
