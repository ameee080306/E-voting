@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold"><i class="fa-solid fa-file-pdf text-matcha"></i> Laporan Pemilihan</h3>
        <p class="text-secondary">Ringkasan pelaksanaan e-voting.</p>
    </div>
    <button onclick="window.print()" class="btn btn-primary fw-bold rounded-pill px-4">
        <i class="fa-solid fa-print me-2"></i> Cetak Laporan
    </button>
</div>

<div class="card card-custom p-4 mb-4" id="laporan-area">
    <div class="text-center mb-4">
        <h2 class="fw-bold">Laporan Pelaksanaan E-Voting</h2>
        @if($periodeTerakhir)
            <h4>Periode: {{ $periodeTerakhir->nama_periode }}</h4>
            <p>Tanggal: {{ \Carbon\Carbon::parse($periodeTerakhir->tanggal_mulai)->format('d F Y') }} - {{ \Carbon\Carbon::parse($periodeTerakhir->tanggal_selesai)->format('d F Y') }}</p>
        @endif
        <hr>
    </div>

    <div class="row mb-4 text-center">
        <div class="col-md-4">
            <h5 class="fw-bold">Total Mahasiswa Terdaftar</h5>
            <h3>{{ $totalMahasiswa }}</h3>
        </div>
        <div class="col-md-4">
            <h5 class="fw-bold text-success">Sudah Memilih (Partisipasi)</h5>
            <h3 class="text-success">{{ $sudahMemilih }} ({{ $totalMahasiswa > 0 ? round(($sudahMemilih/$totalMahasiswa)*100, 2) : 0 }}%)</h3>
        </div>
        <div class="col-md-4">
            <h5 class="fw-bold text-danger">Belum Memilih (Golput)</h5>
            <h3 class="text-danger">{{ $belumMemilih }} ({{ $totalMahasiswa > 0 ? round(($belumMemilih/$totalMahasiswa)*100, 2) : 0 }}%)</h3>
        </div>
    </div>

    <h4 class="fw-bold mb-3">Hasil Perolehan Suara:</h4>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-light text-center">
                <tr>
                    <th>No Urut</th>
                    <th>Nama Pasangan Kandidat</th>
                    <th>Perolehan Suara</th>
                    <th>Persentase</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasil as $h)
                <tr>
                    <td class="text-center">{{ $h->kandidat->nomor_urut }}</td>
                    <td>{{ $h->kandidat->nama_ketua }} & {{ $h->kandidat->nama_wakil }}</td>
                    <td class="text-center fw-bold">{{ $h->jumlah_suara }}</td>
                    <td class="text-center">{{ $sudahMemilih > 0 ? round(($h->jumlah_suara / $sudahMemilih) * 100, 2) : 0 }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-5 text-end">
        <p>Mengetahui,</p>
        <br><br><br>
        <p class="fw-bold mb-0">Panitia Pemilihan</p>
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    #laporan-area, #laporan-area * {
        visibility: visible;
    }
    #laporan-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    .btn {
        display: none !important;
    }
}
</style>
@endsection
