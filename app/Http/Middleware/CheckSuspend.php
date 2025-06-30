<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSuspend
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Cek apakah user di-suspend
            if ($user->isSuspended()) {
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'Akun Anda telah dinonaktifkan. Silakan hubungi admin untuk informasi lebih lanjut.'
                ]);
            }

            // Cek khusus untuk seller apakah seller profile-nya suspended
            if ($user->isSeller() && $user->isSellerSuspended()) {
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'Akun seller Anda telah dinonaktifkan. Silakan hubungi admin.'
                ]);
            }
        }

        return $next($request);
    }
}