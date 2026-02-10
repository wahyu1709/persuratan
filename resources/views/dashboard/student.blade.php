@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')
@section('header', 'Selamat Datang, {{ auth()->user()->name }}')

@section('content')
<div class="row g-6">
    <!-- Card: Jumlah Surat -->
    <div class="col-xl-4 col-md-6">
        <div class="card card-lg">
            <div class="card-body d-flex flex-column gap-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-shape icon-lg rounded-circle bg-primary-darker text-primary-lighter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-text">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h6 class="mb-0">Surat Saya</h6>
                        <p class="text-muted mb-0">{{ $totalLetters ?? 0 }}</p>
                    </div>
                </div>
                <div class="progress mt-2" style="height: 6px">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $approvedPercentage ?? 0 }}%"></div>
                </div>
                <small class="text-muted">({{ $approvedCount ?? 0 }} disetujui)</small>
            </div>
        </div>
    </div>

    <!-- Card: Aksi Cepat -->
    <div class="col-xl-8 col-md-6">
        <div class="card card-lg">
            <div class="card-body">
                <h5 class="mb-4">Aksi Cepat</h5>
                <div class="d-grid gap-3">
                    <a href="{{ route('letters.create') }}" class="btn btn-primary btn-lg d-flex align-items-center justify-content-center gap-2">
                        <i class="ti ti-plus"></i> Ajukan Surat Baru
                    </a>
                    <a href="{{ route('letters.my') }}" class="btn btn-outline-secondary btn-lg d-flex align-items-center justify-content-center gap-2">
                        <i class="ti ti-file-text"></i> Lihat Riwayat Surat
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Surat Terbaru -->
    <div class="col-12">
        <div class="card">
            <div class="card-header border-bottom-0 pb-0">
                <h5 class="mb-0">Surat Terbaru</h5>
            </div>
            <div class="card-body p-0">
                @if($recentLetters->isEmpty())
                    <div class="text-center py-5 text-muted">Belum ada surat yang diajukan.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Jenis Surat</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentLetters as $letter)
                                    <tr>
                                        <td>{{ $letter->letterType->name }}</td>
                                        <td>{{ $letter->created_at->format('d M Y') }}</td>
                                        <td>
                                            <span class="badge {{ $letter->status === 'disetujui' ? 'bg-success' : ($letter->status === 'ditolak' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                                {{ ucfirst($letter->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('letters.show', $letter) }}" class="btn btn-sm btn-outline-secondary">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection