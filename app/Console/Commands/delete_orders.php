<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class delete_orders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete_orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pedidosVencidos = Pedido::where('expires_at', '<', now())
        ->where('estado', 'pendiente')
        ->get();

        foreach ($pedidosVencidos as $pedido) {

            // 1. Devolver el stock al producto correspondiente
            $producto = $pedido->producto; // relación belongsTo

            if ($producto) {
                $producto->cantidad += $pedido->cantidad_pedido;
                $producto->save();
            }

            // 2. Eliminar o marcar como expirado
            $pedido->delete();
        }
}
}