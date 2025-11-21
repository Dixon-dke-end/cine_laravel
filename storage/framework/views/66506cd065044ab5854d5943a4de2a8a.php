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
            max-width: 500px;
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
            margin-bottom: 30px;
        }
        .btn {
            padding: 15px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon">✅</div>
        <h1>¡Pago Exitoso!</h1>
        <p>Tu reserva ha sido confirmada. Recibir ás un correo con los detalles.</p>
        <p><strong>Factura:</strong> <?php echo e($factura->numero_factura); ?></p>
        <a href="<?php echo e(route('reservas.show', $reserva->id)); ?>" class="btn">Ver Mi Reserva</a>
    </div>
</body>
</html><?php /**PATH C:\Users\Dixon\Desktop\cine_laravel\resources\views/pagos/success.blade.php ENDPATH**/ ?>