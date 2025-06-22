<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Gunakan facade Auth
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Redirect fallback jika role tidak sesuai
        switch ($user->role) {
            case 'user':
                return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            case 'seller':
                return redirect('/seller/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            case 'admin':
                return redirect('/admin')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            default:
                return redirect('/login')->with('error', 'Role tidak dikenali.');
        }
    }
}
