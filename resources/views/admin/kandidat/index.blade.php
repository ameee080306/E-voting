@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold"><i class="fa-solid fa-user-tie text-matcha"></i> Data Kandidat</h3>
    <button class="btn btn-matcha fw-bold rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#tambahModal">
        <i class="fa-solid fa-plus me-2"></i> Tambah Kandidat
    </button>
</div>

<div class="card card-custom p-4">
    <div class="table-responsive">
        <table class="table table-hover datatable align-middle">
            <thead class="table-light">
                <tr>
                    <th>No Urut</th>
                    <th>Foto</th>
                    <th>Ketua</th>
                    <th>Wakil Ketua</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kandidat as $k)
                <tr>
                    <td><span class="badge bg-dark rounded-circle p-2 fs-6">{{ $k->nomor_urut }}</span></td>
                    <td>
                        @if($k->foto)
                            <img src="{{ asset($k->foto) }}" alt="Foto Kandidat" class="rounded-circle border" style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-secondary text-white d-flex justify-content-center align-items-center" style="width: 50px; height: 50px;">
                                <i class="fa-solid fa-user"></i>
                            </div>
                        @endif
                    </td>
                    <td class="fw-bold">{{ $k->nama_ketua }}</td>
                    <td>{{ $k->nama_wakil }}</td>
                    <td>
                        <button class="btn btn-sm btn-info text-white rounded-circle" data-bs-toggle="modal" data-bs-target="#detailModal{{ $k->id }}"><i class="fa-solid fa-eye"></i></button>
                        <button class="btn btn-sm btn-primary rounded-circle" data-bs-toggle="modal" data-bs-target="#editModal{{ $k->id }}"><i class="fa-solid fa-edit"></i></button>
                        <form action="{{ route('admin.kandidat.destroy', $k->id) }}" method="POST" class="d-inline" id="delete-form-{{ $k->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger rounded-circle" onclick="confirmDelete({{ $k->id }})"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modals Detail & Edit -->
@foreach($kandidat as $k)
    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal{{ $k->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title fw-bold">Detail Kandidat No. {{ $k->nomor_urut }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center p-4">
                    @if($k->foto)
                        <img src="{{ asset($k->foto) }}" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit:cover;">
                    @endif
                    <h4>{{ $k->nama_ketua }} <span class="text-muted fs-5">& {{ $k->nama_wakil }}</span></h4>
                    <hr>
                    <div class="text-start mt-3">
                        <h5 class="fw-bold">Visi:</h5>
                        <p>{{ $k->visi }}</p>
                        <h5 class="fw-bold mt-3">Misi:</h5>
                        <div>{!! nl2br(e($k->misi)) !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal{{ $k->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('admin.kandidat.update', $k->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-matcha text-white">
                        <h5 class="modal-title fw-bold">Edit Kandidat</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor Urut</label>
                                <input type="number" name="nomor_urut" class="form-control" value="{{ $k->nomor_urut }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Foto Kandidat (Kosongkan jika tidak diubah)</label>
                                <input type="file" name="foto" class="form-control" accept="image/*">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Ketua</label>
                                <input type="text" name="nama_ketua" class="form-control" value="{{ $k->nama_ketua }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Wakil Ketua</label>
                                <input type="text" name="nama_wakil" class="form-control" value="{{ $k->nama_wakil }}" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Visi</label>
                                <textarea name="visi" class="form-control" rows="3" required>{{ $k->visi }}</textarea>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Misi</label>
                                <textarea name="misi" class="form-control" rows="5" required>{{ $k->misi }}</textarea>
                            </div>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.kandidat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-matcha text-white">
                    <h5 class="modal-title fw-bold">Tambah Kandidat Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nomor Urut</label>
                            <input type="number" name="nomor_urut" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Foto Kandidat</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Ketua</label>
                            <input type="text" name="nama_ketua" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Wakil Ketua</label>
                            <input type="text" name="nama_wakil" class="form-control" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Visi</label>
                            <textarea name="visi" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Misi</label>
                            <textarea name="misi" class="form-control" rows="5" required></textarea>
                        </div>
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
        text: "Kandidat yang dihapus tidak dapat dikembalikan!",
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
