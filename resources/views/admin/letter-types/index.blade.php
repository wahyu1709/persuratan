@extends('layouts.app')

@section('title', 'Manajemen Jenis Surat')
@section('header', 'Jenis Surat')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header border-bottom-0 pb-0 d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Daftar Jenis Surat</h4>
                <a href="{{ route('admin.letter-types.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i> Tambah Jenis Surat
                </a>
            </div>
            <div class="card-body p-0">
                @if($letterTypes->isEmpty())
                    <div class="text-center py-5">
                        <i class="ti ti-inbox fs-1 text-muted mb-3"></i>
                        <p class="text-muted">Belum ada jenis surat. Klik "Tambah Jenis Surat" untuk memulai.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover text-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Surat</th>
                                    <th>Kode</th>
                                    <th>Divisi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($letterTypes as $lt)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $lt->name }}</td>
                                        <td><code>{{ $lt->code }}</code></td>
                                        <td>{{ $lt->division->name ?? '-' }}</td>
                                        <td>
                                            <span class="badge {{ $lt->active ? 'bg-success' : 'bg-secondary' }} text-white">
                                                {{ $lt->active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.letter-types.edit', $lt) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.letter-types.destroy', $lt) }}" class="d-inline" onsubmit="return confirm('Yakin hapus jenis surat ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
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