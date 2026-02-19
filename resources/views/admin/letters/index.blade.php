@extends('layouts.app')

@section('title', 'Kelola Surat')
@section('header', 'Surat Menunggu Verifikasi')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header border-bottom-0 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Daftar Surat Menunggu</h4>
                    <small class="text-muted">
                        {{ $pendingLetters->total() }} surat menunggu di divisi {{ auth()->user()->division->name ?? '-' }}
                    </small>
                </div>
            </div>
            <div class="card-body p-0">
                @if($pendingLetters->isEmpty())
                    <div class="text-center py-5">
                        <i class="ti ti-inbox fs-1 text-muted mb-3"></i>
                        <p class="text-muted mb-0">Tidak ada surat menunggu saat ini.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover text-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" width="5%">No</th>
                                    <th scope="col">Mahasiswa</th>
                                    <th scope="col">Jenis Surat</th>
                                    <th scope="col">Tanggal Ajukan</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingLetters as $letter)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div>{{ $letter->student->name }}</div>
                                            <small class="text-muted">{{ $letter->student->nim ?? '-' }}</small>
                                        </td>
                                        <td>{{ $letter->letterType->name }}</td>
                                        <td>{{ $letter->created_at->format('d M Y H:i') }}</td>
                                        <td>
                                            @php
                                                $status = $letter->status;
                                                $badgeClass = match($status) {
                                                    'menunggu' => 'bg-info',
                                                    'verifikasi' => 'bg-warning',
                                                    'disettuju' => 'bg-success',
                                                    'ditolak' => 'bg-danger',
                                                    default => 'bg-secondary'
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }} text-dark rounded-pill px-3 py-2">
                                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <!-- Tombol Lihat Dokumen (selalu tersedia) -->
                                            

                                            @if($letter->status === 'menunggu')
                                                <form method="POST" action="{{ route('admin.letters.verify', $letter) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning btn-sm me-1" onclick="return confirm('Mulai verifikasi?')">
                                                        <i class="ti ti-check-circle"></i> Verifikasi
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $letter->id }}">
                                                    <i class="ti ti-x"></i> Tolak
                                                </button>
                                            @elseif($letter->status === 'verifikasi')
                                                <a href="{{ route('letters.show', $letter) }}" class="btn btn-outline-secondary btn-sm me-1" title="Lihat dokumen">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                <!-- Staff sudah verifikasi → boleh download asli & upload hasil verifikasi -->
                                                <a href="{{ $letter->original_file_url }}" target="_blank" class="btn btn-outline-primary btn-sm me-1" title="Download Dokumen Asli">
                                                    <i class="ti ti-download me-1"></i> Unduh Asli
                                                </a>

                                                <form method="POST" action="{{ route('admin.letters.upload-verified', $letter) }}" enctype="multipart/form-data" class="d-inline">
                                                    @csrf
                                                    <input type="file" name="verified_file" class="d-none" id="verifiedFile_{{ $letter->id }}" required>
                                                    <label for="verifiedFile_{{ $letter->id }}" class="btn btn-outline-success btn-sm me-1" title="Upload Dokumen Hasil Verifikasi">
                                                        <i class="ti ti-upload me-1"></i> Upload Baru
                                                    </label>
                                                </form>

                                                <form method="POST" action="{{ route('admin.letters.approve', $letter) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm me-1" onclick="return confirm('Setujui surat ini?')">
                                                        <i class="ti ti-check me-1"></i> Setujui
                                                    </button>
                                                </form>

                                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $letter->id }}">
                                                    <i class="ti ti-x me-1"></i> Tolak
                                                </button>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Modal Tolak -->
                                    <div class="modal fade" id="rejectModal{{ $letter->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tolak Surat</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.letters.reject', $letter) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="notes_{{ $letter->id }}" class="form-label">Catatan Penolakan</label>
                                                            <textarea name="notes" id="notes_{{ $letter->id }}" class="form-control" rows="3" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">Kirim Penolakan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer bg-white border-top">
                        {{ $pendingLetters->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection