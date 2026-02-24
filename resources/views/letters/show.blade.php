@extends('layouts.app')

@section('title', 'Detail Surat')
@section('header', 'Detail Surat')

@section('content')
<div class="row">
    <div class="col-xl-8 col-lg-7">
        <div class="card">
            <div class="card-header border-bottom-0 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $letter->letterType->name }}</h5>
                    @php
                        $status = $letter->status;
                        $badgeClass = match($status) {
                            'disetujui' => 'bg-success',
                            'ditolak' => 'bg-danger',
                            'dibatalkan' => 'bg-secondary',
                            'verifikasi' => 'bg-warning',
                            default => 'bg-info'
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }} text-dark rounded-pill px-3 py-2">
                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                    </span>
                </div>
                <small class="text-muted mt-2">
                    Diajukan oleh: {{ $letter->student->name }} ({{ $letter->student->nim ?? '-' }})
                    <br>
                    {{ $letter->student->study_level_label }} – Semester {{ $letter->student->semester }}
                    <br>
                    Tanggal: {{ $letter->created_at->format('d M Y H:i') }}
                </small>
            </div>
            <div class="card-body">
                <h6 class="mb-4">Data Surat</h6>
                <div class="row g-3">
                    @foreach($letter->data as $key => $value)
                        @php
                            $label = str_replace('_', ' ', $key);
                            $label = ucfirst($label);
                        @endphp
                        <div class="col-md-6">
                            <strong>{{ $label }}:</strong><br>
                            {{ $value }}
                        </div>
                    @endforeach
                </div>

                <!-- Bagian Dokumen -->
                <div class="mt-4">
                    @if($letter->verified_file_path && $letter->status === 'disetujui')
                        <!-- Dokumen hasil verifikasi (prioritas utama) -->
                        <h6>Dokumen Hasil Verifikasi</h6>
                        <p class="text-success mb-2">
                            <i class="ti ti-check-circle text-success me-1"></i>
                            Sudah diverifikasi oleh {{ $letter->letterType->division->name }}
                        </p>
                        <a href="{{ asset('storage/' . $letter->verified_file_path) }}" 
                           target="_blank" 
                           class="btn btn-primary btn-sm">
                            <i class="ti ti-file-text me-1"></i> Unduh Dokumen Terbaru
                        </a>
                    @elseif($letter->file_path)
                        <!-- Dokumen asli (belum diverifikasi) -->
                        <h6>Dokumen Asli</h6>
                        <p class="text-muted mb-2">
                            @if ($letter->status === 'ditolak')
                                Surat ditolak oleh {{ $letter->letterType->division->name }}
                            @else
                                Menunggu verifikasi oleh {{ $letter->letterType->division->name }}
                            @endif             
                        </p>
                        <a href="{{ asset('storage/' . $letter->file_path) }}" 
                           target="_blank" 
                           class="btn btn-outline-secondary btn-sm">
                            <i class="ti ti-file-text me-1"></i> Unduh Dokumen
                        </a>

                        <!-- ✅ Tombol Upload hanya muncul untuk staff/ketua saat status = 'verifikasi' -->
                        @if(auth()->user()->isStaff() && $letter->status === 'verifikasi')
                            <div class="mt-3">
                                <form method="POST" action="{{ route('admin.letters.upload-verified', $letter) }}" enctype="multipart/form-data" class="d-inline">
                                    @csrf
                                    <input 
                                        type="file" 
                                        name="verified_file" 
                                        class="d-none" 
                                        id="verifiedFile_{{ $letter->id }}" 
                                        accept=".pdf,.jpg,.jpeg,.png"
                                        onchange="document.getElementById('uploadForm_{{ $letter->id }}').submit()"
                                        required
                                    >
                                    <label for="verifiedFile_{{ $letter->id }}" class="btn btn-outline-success btn-sm">
                                        <i class="ti ti-upload me-1"></i> Upload Dokumen Hasil Verifikasi
                                    </label>
                                    <button type="submit" class="btn btn-success btn-sm ms-2">
                                        <i class="ti ti-send me-1"></i> Kirim
                                    </button>
                                </form>
                            </div>
                        @endif
                    @else
                        <p class="text-muted">Tidak ada dokumen yang diunggah.</p>
                    @endif
                </div>

                @if($letter->notes && in_array($letter->status, ['ditolak']))
                    <div class="mt-4">
                        <h6>Catatan Penolakan</h6>
                        <p class="text-danger">{{ $letter->notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5">
        @if(auth()->user()->isStudent() && in_array($letter->status, ['menunggu', 'verifikasi']))
            <!-- Mahasiswa: hanya info -->
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3">Informasi</h6>
                    <p class="text-muted mb-0">
                        Surat ini sedang dalam proses peninjauan oleh {{ $letter->letterType->division->name }}.
                        Anda akan menerima notifikasi saat status berubah.
                    </p>
                </div>
            </div>
        @elseif(auth()->user()->isStudent() && $letter->status === 'disetujui')
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3">Informasi</h6>
                    <p class="text-muted mb-0">
                        Surat ini telah disetujui oleh {{ $letter->letterType->division->name }}.
                        Anda dapat mengunduh dokumen yang sudah disetujui.
                    </p>
                </div>
            </div>
        @else
            <!-- Staff / Ketua Divisi -->
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3">Aksi</h6>

                    @if($letter->status === 'menunggu')
                        <form method="POST" action="{{ route('admin.letters.verify', $letter) }}" class="mb-3">
                            @csrf
                            <button type="submit" class="btn btn-warning w-100 mb-2">
                                <i class="ti ti-check-circle me-1"></i> Verifikasi
                            </button>
                        </form>

                        <button type="button" class="btn btn-danger w-100 mb-2" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="ti ti-x me-1"></i> Tolak
                        </button>
                    @elseif($letter->status === 'verifikasi')
                        <form method="POST" action="{{ route('admin.letters.approve', $letter) }}" class="mb-3">
                            @csrf
                            <button type="submit" class="btn btn-success w-100 mb-2">
                                <i class="ti ti-check me-1"></i> Setujui
                            </button>
                        </form>

                        <button type="button" class="btn btn-danger w-100 mb-2" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="ti ti-x me-1"></i> Tolak
                        </button>
                    @endif

                    @if(auth()->user()->isDivisionHead())
                        <form method="POST" action="{{ route('admin.letters.destroy', $letter) }}" onsubmit="return confirm('Yakin hapus surat ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="ti ti-trash me-1"></i> Hapus Surat
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Modal Tolak -->
            <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="rejectModalLabel">Tolak Surat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('admin.letters.reject', $letter) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Catatan Penolakan</label>
                                    <textarea name="notes" id="notes" class="form-control" rows="3" required></textarea>
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
        @endif
    </div>
</div>
@endsection