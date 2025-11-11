<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleRedirect
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // 🧭 Si NO hay usuario autenticado → ir al index del usuario (sin login)
        if (!$user) {
            return redirect()->route('user.index');
        }

        // 👑 Si es admin → ir al panel de admin
        if ($user->role === 'admin') {
            return redirect()->route('movies.index');
        }

        // 👤 Si es usuario → ir al panel de usuario
        if ($user->role === 'user') {
            return redirect()->route('user.index');
        }

        // ✅ Si no coincide con nada, continuar normalmente
        return $next($request);
    }
}
