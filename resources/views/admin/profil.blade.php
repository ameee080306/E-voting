@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold"><i class="fa-solid fa-user-gear me-2"></i> Pengaturan Profil Admin</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card card-custom p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="text-center mb-4">
                        @if($user->foto)
                            <img src="{{ asset($user->foto) }}" alt="Foto Profil" class="rounded-circle mb-3 shadow-sm" style="width: 150px; height: 150px; object-fit: cover; border: 3px solid var(--matcha-dark);">
                        @else
                            <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 150px; height: 150px; border: 3px solid var(--matcha-dark);">
                                <i class="fa-solid fa-user text-white" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                        <div>
                            <label for="foto" class="form-label d-block fw-bold">Ubah Foto Profil</label>
                            <input type="file" class="form-control form-control-sm mx-auto" id="foto" name="foto" style="max-width: 300px;" accept="image/*">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $user->nama) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">Password Baru <span class="text-muted fw-normal">(Kosongkan jika tidak ingin mengubah)</span></label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>

                    <button type="submit" class="btn btn-matcha w-100 py-2 fs-5">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
