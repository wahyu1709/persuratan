@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('header', 'Dashboard Kelola Surat')

@section('content')
<div class="row g-6">
    <div class="col-xl-4">
        <div class="card card-lg">
            <div class="card-body">
                <h6 class="mb-3">Surat Menunggu</h6>
                <div class="fs-3 fw-bold text-primary">{{ $pendingCount }}</div>
                <small class="text-muted">Di divisi Anda</small>
            </div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="card card-lg">
            <div class="card-body">
                <h6 class="mb-3">Surat Terbaru (Menunggu)</h6>
                @forelse($pendingLetters as $letter)
                    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                        <div>
                            <div><strong>{{ $letter->student->name }}</strong></div>
                            <div class="text-muted small">{{ $letter->letterType->name }}</div>
                        </div>
                        <div>
                            <span class="badge bg-warning text-dark">Menunggu</span>
                            <a href="{{ route('letters.show', $letter) }}" class="btn btn-sm btn-outline-primary ms-2">
                                <i class="ti ti-eye"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">Tidak ada surat menunggu.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection