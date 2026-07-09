@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold"><i class="fa-solid fa-calendar-alt text-matcha"></i> Periode Pemilihan</h3>
    <button class="btn btn-matcha fw-bold rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#tambahModal">
        <i class="fa-solid fa-plus me-2"></i> Tambah Periode
    </button>
</div>

<div class="card card-custom p-4">
    <div class="table-responsive">
        <table class="table table-hover datatable align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Periode</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($periode as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-bold">{{ $p->nama_periode }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d M Y H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_selesai)->format('d M Y H:i') }}</td>
                    <td>
                        @if($p->status == 'Aktif')
                            <span class="badge bg-success rounded-pill px-3 py-2"><i class="fa-solid fa-play"></i> Aktif</span>
                        @else
                            <span class="badge bg-secondary rounded-pill px-3 py-2"><i class="fa-solid fa-stop"></i> Selesai</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-sm btn-primary rounded-circle" data-bs-toggle="modal" data-bs-target="#editModal{{ $p->id }}"><i class="fa-solid fa-edit"></i></button>
                        <form action="{{ route('admin.periode.destroy', $p->id) }}" method="POST" class="d-inline" id="delete-form-{{ $p->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger rounded-circle" onclick="confirmDelete({{ $p->id }})"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@foreach($periode as $p)
<!-- Edit Modal -->
<div class="modal fade" id="editModal{{ $p->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.periode.update', $p->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header bg-matcha text-white">
                    <h5 class="modal-title fw-bold">Edit Periode</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Periode</label>
                        <input type="text" name="nama_periode" class="form-control" value="{{ $p->nama_periode }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="datetime-local" name="tanggal_mulai" class="form-control" value="{{ date('Y-m-d\TH:i', strtotime($p->tanggal_mulai)) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="datetime-local" name="tanggal_selesai" class="form-control" value="{{ date('Y-m-d\TH:i', strtotime($p->tanggal_selesai)) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="Aktif" {{ $p->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Selesai" {{ $p->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        <small class="text-danger">*Hanya satu periode yang dapat aktif.</small>
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

<!-- Tambah Modal -->
<div class="modal fade" id="tambahModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.periode.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-matcha text-white">
                    <h5 class="modal-title fw-bold">Tambah Periode Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Periode</label>
                        <input type="text" name="nama_periode" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="datetime-local" name="tanggal_mulai" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="datetime-local" name="tanggal_selesai" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="Aktif">Aktif</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-matcha rounded-pill px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Data?',
        text: "Periode yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#b5c7a3',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    })
}
</script>
@endpush
