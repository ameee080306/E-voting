@extends('layouts.mahasiswa')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-md-8">
        <h2 class="fw-bold">Pemungutan Suara</h2>
        <p class="text-secondary">Pilih salah satu kandidat di bawah ini. Anda hanya dapat memilih satu kali.</p>
    </div>
</div>

<div class="row g-4">
    @forelse($kandidats as $kandidat)
    <div class="col-md-6">
        <div class="card card-custom h-100">
            <div class="card-header bg-dark text-white text-center py-3">
                <h4 class="mb-0 fw-bold">Kandidat No. {{ $kandidat->nomor_urut }}</h4>
            </div>
            <div class="card-body text-center p-4">
                @if($kandidat->foto)
                    <img src="{{ asset($kandidat->foto) }}" alt="Foto Kandidat" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover; border: 5px solid var(--matcha-soft);">
                @else
                    <div class="rounded-circle bg-secondary d-flex justify-content-center align-items-center text-white mx-auto mb-3" style="width: 150px; height: 150px; font-size: 50px;">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                @endif
                <h5 class="fw-bold text-primary">{{ $kandidat->nama_ketua }}</h5>
                <h5 class="fw-bold text-success mt-2">{{ $kandidat->nama_wakil }}</h5>
                
                <hr>
                
                <form action="{{ route('mahasiswa.voting.store') }}" method="POST" id="form-voting-{{ $kandidat->id }}">
                    @csrf
                    <input type="hidden" name="kandidat_id" value="{{ $kandidat->id }}">
                    <button type="button" class="btn btn-matcha btn-lg rounded-pill w-100 fw-bold mt-3" onclick="confirmVoting({{ $kandidat->id }})">
                        <i class="fa-solid fa-check-to-slot me-2"></i> Pilih Kandidat Ini
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <h4 class="text-muted">Belum ada data kandidat.</h4>
    </div>
    @endforelse
</div>
@endsection

@push('scripts')
<script>
function confirmVoting(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Anda tidak dapat mengubah pilihan setelah menyimpan suara!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#b5c7a3',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Pilih!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-voting-' + id).submit();
        }
    })
}
</script>
@endpush
