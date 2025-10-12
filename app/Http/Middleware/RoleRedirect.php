<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleRedirect
{
    public function handle(Request $request, Closure $next)
    {
        // Si el usuario NO está autenticado, lo dejamos pasar (Laravel lo redirige al login)
        if (!Auth::check()) {
            return $next($request);
        }

        // Si ya está autenticado, redirigimos según su rol
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('movies.index');
        } else {
            return redirect()->route('user.index');
        }
    }
}
