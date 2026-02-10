<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserOwnsDivision
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isStaff()){
            abort(403, 'Akses ditolak.');
        }

        if (is_null(auth()->user()->division_id)){
            abort(403, 'Anda tidak terdaftar di divisi manapun.');
        }
    }
}
