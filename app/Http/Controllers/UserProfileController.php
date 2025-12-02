<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    /**
     * Muestra el perfil del usuario con sus reservas y pedidos de confitería
     */
    public function index()
    {
        $user = Auth::user();
        
        // Obtener reservas del usuario con sus relaciones
        $reservas = $user->reservas()
            ->with(['funcion.movie', 'funcion.sala'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Obtener pedidos de confitería del usuario con sus productos
        $pedidosConfiteria = $user->pedidosConfiteria()
            ->with(['productos.confiteria'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('user.perfil', compact('user', 'reservas', 'pedidosConfiteria'));
    }
}
