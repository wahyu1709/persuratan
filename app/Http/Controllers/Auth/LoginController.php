<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (auth()->check()) {
            return $this->redirectTo();
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // ✅ Validasi domain email (opsional tapi disarankan)
        $allowedDomains = ['@fk.ui.ac.id', '@ui.ac.id'];
        $emailDomain = '@' . explode('@', $request->email)[1];
        if (!in_array($emailDomain, $allowedDomains)) {
            throw ValidationException::withMessages([
                'email' => 'Email harus berasal dari domain universitas.',
            ]);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended($this->redirectTo());
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    protected function redirectTo()
    {
        $user = auth()->user();
        if ($user->isStudent()) {
            return route('letters.my'); // Mahasiswa → daftar surat
        }
        return route('admin.letters.index'); // Staff/ketua → dashboard admin
    }
}