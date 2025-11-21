#!/usr/bin/env php
<?php
/**
 * Test del Sistema de Reservas
 * Este script verifica que todo funcione correctamente
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = \Illuminate\Http\Request::create('/reservas/create/1', 'GET')
);

echo "\n=== TEST DE RUTA ===\n";
echo "URL: /reservas/create/1\n";
echo "Método: GET\n";
echo "Status Code: " . $response->getStatusCode() . "\n";

if ($response->getStatusCode() === 302) {
    echo "⚠️ Redirigiendo a login (No autenticado)\n";
} elseif ($response->getStatusCode() === 404) {
    echo "❌ No encontrado\n";
} elseif ($response->getStatusCode() === 200) {
    echo "✅ OK - Vista renderizada\n";
} else {
    echo "Status: " . $response->getStatusCode() . "\n";
}

echo "\n=== TEST DE RUTAS REGISTRADAS ===\n";
\Artisan::call('route:list', ['--name' => 'reservas']);

?>
