@extends('layouts.mahasiswa')

@section('content')
<h2 class="mb-4">Profil Saya</h2>

<div class="row">
    <div class="col-md-6">
        <div class="card card-custom p-4">
            <form action="{{ route('mahasiswa.profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="text-center mb-4">
                    @if(auth()->user()->foto)
                        <img src="{{ asset(auth()->user()->foto) }}" alt="Foto Profil" class="rounded-circle mb-3 shadow-sm" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid var(--matcha-dark);">
                    @else
                        <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 120px; height: 120px; border: 3px solid var(--matcha-dark);">
                            <i class="fa-solid fa-user text-white" style="font-size: 3rem;"></i>
                        </div>
                    @endif
                    <div>
                        <label for="foto" class="form-label d-block fw-bold">Ganti Foto Profil</label>
                        <input type="file" class="form-control form-control-sm mx-auto" id="foto" name="foto" style="max-width: 250px;" accept="image/*">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">NIM</label>
                    <input type="text" class="form-control" value="{{ \App\Services\BlowfishService::decrypt(auth()->user()->nim) ?: auth()->user()->nim }}" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Email</label>
                    <input type="text" class="form-control" value="{{ \App\Services\BlowfishService::decrypt(auth()->user()->email) ?: auth()->user()->email }}" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" value="{{ auth()->user()->nama }}" required>
                </div>
                <hr>
                <h5 class="mb-3">Ubah Password (Opsional)</h5>
                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-control" placeholder="Biarkan kosong jika tidak ingin mengubah">
                </div>
                <div class="mb-4">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
                <button type="submit" class="btn btn-matcha fw-bold rounded-pill px-4">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>
@endsection
