@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold"><i class="fa-solid fa-person-booth text-matcha"></i> Data Voting (Log Pemilih)</h3>
    <p class="text-secondary">Daftar mahasiswa yang telah memberikan hak suaranya. Nilai suara dienkripsi menggunakan Blowfish.</p>
</div>

<div class="card card-custom p-4">
    <div class="table-responsive">
        <table class="table table-hover datatable align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Waktu Memilih</th>
                    <th>Suara Terenkripsi (Blowfish)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($voting as $v)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $v->user->nim }}</td>
                    <td class="fw-bold">{{ $v->user->nama }}</td>
                    <td>{{ \Carbon\Carbon::parse($v->waktu_memilih)->format('d M Y H:i:s') }}</td>
                    <td><code class="bg-light p-2 rounded text-dark">{{ $v->suara_terenkripsi }}</code></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
