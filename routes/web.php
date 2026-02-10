<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LetterController;
use App\Http\Middleware\EnsureUserIsStaff;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\EnsureUserOwnsDivision;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Middleware\EnsureUserIsDivisionHead;

// Rute autentikasi
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Rute publik / mahasiswa
Route::middleware('auth')->group(function (){
    Route::get('/letters/create', [LetterController::class, 'create'])->name('letters.create');
    Route::post('/letters', [LetterController::class, 'store'])->name('letters.store');
    Route::get('/letters/my', [LetterController::class, 'myLetters'])->name('letters.my');
    Route::get('/letters/{letter}', [LetterController::class, 'show'])->name('letters.show');
    Route::get('/dashboard', function () {
        if (auth()->user()->isStudent()) {
            return view('dashboard.student');
        }
        return view('dashboard.admin');
    })->name('dashboard');
});

// Rute admin: hanya staff & ketua divisi
Route::middleware([
    'auth',
    EnsureUserIsStaff::class,
    EnsureUserOwnsDivision::class,
])->group(function () {
    Route::get('/admin/letters', [LetterController::class, 'index'])->name('admin.letters.index');
    Route::post('/admin/letters/{letter}/approve', [LetterController::class, 'approve'])->name('admin.letters.approve');
    Route::post('/admin/letters/{letter}/reject', [LetterController::class, 'reject'])->name('admin.letters.reject');
});

// Rute khusus ketua divisi
Route::middleware([
    'auth',
    EnsureUserIsDivisionHead::class,
    EnsureUserOwnsDivision::class,
])->group(function () {
    Route::delete('/admin/letters/{letter}', [LetterController::class, 'destroy'])->name('admin.letters.destroy');
});