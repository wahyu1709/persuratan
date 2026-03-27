<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        if (auth()->check()) {
            return redirect($this->redirectToDashboard());
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:mahasiswa,staff',
            'nim' => 'required_if:role,mahasiswa|nullable|unique:users,nim',
            'nip' => 'required_if:role,staff|nullable',
        ], [
            'nim.required_if' => 'NIM wajib diisi untuk mahasiswa.',
            'nip.required_if' => 'NIP wajib diisi untuk staff.',
            'nim.unique' => 'NIM sudah terdaftar.',
            'email.unique' => 'Email sudah digunakan.',
        ]);

        // ✅ Validasi domain email
        $allowedDomains = ['@ui.ac.id', '@fk.ui.ac.id'];
        $emailDomain = '@' . explode('@', $request->email)[1];
        if (!in_array($emailDomain, $allowedDomains)) {
            throw ValidationException::withMessages([
                'email' => 'Email harus berasal dari domain @ui.ac.id atau @fk.ui.ac.id.',
            ]);
        }

        // Tentukan division_id (NULL untuk mahasiswa)
        $divisionId = null;
        if ($request->role === 'staff') {
            // Untuk MVP, staff sementara tidak punya divisi — bisa diatur oleh ketua nanti
            // Atau kamu bisa tambahkan dropdown divisi di form
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nim' => $request->role === 'mahasiswa' ? $request->nim : null,
            'nip' => $request->role === 'staff' ? $request->nip : null,
            'role' => $request->role,
            'division_id' => $divisionId,
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }

    protected function redirectToDashboard()
    {
        return auth()->user()->isStudent()
            ? route('letters.my')
            : route('admin.letters.index');
    }
}