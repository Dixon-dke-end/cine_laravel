<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reserva;

class CleanExpiredReservations extends Command
{
    protected $signature = 'reservas:clean-expired';
    protected $description = 'Cancelar reservas pendientes que expiraron';

    public function handle()
    {
        $expired = Reserva::where('estado', 'pendiente')
            ->where('expires_at', '<', now())
            ->update([
                'estado' => 'cancelada'
            ]);

        $this->info("Se cancelaron {$expired} reservas expiradas.");
        
        return 0;
    }
}