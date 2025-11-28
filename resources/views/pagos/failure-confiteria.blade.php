<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Fallido - CineVel</title>
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
        .failure-container {
            background: white;
            border-radius: 15px;
            padding: 50px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            max-width: 600px;
        }
        .failure-icon {
            font-size: 5rem;
            margin-bottom: 20px;
        }
        h1 {
            color: #f44336;
            margin-bottom: 15px;
        }
        p {
            color: #666;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        .order-details {
            background: #ffebee;
            border-radius: 10px;
            padding: 20px;
            margin: 25px 0;
            text-align: left;
            border: 2px solid #ef5350;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ffcdd2;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: bold;
            color: #333;
        }
        .detail-value {
            color: #f44336;
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
        .btn-retry {
            background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
        }
        .btn-retry:hover {
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.4);
        }
        .reasons {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 25px 0;
            text-align: left;
        }
        .reasons h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }
        .reasons ul {
            color: #666;
            padding-left: 20px;
        }
        .reasons li {
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <div class="failure-container">
        <div class="failure-icon">❌</div>
        <h1>Pago Fallido</h1>
        <p>Lo sentimos, tu pago no pudo ser procesado o fue cancelado.</p>
        
        <div class="order-details">
            <div class="detail-row">
                <span class="detail-label">No. Pedido:</span>
                <span class="detail-value">#{{ $pedido->id }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Total:</span>
                <span class="detail-value">${{ number_format($pedido->total, 0, ',', '.') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Estado:</span>
                <span class="detail-value">❌ Fallido</span>
            </div>
        </div>

        <div class="reasons">
            <h3>Posibles causas:</h3>
            <ul>
                <li>Fondos insuficientes en tu cuenta</li>
                <li>Datos de tarjeta incorrectos</li>
                <li>Pago cancelado por el usuario</li>
                <li>Límite de transacciones excedido</li>
            </ul>
        </div>

        <a href="{{ route('pagos.checkout.confiteria', $pedido->id) }}" class="btn btn-retry">Reintentar Pago</a>
        <a href="{{ route('confiteria.user') }}" class="btn">Volver a Confitería</a>
    </div>
</body>
</html>
