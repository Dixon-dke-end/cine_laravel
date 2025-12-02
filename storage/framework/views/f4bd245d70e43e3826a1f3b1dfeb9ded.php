<!DOCTYPE html>
<html>
<head>
    <title>Test</title>
</head>
<body>
    <h1>TEST PAGE - If you see this, ngrok works fine</h1>
    <p>Session ID: <?php echo e(session()->getId()); ?></p>
    <p>Pedido en sesión: <?php echo e(session('pedido_pendiente') ? 'SI' : 'NO'); ?></p>
    <?php if(session('pedido_pendiente')): ?>
        <pre><?php echo e(json_encode(session('pedido_pendiente'), JSON_PRETTY_PRINT)); ?></pre>
    <?php endif; ?>
</body>
</html>
<?php /**PATH C:\Users\Dixon\Desktop\cine_laravel\resources\views/test-session.blade.php ENDPATH**/ ?>