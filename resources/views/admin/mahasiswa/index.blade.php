@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold"><i class="fa-solid fa-users text-matcha"></i> Data Mahasiswa</h3>
</div>

<div class="card card-custom p-4">
    <div class="table-responsive">
        <table class="table table-hover datatable align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Status Memilih</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mahasiswa as $mhs)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $mhs->nim }}</td>
                    <td>{{ $mhs->nama }}</td>
                    <td>{{ $mhs->email }}</td>
                    <td>
                        @if($mhs->status_memilih)
                            <span class="badge bg-success rounded-pill px-3 py-2"><i class="fa-solid fa-check"></i> Sudah</span>
                        @else
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2"><i class="fa-solid fa-xmark"></i> Belum</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-sm btn-primary rounded-circle" data-bs-toggle="modal" data-bs-target="#editModal{{ $mhs->id }}"><i class="fa-solid fa-edit"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@foreach($mahasiswa as $mhs)
<!-- Edit Modal -->
<div class="modal fade" id="editModal{{ $mhs->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.mahasiswa.update', $mhs->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-matcha text-white">
                    <h5 class="modal-title fw-bold">Edit Mahasiswa</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">NIM (Terenkripsi)</label>
                        <input type="text" class="form-control" value="{{ $mhs->nim }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email (Terenkripsi)</label>
                        <input type="text" class="form-control" value="{{ $mhs->email }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="{{ $mhs->nama }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Baru (Opsional)</label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-matcha rounded-pill px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach


@endsection
