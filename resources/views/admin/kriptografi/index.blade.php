@extends('layouts.admin')

@section('content')
{{-- =====================================================================
     HEADER
====================================================================== --}}
<div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
    <div>
        <h3 class="fw-bold mb-1">
            <i class="fa-solid fa-key text-warning me-2"></i>Analisis Kriptografi &amp; Kinerja
        </h3>
        <p class="text-muted small mb-0">
            Implementasi algoritma <strong>Blowfish-CBC</strong> pada Sistem E-Voting Politeknik Negeri Bengkalis.
        </p>
    </div>
    <span class="badge px-3 py-2 rounded-pill fs-6"
          style="background:linear-gradient(135deg,#86A775,#4a7c40);color:#fff;">
        <i class="fa-solid fa-shield-halved me-2"></i>Secured by Blowfish-CBC
    </span>
</div>

{{-- =====================================================================
     ALGO INFO BANNER
====================================================================== --}}
<div class="card border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
    <div class="card-body p-0">
        <div class="row g-0">
            <div class="col-12 p-3 d-flex flex-wrap gap-2 align-items-center"
                 style="background:linear-gradient(135deg,#f0f7ec,#e8f5e2);">
                <i class="fa-solid fa-microchip text-success fs-3 me-2"></i>
                @foreach($algoInfo as $label => $value)
                <div class="algo-chip">
                    <span class="algo-chip-key">{{ ucfirst(str_replace('_', ' ', $label)) }}</span>
                    <span class="algo-chip-val">{{ $value }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- =====================================================================
     ROW 1 — KEY MANAGEMENT + SIMULATOR
====================================================================== --}}
<div class="row g-3 mb-4">

    {{-- Key Management --}}
    <div class="col-md-5">
        <div class="card dash-card h-100" style="border-top:4px solid #f0b429;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="krip-icon me-3" style="background:#fff8e1;color:#f57f17;">
                        <i class="fa-solid fa-vault"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Pengelolaan Kunci</h5>
                        <small class="text-muted">Key Management (4.7)</small>
                    </div>
                </div>

                <form action="{{ route('admin.kriptografi.update-key') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-uppercase"
                               style="letter-spacing:.5px;">Secret Key (.env)</label>
                        <div class="input-group">
                            <input type="text" class="form-control font-monospace" name="key"
                                   id="keyInput" value="{{ $key }}" required minlength="4" maxlength="56">
                            <button class="btn btn-outline-secondary" type="button" onclick="generateKey()">
                                <i class="fa-solid fa-shuffle"></i>
                            </button>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <small class="text-muted">Min 4 / Max 56 karakter</small>
                            <small id="keyLen" class="text-muted">{{ strlen($key) }} chars</small>
                        </div>
                    </div>

                    <div class="alert alert-warning border-0 py-2 px-3 rounded-3 small mb-3">
                        <i class="fa-solid fa-triangle-exclamation me-1"></i>
                        Mengubah kunci membuat data lama <strong>tidak bisa didekripsi!</strong>
                    </div>

                    <button type="submit" class="btn w-100 fw-bold"
                            style="background:linear-gradient(135deg,#86A775,#6B8B5B);color:#fff;border:none;">
                        <i class="fa-solid fa-save me-2"></i>Perbarui Kunci
                    </button>
                </form>

                {{-- Statistik Dekripsi --}}
                <div class="row g-2 mt-3 text-center">
                    <div class="col-4">
                        <div class="p-2 rounded-3" style="background:#f0f7ec;border:1px solid #c6d9b5;">
                            <div class="fw-bold text-success">{{ $totalVoting }}</div>
                            <div style="font-size:.7rem;color:#555;">Total Data</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 rounded-3" style="background:#e8f5e9;border:1px solid #a5d6a7;">
                            <div class="fw-bold text-success">{{ $berhasilDekripsi }}</div>
                            <div style="font-size:.7rem;color:#555;">Berhasil</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 rounded-3" style="background:#ffebee;border:1px solid #ffcdd2;">
                            <div class="fw-bold text-danger">{{ $gagalDekripsi }}</div>
                            <div style="font-size:.7rem;color:#555;">Gagal</div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-2">
                    <small class="text-muted">Rata-rata waktu dekripsi:
                        <strong>{{ $rataRataDekripsi }} ms</strong> / record
                    </small>
                </div>
            </div>
        </div>
    </div>

    {{-- Simulator --}}
    <div class="col-md-7">
        <div class="card dash-card h-100" style="border-top:4px solid #86A775;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="krip-icon me-3" style="background:#e8f5e9;color:#2e7d32;">
                        <i class="fa-solid fa-flask"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Simulator Enkripsi/Dekripsi</h5>
                        <small class="text-muted">Uji coba algoritma langsung (4.4 / 5.5.1)</small>
                    </div>
                </div>

                <div class="d-flex gap-2 mb-3">
                    <input type="text" class="form-control" id="plain_text"
                           placeholder="Masukkan ID kandidat atau teks uji...">
                    <button id="simBtn" class="btn fw-bold px-4 flex-shrink-0"
                            style="background:linear-gradient(135deg,#86A775,#6B8B5B);color:#fff;border:none;"
                            onclick="runSimulation()">
                        <i class="fa-solid fa-play me-1"></i>Jalankan
                    </button>
                </div>

                <div id="simResult" style="display:none;">
                    {{-- Alur proses --}}
                    <div class="mb-3 p-3 rounded-3" style="background:#f8fdf5;border:1px solid #c6d9b5;">
                        <div class="fw-semibold small mb-2 text-success">
                            <i class="fa-solid fa-diagram-project me-1"></i>Alur Proses Enkripsi:
                        </div>
                        <div class="d-flex align-items-center gap-1 flex-wrap" style="font-size:.75rem;">
                            <span class="badge bg-secondary">Plaintext</span>
                            <i class="fa-solid fa-arrow-right text-muted"></i>
                            <span class="badge" style="background:#86A775;">Generate IV Acak</span>
                            <i class="fa-solid fa-arrow-right text-muted"></i>
                            <span class="badge" style="background:#4a7c40;">Blowfish-CBC Encrypt</span>
                            <i class="fa-solid fa-arrow-right text-muted"></i>
                            <span class="badge bg-warning text-dark">Base64(IV + Cipher)</span>
                            <i class="fa-solid fa-arrow-right text-muted"></i>
                            <span class="badge bg-danger">Simpan ke DB</span>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background:#fff5f5;border:1px solid #ffcdd2;">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-semibold small text-danger">
                                        <i class="fa-solid fa-lock me-1"></i>Ciphertext (DB)
                                    </span>
                                    <span class="badge bg-warning text-dark small">
                                        <i class="fa-solid fa-clock me-1"></i><span id="res_time_enc"></span> ms
                                    </span>
                                </div>
                                <code id="res_encrypted" class="small text-danger" style="word-break:break-all;"></code>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background:#f0fdf4;border:1px solid #a5d6a7;">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-semibold small text-success">
                                        <i class="fa-solid fa-unlock me-1"></i>Dekripsi Kembali
                                    </span>
                                    <span class="badge bg-success small">
                                        <i class="fa-solid fa-clock me-1"></i><span id="res_time_dec"></span> ms
                                    </span>
                                </div>
                                <code id="res_decrypted" class="text-success fw-bold fs-5"></code>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background:#e8f4fd;border:1px solid #90caf9;font-size:.75rem;">
                                <div class="fw-semibold mb-1 text-primary">
                                    <i class="fa-solid fa-vector-square me-1"></i>IV (Initialization Vector)
                                </div>
                                <code id="res_iv" class="text-primary" style="word-break:break-all;font-size:.72rem;"></code>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3" style="background:#fce4ec;border:1px solid #f48fb1;font-size:.75rem;">
                                <div class="fw-semibold mb-1 text-danger">
                                    <i class="fa-solid fa-binary me-1"></i>Ciphertext (Hex)
                                </div>
                                <code id="res_cipher_hex" class="text-danger" style="word-break:break-all;font-size:.72rem;"></code>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- =====================================================================
     ROW 2 — TABEL DATA SUARA TERENKRIPSI
