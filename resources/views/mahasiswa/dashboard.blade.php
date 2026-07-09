@extends('layouts.mahasiswa')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-md-8">
        <h2 class="fw-bold">Selamat Datang, {{ auth()->user()->nama }}</h2>
        <p class="text-secondary">Dashboard Mahasiswa E-Voting. Gunakan hak suara Anda dengan bijak!</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card card-custom p-4 h-100">
            <h5 class="fw-bold text-success mb-3"><i class="fa-solid fa-calendar-check me-2"></i> Status Periode Pemilihan</h5>
            @if($periode)
                <div class="alert alert-success">
                    <strong>{{ $periode->nama_periode }}</strong> sedang aktif.<br>
                    <small>Berlangsung hingga: {{ \Carbon\Carbon::parse($periode->tanggal_selesai)->format('d M Y H:i') }}</small>
                </div>
            @else
                <div class="alert alert-secondary">
                    Saat ini tidak ada periode pemilihan yang sedang aktif.
                </div>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-custom p-4 h-100 text-center">
            <h5 class="fw-bold text-primary mb-3"><i class="fa-solid fa-user-check me-2"></i> Status Hak Suara Anda</h5>
            @if(auth()->user()->status_memilih == 1)
                <div class="display-4 text-success mb-2"><i class="fa-solid fa-circle-check"></i></div>
                <h4 class="fw-bold text-success">Sudah Memilih</h4>
                <p class="text-secondary">Terima kasih telah berpartisipasi dalam pemilihan ini.</p>
            @else
                <div class="display-4 text-warning mb-2"><i class="fa-solid fa-circle-exclamation"></i></div>
                <h4 class="fw-bold text-warning">Belum Memilih</h4>
                <p class="text-secondary">Anda belum menggunakan hak suara. Segera berikan suara Anda!</p>
                @if($periode)
                    <a href="{{ route('mahasiswa.voting.index') }}" class="btn btn-matcha rounded-pill px-4">Mulai Voting Sekarang</a>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
