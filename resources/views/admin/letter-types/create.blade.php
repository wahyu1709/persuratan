@extends('layouts.app')

@section('title', 'Tambah Jenis Surat')
@section('header', 'Tambah Jenis Surat')

@section('content')
<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.letter-types.store') }}">
                    @csrf

                    <div class="row g-4">

                        {{-- Nama Jenis Surat --}}
                        <div class="col-md-6">
                            <label class="form-label">Nama Jenis Surat <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}"
                                required
                                placeholder="Contoh: Surat Keterangan Aktif Mahasiswa"
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kode --}}
                        <div class="col-md-6">
                            <label class="form-label">Kode <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                name="code"
                                class="form-control @error('code') is-invalid @enderror"
                                value="{{ old('code') }}"
                                required
                                placeholder="Contoh: aktif_kuliah"
                            >
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Gunakan huruf kecil dan underscore, tanpa spasi.</small>
                        </div>

                        {{-- Divisi Tujuan --}}
                        <div class="col-md-6">
                            <label class="form-label">Divisi Tujuan <span class="text-danger">*</span></label>
                            <select name="division_id" class="form-select @error('division_id') is-invalid @enderror" required>
                                <option value="" disabled selected>-- Pilih Divisi --</option>
                                @foreach($divisions as $div)
                                    <option value="{{ $div->id }}" {{ old('division_id') == $div->id ? 'selected' : '' }}>
                                        {{ $div->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('division_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="col-md-6">
                            <label class="form-label d-block">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="active"
                                    id="active"
                                    value="1"
                                    {{ old('active', '1') ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="active">Aktif</label>
                            </div>
                        </div>

                        {{-- Field Wajib (dinamis) --}}
                        <div class="col-12">
                            <label class="form-label">Field Wajib</label>
                            <small class="form-text text-muted d-block mb-2">
                                Tiap field akan muncul sebagai input di form pengajuan mahasiswa. Gunakan huruf kecil dan underscore, contoh: <code>semester</code>, <code>tujuan_surat</code>.
                            </small>

                            <div id="fields-wrapper">
                                @if(old('required_fields'))
                                    @foreach(old('required_fields') as $oldField)
                                        <div class="input-group mb-2">
                                            <input
                                                type="text"
                                                name="required_fields[]"
                                                class="form-control"
                                                value="{{ $oldField }}"
                                                placeholder="Contoh: semester"
                                            >
                                            <button type="button" class="btn btn-outline-danger" onclick="removeField(this)">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="input-group mb-2">
                                        <input
                                            type="text"
                                            name="required_fields[]"
                                            class="form-control"
                                            placeholder="Contoh: semester"
                                        >
                                        <button type="button" class="btn btn-outline-danger" onclick="removeField(this)">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>

                            <button type="button" class="btn btn-outline-secondary btn-sm mt-1" onclick="addField()">
                                <i class="ti ti-plus me-1"></i> Tambah Field
                            </button>
                        </div>

                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Simpan Jenis Surat
                        </button>
                        <a href="{{ route('admin.letter-types.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function addField() {
    const wrapper = document.getElementById('fields-wrapper');
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" name="required_fields[]" class="form-control" placeholder="Contoh: tujuan_surat">
        <button type="button" class="btn btn-outline-danger" onclick="removeField(this)">
            <i class="ti ti-trash"></i>
        </button>
    `;
    wrapper.appendChild(div);
    // Focus ke input yang baru ditambahkan
    div.querySelector('input').focus();
}

function removeField(btn) {
    const wrapper = document.getElementById('fields-wrapper');
    if (wrapper.children.length > 1) {
        btn.closest('.input-group').remove();
    } else {
        // Jika hanya 1, kosongkan saja inputnya
        btn.closest('.input-group').querySelector('input').value = '';
    }
}
</script>
@endpush