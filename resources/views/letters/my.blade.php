@extends('layouts.app')

@section('title', 'Surat Saya')
@section('header', 'Riwayat Pengajuan Surat')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header border-bottom-0 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Daftar Surat</h4>
                    <a href="{{ route('letters.create') }}" class="btn btn-primary btn-sm">
                        <i class="ti ti-plus me-1"></i> Ajukan Surat Baru
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                @if($letters->isEmpty())
                    <div class="text-center py-5">
                        <i class="ti ti-file-text fs-1 text-muted mb-3"></i>
                        <p class="text-muted mb-0">Belum ada surat yang diajukan.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover text-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Jenis Surat</th>
                                    <th scope="col">Tanggal Ajukan</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($letters as $letter)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $letter->letterType->name }}</td>
                                        <td>{{ $letter->created_at->format('d M Y H:i') }}</td>
                                        <td>
                                            @php
                                                $status = $letter->status;
                                                $badgeClass = match($status) {
                                                    'disetujui' => 'bg-success',
                                                    'ditolak' => 'bg-danger',
                                                    'dibatalkan' => 'bg-secondary',
                                                    default => 'bg-warning text-dark'
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }} rounded-pill px-3 py-2">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('letters.show', $letter) }}" class="btn btn-outline-secondary btn-sm">
                                                <i class="ti ti-eye me-1"></i> Lihat
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