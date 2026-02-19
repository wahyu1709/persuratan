<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserOwnsDivision
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // Hanya staff/ketua yang perlu cek divisi
        if ($user->isStaff()) {
            // Pastikan user punya division_id
            if (is_null($user->division_id)) {
                abort(403, 'Anda belum terdaftar di divisi mana pun.');
            }

            // Ambil letter_type_id dari request (misal: dari route parameter atau form)
            $letterTypeId = $request->route('letter')?->letter_type_id ?? 
                            $request->input('letter_type_id') ?? 
                            $request->route('letter_type')?->id;

            if ($letterTypeId) {
                $divisionId = \App\Models\LetterType::findOrFail($letterTypeId)->division_id;
                if ($user->division_id !== $divisionId) {
                    abort(403, 'Akses ditolak. Surat ini bukan milik divisi Anda.');
                }
            }
        }

        return $next($request);
    }
}