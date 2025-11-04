<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleRedirect
{
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if (!$user) {
            // Si no hay usuario logueado, lo mandas al login
            return redirect()->route('user.index');
        }

        if ($user->role === 'admin') {
            // Si es admin, va al panel de admin (por ejemplo movies.index)
            return redirect()->route('movies.index');
        }

        if ($user->role === 'user') {
            // Si es usuario normal, va a su vista
            return redirect()->route('user.index');
        }

        // Si no cumple ninguna condición, sigue el flujo normal
        return $next($request);
    }

}
    