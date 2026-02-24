<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LetterController;
use App\Http\Middleware\EnsureUserIsDivisionHead;
use App\Http\Middleware\EnsureUserIsStaff;
use App\Http\Middleware\EnsureUserOwnsDivision;
use Illuminate\Support\Facades\Route;

// Redirect root ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Rute autentikasi
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Rute publik / mahasiswa (hanya untuk yang login)
Route::middleware('auth')->group(function () {
    Route::get('/letters/create', [LetterController::class, 'create'])->name('letters.create');
    Route::post('/letters', [LetterController::class, 'store'])->name('letters.store');
    Route::get('/letters/my', [LetterController::class, 'myLetters'])->name('letters.my');
    Route::get('/letters/{letter}', [LetterController::class, 'show'])->name('letters.show');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Rute admin: staff & ketua divisi
Route::middleware([
    'auth',
    EnsureUserIsStaff::class,
    EnsureUserOwnsDivision::class,
])->group(function () {
    Route::get('/admin/letters', [LetterController::class, 'index'])->name('admin.letters.index');
    Route::get('/admin/letters/history', [LetterController::class, 'history'])->name('admin.letters.history');
    Route::post('/admin/letters/{letter}/approve', [LetterController::class, 'approve'])->name('admin.letters.approve');
    Route::post('/admin/letters/{letter}/reject', [LetterController::class, 'reject'])->name('admin.letters.reject');
    Route::post('/admin/letters/{letter}/verify', [LetterController::class, 'verify'])->name('admin.letters.verify');
    Route::post('/admin/letters/{letter}/upload-verified', [LetterController::class, 'uploadVerified'])->name('admin.letters.upload-verified');
});

// Rute khusus ketua divisi
Route::middleware([
    'auth',
    EnsureUserIsDivisionHead::class,
    EnsureUserOwnsDivision::class,
])->group(function () {
    Route::delete('/admin/letters/{letter}', [LetterController::class, 'destroy'])->name('admin.letters.destroy');
});