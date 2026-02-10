@extends('layouts.app')

@section('title', 'Ajukan Surat')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Ajukan Surat Baru</h2>
        <a href="{{ route('letters.my') }}" class="btn btn-outline-secondary">← Riwayat Surat</a>
    </div>

    <form action="{{ route('letters.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Pilih Jenis Surat -->
        <div class="mb-4">
            <label class="form-label fw-bold">Jenis Surat</label>
            <select name="letter_type_id" id="letterTypeSelect" class="form-select" required>
                <option value="">-- Pilih Jenis Surat --</option>
                @foreach($letterTypes as $type)
                    <option value="{{ $type->id }}" data-fields="{{ json_encode($type->required_fields) }}">
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Field Dinamis (akan diisi via JS) -->
        <div id="dynamicFields" class="mb-4"></div>

        <!-- Lampiran (Opsional) -->
        <div class="mb-4">
            <label class="form-label">Lampiran (Opsional)</label>
            <input type="file" name="attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
            <small class="text-muted">Format: PDF, JPG, PNG (max 5MB)</small>
        </div>

        <!-- Submit -->
        <div class="d-grid">
            <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                Ajukan Surat
            </button>
        </div>
    </form>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const select = document.getElementById('letterTypeSelect');
            const dynamicFields = document.getElementById('dynamicFields');
            const submitBtn = document.getElementById('submitBtn');

            select.addEventListener('change', function () {
                dynamicFields.innerHTML = '';
                const selectedOption = this.options[this.selectedIndex];
                const fields = JSON.parse(selectedOption.dataset.fields || '[]');

                if (fields.length === 0) {
                    submitBtn.disabled = false;
                    return;
                }

                fields.forEach(field => {
                    const label = field.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                    dynamicFields.innerHTML += `
                        <div class="mb-3">
                            <label class="form-label">${label} *</label>
                            <input type="text" name="${field}" class="form-control" required>
                        </div>
                    `;
                });

                submitBtn.disabled = false;
            });
        });
    </script>
    @endpush
@endsection