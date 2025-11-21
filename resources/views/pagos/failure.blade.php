<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pago Rechazado - CineVel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .failure-container {
            background: white;
            border-radius: 15px;
            padding: 50px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .failure-icon {
            font-size: 5rem;
            margin-bottom: 20px;
        }
        h1 {
            color: #f44336;
            margin-bottom: 15px;
        }
        .btn {
            padding: 15px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin: 10px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="failure-container">
        <div class="failure-icon">❌</div>
        <h1>Pago Rechazado</h1>
        <p>Hubo un problema al procesar tu pago.</p>
        <a href="{{ route('pagos.checkout', $reserva->id) }}" class="btn">Intentar de Nuevo</a>
        <a href="{{ route('user.index') }}" class="btn">Volver al Inicio</a>
    </div>
</body>
</html>