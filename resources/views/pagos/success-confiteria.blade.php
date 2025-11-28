<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¡Pago Exitoso! - CineVel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .success-container {
            background: white;
            border-radius: 15px;
            padding: 50px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            max-width: 600px;
        }
        .success-icon {
            font-size: 5rem;
            margin-bottom: 20px;
        }
        h1 {
            color: #4caf50;
            margin-bottom: 15px;
        }
        p {
            color: #666;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        .order-details {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 25px 0;
            text-align: left;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: bold;
            color: #333;
        }
        .detail-value {
            color: #667eea;
            font-weight: 600;
        }
        .btn {
            padding: 15px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            display: inline-block;
            margin: 10px;
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        .btn-secondary {
            background: white;
            border: 2px solid #667eea;
            color: #667eea;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon">✅</div>
        <h1>¡Pago Exitoso!</h1>
        <p>Tu pedido de confitería ha sido confirmado. Podrás recogerlo en el mostrador del cine.</p>
        
        <div class="order-details">
            <div class="detail-row">
                <span class="detail-label">No. Pedido:</span>
                <span class="detail-value">#{{ $pedido->id }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Total Pagado:</span>
                <span class="detail-value">${{ number_format($pedido->total, 0, ',', '.') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Productos:</span>
                <span class="detail-value">{{ $pedido->productos->sum('cantidad') }} items</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Estado:</span>
                <span class="detail-value">✅ Pagado</span>
            </div>
        </div>

        <p style="font-size: 0.9rem; color: #999;">
            <strong>Importante:</strong> Presenta esta confirmación en el mostrador de confitería para recoger tu pedido.
        </p>

        <a href="{{ route('confiteria.user') }}" class="btn">Volver a Confitería</a>
        <a href="{{ route('user.index') }}" class="btn btn-secondary">Ir al Inicio</a>
    </div>
</body>
</html>
