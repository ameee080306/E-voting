@extends('layouts.app')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-5">
        <div class="card card-custom p-4">
            <h3 class="text-center fw-bold mb-4">Login E-Voting</h3>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email atau NIM</label>
                    <input type="text" name="login" class="form-control" required value="{{ old('login') }}" placeholder="Masukkan Email atau NIM">
                </div>
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required placeholder="Masukkan Password">
                </div>
                <button type="submit" class="btn btn-matcha w-100 py-2 fw-bold rounded-pill">Masuk</button>
            </form>
            <div class="text-center mt-3">
                <small>Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none">Daftar sekarang</a></small>
            </div>
        </div>
    </div>
</div>
@endsection
