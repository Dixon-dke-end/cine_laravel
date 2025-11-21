<?php
// Script para limpiar la base de datos completamente
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    
    // Obtener todas las tablas
    $tables = DB::select("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = '" . env('DB_DATABASE') . "'");
    
    foreach ($tables as $table) {
        $tableName = $table->TABLE_NAME;
        echo "Eliminando tabla: $tableName\n";
        DB::statement("DROP TABLE IF EXISTS `$tableName`");
    }
    
    DB::statement('SET FOREIGN_KEY_CHECKS=1');
    echo "\n✅ Base de datos completamente limpia\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
