@extends('layouts.app')

@section('title', 'Pilih Jenis Surat')
@section('header', 'Ajukan Surat')

@section('content')
<div class="row g-6">
    @foreach($letterTypes as $type)
        <div class="col-xl-6 col-lg-12">
            <a href="{{ route('letters.form', $type) }}" class="text-decoration-none">
                <div class="card card-lg h-100 hover-shadow hover-scale border-0">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center text-center p-6">
                        <div class="icon-shape icon-lg rounded-circle bg-primary-darker text-primary-lighter mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-text">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M14 3v4a1 1 0 0 0 1 1h4"/>
                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"/>
                                <path d="M9 13l6 0"/>
                                <path d="M9 17l6 0"/>
                            </svg>
                        </div>
                        <h5 class="mb-2 fw-bold">{{ $type->name }}</h5>
                        <p class="text-muted mb-0">Klik untuk mengajukan surat ini</p>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>
@endsection