@extends('layouts.mahasiswa')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8 text-center">
        <div class="card card-custom p-5">
            <div class="display-1 text-warning mb-4">
                <i class="fa-solid fa-lock"></i>
            </div>
            <h2 class="fw-bold mb-3">Hasil Pemilihan Belum Tersedia</h2>
            <p class="text-secondary lead">Periode pemilihan <strong>{{ $periode->nama_periode }}</strong> masih berlangsung. Hasil perolehan suara hanya dapat dilihat setelah admin menutup periode pemilihan.</p>
        </div>
    </div>
</div>
@endsection
