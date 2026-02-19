<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isStudent()) {
            $recentLetters = $user->submittedLetters()->latest()->take(5)->get();
            $totalLetters = $user->submittedLetters()->count();
            $approvedCount = $user->submittedLetters()->where('status', 'disetujui')->count();

            return view('dashboard.student', compact(
                'recentLetters',
                'totalLetters',
                'approvedCount'
            ));
        }

        // Untuk staff/ketua divisi
        $pendingLetters = \App\Models\Letter::forCurrentUserDivision()
            ->where('status', 'menunggu')
            ->with('student', 'letterType')
            ->latest()
            ->take(5)
            ->get();

        $pendingCount = \App\Models\Letter::forCurrentUserDivision()
            ->where('status', 'menunggu')
            ->count();

        return view('dashboard.admin', compact('pendingLetters', 'pendingCount'));
    }
}