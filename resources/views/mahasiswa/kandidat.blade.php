@extends('layouts.mahasiswa')

@section('content')
<h2 class="mb-4">Daftar Kandidat</h2>

<div class="row g-4">
    @forelse($kandidats as $kandidat)
    <div class="col-md-6">
        <div class="card card-custom h-100">
            <div class="card-header bg-dark text-white text-center py-3">
                <h4 class="mb-0 fw-bold">Kandidat No. {{ $kandidat->nomor_urut }}</h4>
            </div>
            <div class="card-body text-center p-4">
                @if($kandidat->foto)
                    <img src="{{ asset($kandidat->foto) }}" alt="Foto Kandidat" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover; border: 5px solid var(--matcha-soft);">
                @else
                    <div class="rounded-circle bg-secondary d-flex justify-content-center align-items-center text-white mx-auto mb-3" style="width: 150px; height: 150px; font-size: 50px;">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                @endif
                <h5 class="fw-bold text-primary">{{ $kandidat->nama_ketua }}</h5>
                <p class="mb-1">sebagai Ketua</p>
                <h5 class="fw-bold text-success mt-3">{{ $kandidat->nama_wakil }}</h5>
                <p class="mb-3">sebagai Wakil Ketua</p>

                <hr>
                
                <h6 class="fw-bold text-start">Visi:</h6>
                <p class="text-start text-secondary">{{ $kandidat->visi }}</p>
                
                <h6 class="fw-bold text-start mt-3">Misi:</h6>
                <div class="text-start text-secondary">
                    {!! nl2br(e($kandidat->misi)) !!}
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <h4 class="text-muted">Belum ada data kandidat.</h4>
    </div>
    @endforelse
</div>
@endsection
