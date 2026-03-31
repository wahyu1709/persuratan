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
                                    // Label: tiap kata kapital
                                    $label = ucwords(str_replace('_', ' ', $field));

                                    // Deteksi tipe input berdasarkan nama field
                                    $inputType = 'text';
                                    if (str_contains($field, 'email'))                                                                      $inputType = 'email';
                                    elseif (str_contains($field, 'no_hp') || str_contains($field, 'telepon') || str_contains($field, 'phone')) $inputType = 'tel';
                                    elseif (str_contains($field, 'tanggal') || str_contains($field, 'date'))                                $inputType = 'date';
                                    elseif (str_contains($field, 'ipk') || str_contains($field, 'nilai') || str_contains($field, 'tahun') || str_contains($field, 'semester')) $inputType = 'number';

                                    // Placeholder otomatis dari nama field
                                    $humanized = strtolower(str_replace('_', ' ', $field));
                                    $placeholder = match($inputType) {
                                        'email'  => 'Contoh: nama@email.com',
                                        'tel'    => 'Contoh: 081234567890',
                                        'date'   => '',
                                        'number' => 'Contoh: ' . match(true) {
                                            str_contains($field, 'ipk')      => '3.75',
                                            str_contains($field, 'semester') => '5',
                                            str_contains($field, 'tahun')    => date('Y'),
                                            default                          => '0',
                                        },
                                        default  => 'Masukkan ' . $humanized,
                                    };
                                @endphp

                                <div class="col-md-6">
                                    <label for="{{ $field }}" class="form-label fw-semibold">
                                        {{ $label }} <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="{{ $inputType }}"
                                        name="{{ $field }}"
                                        id="{{ $field }}"
                                        class="form-control @error($field) is-invalid @enderror"
                                        value="{{ old($field) }}"
                                        required
                                        @if($placeholder) placeholder="{{ $placeholder }}" @endif
                                        @if($inputType === 'number' && str_contains($field, 'ipk'))
                                            min="0" max="4" step="0.01"
                                        @elseif($inputType === 'number' && str_contains($field, 'semester'))
                                            min="1" max="14"
                                        @endif
                                    />
                                    @error($field)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Lampiran -->
                    <div class="mt-4">
                        <label class="form-label fw-semibold">
                            Lampiran <span class="text-muted fw-normal">(Opsional)</span>
                        </label>
                        <div class="border rounded p-3">
                            <input
                                type="file"
                                name="attachment"
                                class="form-control"
                                id="attachment"
                                accept=".pdf,.jpg,.jpeg,.png"
                            >
                            <small class="form-text text-muted mt-1 d-block">
                                <i class="ti ti-info-circle me-1"></i>
                                Format yang diterima: PDF, JPG, PNG &bull; Ukuran maksimal: 5 MB
                            </small>
                        </div>
                        <div id="preview-container" class="mt-3"></div>
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
                        <p class="text-muted mb-0">{{ $letterType->division->name ?? 'Kemahasiswaan' }}</p>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-4">
                    <div class="icon-shape icon-sm rounded-circle bg-warning-subtle text-warning me-3">
                        <i class="ti ti-checklist fs-5"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">Data yang Diperlukan</h6>
                        <ul class="list-unstyled mb-0">
                            @forelse($letterType->required_fields as $field)
                                <li class="mb-2 d-flex align-items-center">
                                    <i class="ti ti-point-filled text-primary me-2 fs-6"></i>
                                    <span class="text-muted">{{ ucwords(str_replace('_', ' ', $field)) }}</span>
                                </li>
                            @empty
                                <li class="text-muted">
                                    <i class="ti ti-info-circle me-2"></i> Tidak ada field tambahan
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="alert alert-info mb-0" role="alert">
                    <p class="mb-1 fw-semibold"><i class="ti ti-alert-circle me-1"></i> Catatan Penting</p>
                    <ul class="mb-0 ps-3 small">
                        <li>Pastikan data yang diisi sudah benar sebelum mengajukan.</li>
                        <li>Dokumen akan diverifikasi oleh divisi terkait.</li>
                        <li>Proses verifikasi membutuhkan waktu 1–3 hari kerja.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('attachment');
    const previewContainer = document.getElementById('preview-container');
    const MAX_SIZE_MB = 5;

    input.addEventListener('change', function (e) {
        const file = e.target.files[0];
        previewContainer.innerHTML = '';

        if (!file) return;

        if (file.size > MAX_SIZE_MB * 1024 * 1024) {
            previewContainer.innerHTML = `
                <div class="alert alert-danger mt-2">
                    <i class="ti ti-alert-circle me-2"></i>
                    Ukuran file melebihi ${MAX_SIZE_MB} MB. Silakan pilih file yang lebih kecil.
                </div>`;
            input.value = '';
            return;
        }

        const sizeKB      = (file.size / 1024).toFixed(1);
        const sizeMB      = (file.size / 1024 / 1024).toFixed(2);
        const displaySize = file.size > 1024 * 1024 ? `${sizeMB} MB` : `${sizeKB} KB`;
        const reader      = new FileReader();

        if (file.type.startsWith('image/')) {
            reader.onload = function (event) {
                previewContainer.innerHTML = `
                    <div class="border rounded p-2 d-flex align-items-center gap-3">
                        <img src="${event.target.result}" class="rounded"
                             style="height:80px;width:80px;object-fit:cover;" alt="Preview">
                        <div>
                            <p class="mb-0 fw-semibold">${file.name}</p>
                            <small class="text-muted">${displaySize} &bull; Gambar</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger ms-auto" onclick="clearFile()">
                            <i class="ti ti-x"></i>
                        </button>
                    </div>`;
            };
            reader.readAsDataURL(file);

        } else if (file.type === 'application/pdf') {
            previewContainer.innerHTML = `
                <div class="border rounded p-3 d-flex align-items-center gap-3">
                    <div class="icon-shape rounded bg-danger-subtle text-danger"
                         style="width:48px;height:48px;display:flex;align-items:center;justify-content:center;">
                        <i class="ti ti-file-type-pdf fs-3"></i>
                    </div>
                    <div>
                        <p class="mb-0 fw-semibold">${file.name}</p>
                        <small class="text-muted">${displaySize} &bull; PDF</small>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger ms-auto" onclick="clearFile()">
                        <i class="ti ti-x"></i>
                    </button>
                </div>`;
        } else {
            previewContainer.innerHTML = `
                <div class="alert alert-warning mt-2">
                    <i class="ti ti-alert-circle me-2"></i>
                    Format file tidak didukung. Gunakan PDF, JPG, atau PNG.
                </div>`;
            input.value = '';
        }
    });
});

function clearFile() {
    document.getElementById('attachment').value = '';
    document.getElementById('preview-container').innerHTML = '';
}
</script>
@endpush