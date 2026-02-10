<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsStaff
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()){
            return redirect('/login');
        }

        $user = auth()->user();
        if ($user->role !== 'staff' && $user->role !== 'ketua_divisi'){
            abort(403, 'Akses ditolak. Hanya staff yang diizinkan.');
        }

        return $next($request);
    }
}