====================================================================== --}}
<div class="card dash-card mb-4">
    <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
            <div class="d-flex align-items-center gap-3">
                <div class="krip-icon" style="background:#e3f2fd;color:#1565c0;">
                    <i class="fa-solid fa-database"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">Data Suara Terenkripsi di Database</h5>
                    <small class="text-muted">
                        Tabel <code>votings</code> — hanya menyimpan ciphertext, bukan data pilihan asli (4.3 / 5.1)
                    </small>
                </div>
            </div>
            <div class="text-end">
                <div class="badge rounded-pill px-3 py-2" style="background:#e3f2fd;color:#1565c0;font-size:.8rem;">
                    <i class="fa-solid fa-clock me-1"></i>
                    Rata-rata Dekripsi: <strong>{{ $rataRataDekripsi }} ms</strong>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover datatable align-middle" style="font-size:.85rem;">
                <thead>
                    <tr style="background:#f8fdf5;">
                        <th class="text-center" style="width:40px;">No</th>
                        <th>Pemilih</th>
                        <th>Waktu</th>
                        <th>Suara Terenkripsi (Ciphertext di DB)</th>
                        <th class="text-center">Kandidat ID <small class="text-muted">(Dekripsi)</small></th>
                        <th>Kandidat (Hasil Dekripsi)</th>
                        <th class="text-center">Waktu Dekripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($decryptedVotings as $index => $dv)
                    <tr>
                        <td class="text-center text-muted small">{{ $index + 1 }}</td>
                        <td>
                            <div class="fw-semibold">{{ $dv['user'] }}</div>
                            <code class="text-muted" style="font-size:.72rem;">{{ $dv['nim'] }}</code>
                        </td>
                        <td class="text-muted small">
                            {{ $dv['waktu_memilih'] ? \Carbon\Carbon::parse($dv['waktu_memilih'])->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td style="max-width:220px;">
                            <code class="text-danger" style="font-size:.7rem;word-break:break-all;">
                                {{ $dv['terenkripsi'] }}
                            </code>
                        </td>
                        <td class="text-center">
                            @if($dv['dekripsi'])
                                <span class="badge bg-success fs-6 px-3">{{ $dv['dekripsi'] }}</span>
                            @else
                                <span class="badge bg-danger">GAGAL</span>
                            @endif
                        </td>
                        <td>
                            @if($dv['dekripsi'])
                                <span class="fw-semibold small" style="color:#2e7d32;">
                                    <i class="fa-solid fa-circle-check me-1"></i>{{ $dv['nama_kandidat'] }}
                                </span>
                            @else
                                <span class="text-danger small">
                                    <i class="fa-solid fa-circle-xmark me-1"></i>Kunci tidak cocok
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge rounded-pill"
                                  style="background:#e8f4fd;color:#1565c0;font-size:.72rem;">
                                {{ $dv['waktu_ms'] }} ms
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.dash-card {
    border-radius: 16px !important;
    border: 1px solid rgba(0,0,0,.05) !important;
    box-shadow: 0 2px 16px rgba(0,0,0,.04) !important;
    transition: box-shadow .25s;
}
.dash-card:hover { box-shadow: 0 6px 24px rgba(0,0,0,.08) !important; }
.krip-icon {
    width: 42px; height: 42px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; flex-shrink: 0;
}
.algo-chip {
    display: inline-flex;
    flex-direction: column;
    background: #fff;
    border: 1px solid #c6d9b5;
    border-radius: 10px;
    padding: 5px 10px;
    font-size: .72rem;
}
.algo-chip-key {
    color: #888;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .4px;
    font-size: .65rem;
}
.algo-chip-val { color: #2d3748; font-weight: 700; }
.table thead th {
    font-size: .75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .4px;
    color: #666;
    border-bottom: 2px solid #e8f5e2;
}
</style>
@endpush

@push('scripts')
<script>
    // --- Key length counter ---
    document.getElementById('keyInput').addEventListener('input', function() {
        document.getElementById('keyLen').textContent = this.value.length + ' chars';
    });

    // --- Key generator ---
    function generateKey() {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()-_=+';
        let result = '';
        for (let i = 0; i < 24; i++) {
            result += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        const inp = document.getElementById('keyInput');
        inp.value = result;
        document.getElementById('keyLen').textContent = result.length + ' chars';
    }

    // --- Simulator ---
    function runSimulation() {
        const plainText = document.getElementById('plain_text').value.trim();
        if (!plainText) {
            alert('Masukkan teks terlebih dahulu!');
            return;
        }

        const btn = document.getElementById('simBtn');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i>Memproses...';
        btn.disabled = true;

        fetch('{{ route("admin.kriptografi.simulate") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ plain_text: plainText })
        })
        .then(r => r.json())
        .then(data => {
            document.getElementById('simResult').style.display = 'block';
            document.getElementById('res_encrypted').textContent   = data.encrypted;
            document.getElementById('res_decrypted').textContent   = data.decrypted;
            document.getElementById('res_time_enc').textContent    = data.time_enc_ms;
            document.getElementById('res_time_dec').textContent    = data.time_dec_ms;
            document.getElementById('res_iv').textContent          = data.iv_hex + ' (hex)';
            document.getElementById('res_cipher_hex').textContent  = data.cipher_hex + ' (hex)';

            btn.innerHTML = '<i class="fa-solid fa-play me-1"></i>Jalankan';
            btn.disabled = false;
        })
        .catch(() => {
            alert('Terjadi kesalahan saat simulasi!');
            btn.innerHTML = '<i class="fa-solid fa-play me-1"></i>Jalankan';
            btn.disabled = false;
        });
    }

    document.getElementById('plain_text').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') runSimulation();
    });
</script>
@endpush
