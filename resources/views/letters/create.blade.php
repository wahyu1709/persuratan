@extends('layouts.app')

@section('title', 'Ajukan ' . $letterType->name)
@section('header', 'Ajukan ' . $letterType->name)

@section('content')
<div class="row g-6">
    <!-- Form Utama -->
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header border-bottom-0 pb-0">
                <h5 class="mb-0">Isi Data Surat</h5>
                <small class="text-muted">Semua field bertanda * wajib diisi</small>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('letters.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="letter_type_id" value="{{ $letterType->id }}">

                    <!-- Dynamic Fields -->
                    @if($letterType->required_fields && count($letterType->required_fields) > 0)
                        <div class="row g-4">
                            @foreach($letterType->required_fields as $field)
                                @php
                                    $label = str_replace('_', ' ', $field);
                                    $label = ucfirst($label);
                                    $placeholder = match($field) {
                                        'semester' => '7',
                                        'tujuan_surat' => 'Magang di RSUD Dr. Soetomo',
                                        'instansi' => 'RSUD Dr. Soetomo',
                                        'periode' => 'Januari - Maret 2026',
                                        'lama_magang' => '3 bulan',
                                        'alasan' => 'Untuk keperluan pengajuan skripsi',
                                        'tujuan' => 'Beasiswa LPDP',
                                        'jangka_waktu' => '1 tahun',
                                        default => 'Contoh: ' . $field
                                    };
                                @endphp

                                <div class="col-md-6">
                                    <label for="{{ $field }}" class="form-label">
                                        {{ $label }} <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="{{ $field }}"
                                        id="{{ $field }}"
                                        class="form-control form-control-lg"
                                        required
                                        placeholder="{{ $placeholder }}"
                                    />
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Lampiran -->
                    <div class="mt-4">
                        <label class="form-label">Lampiran (Opsional)</label>
                        <div class="input-group">
                            <input type="file" name="attachment" class="form-control" id="attachment" accept=".pdf,.jpg,.jpeg,.png">
                            <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('attachment').click()">
                                <i class="ti ti-upload"></i>
                            </button>
                        </div>
                        <small class="form-text text-muted mt-1">
                            Format: PDF, JPG, PNG | Max 5 MB
                        </small>
                    </div>

                    <!-- Action Button -->
                    <div class="mt-5 d-grid">
                        <button type="submit" class="btn btn-primary btn-lg d-flex align-items-center justify-content-center gap-2">
                            <i class="ti ti-send fs-4"></i>
                            <span>Ajukan Surat</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Informasi Samping -->
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header border-bottom-0 pb-0">
               <h5 class="mb-0">Informasi Surat</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-start mb-4">
                    <div class="icon-shape icon-sm rounded-circle bg-success-subtle text-success me-3">
                        <i class="ti ti-file-text fs-5"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">Jenis Surat</h6>
                        <p class="text-muted mb-0">{{ $letterType->name }}</p>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-4">
                    <div class="icon-shape icon-sm rounded-circle bg-primary-subtle text-primary me-3">
                        <i class="ti ti-building fs-5"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">Ditujukan ke</h6>
                        <p class="text-muted mb-0">
                            {{ $letterType->division->name ?? 'Kemahasiswaan' }}
                        </p>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-4">
                    <div class="icon-shape icon-sm rounded-circle bg-warning-subtle text-warning me-3">
                        <i class="ti ti-check fs-5"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">Persyaratan</h6>
                        <ul class="list-unstyled mb-0">
                            @foreach($letterType->required_fields as $field)
                                <li class="mb-2 d-flex align-items-center">
                                    <i class="ti ti-check text-success me-2 fs-5"></i>
                                    <span class="text-muted">{{ ucfirst(str_replace('_', ' ', $field)) }}</span>
                                </li>
                            @endforeach
                            @if(empty($letterType->required_fields))
                                <li class="text-muted"><i class="ti ti-info-circle me-2"></i> Tidak ada field tambahan</li>
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="alert alert-info alert-dismissible fade show mb-0" role="alert">
                    <i class="ti ti-alert-circle me-2"></i>
                    <strong>Catatan:</strong><br>
                    • Pastikan data benar sebelum mengajukan.<br>
                    • Dokumen akan diverifikasi oleh divisi terkait.<br>
                    • Proses verifikasi membutuhkan waktu 1–3 hari kerja.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection