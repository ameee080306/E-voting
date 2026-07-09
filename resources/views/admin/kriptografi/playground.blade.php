@extends('layouts.admin')

@section('content')

{{-- ===== HEADER ===== --}}
<div class="pg-hero mb-4">
    <div class="pg-hero-inner">
        <div class="d-flex align-items-center gap-3 mb-2">
            <div class="pg-hero-icon">
                <i class="fa-solid fa-flask-vial"></i>
            </div>
            <div>
                <h2 class="fw-bold mb-0" style="color:#fff;">🔐 Blowfish Playground</h2>
                <p class="mb-0" style="color:rgba(255,255,255,.8);font-size:.9rem;">
                    Uji coba enkripsi & dekripsi Blowfish-CBC secara langsung — lihat setiap langkah proses secara visual
                </p>
            </div>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <span class="pg-badge"><i class="fa-solid fa-lock me-1"></i>bf-cbc</span>
            <span class="pg-badge"><i class="fa-solid fa-vector-square me-1"></i>IV Acak 8 byte</span>
            <span class="pg-badge"><i class="fa-solid fa-rotate me-1"></i>16 Rounds Feistel</span>
            <span class="pg-badge"><i class="fa-solid fa-key me-1"></i>Key: {{ strlen($key) * 8 }} bit</span>
        </div>
    </div>
</div>

<div class="row g-4">

    {{-- ===== PANEL KIRI: INPUT ===== --}}
    <div class="col-lg-5">

        {{-- Input Panel --}}
        <div class="pg-card mb-4" id="inputPanel">
            <div class="pg-card-header">
                <i class="fa-solid fa-keyboard me-2"></i>Input Teks
            </div>
            <div class="pg-card-body">
                <label class="pg-label">Teks yang akan dienkripsi</label>
                <textarea id="inputText" class="pg-textarea" rows="3"
                    placeholder="Contoh: kandidat_id = 2&#10;Atau teks apa saja...">2</textarea>

                <div class="pg-preset-row">
                    <span class="pg-preset-label">Contoh cepat:</span>
                    <button class="pg-preset" onclick="setPreset('1')">ID Kandidat 1</button>
                    <button class="pg-preset" onclick="setPreset('2')">ID Kandidat 2</button>
                    <button class="pg-preset" onclick="setPreset('3')">ID Kandidat 3</button>
                    <button class="pg-preset" onclick="setPreset('Rahasia123')">Teks Bebas</button>
                </div>

                <div class="mt-3">
                    <label class="pg-label">Secret Key (dari server .env)</label>
                    <div class="pg-key-display">
                        <i class="fa-solid fa-shield-halved text-warning me-2"></i>
                        <code id="keyDisplay">{{ $key }}</code>
                        <span class="pg-key-badge">{{ strlen($key) * 8 }} bit</span>
                    </div>
                    <small class="text-muted">Kunci ini disimpan di server — pengguna tidak bisa mengubahnya</small>
                </div>

                <button id="encBtn" class="pg-run-btn mt-4 w-100" onclick="runEncrypt()">
                    <i class="fa-solid fa-play me-2"></i>Jalankan Enkripsi Blowfish
                </button>
                <button id="decBtn" class="pg-dec-btn mt-2 w-100" onclick="runDecrypt()" style="display:none;">
                    <i class="fa-solid fa-lock-open me-2"></i>Dekripsi Kembali
                </button>
            </div>
        </div>

        {{-- Info Algoritma --}}
        <div class="pg-card">
            <div class="pg-card-header">
                <i class="fa-solid fa-circle-info me-2"></i>Spesifikasi Algoritma
            </div>
            <div class="pg-card-body p-0">
                <table class="table table-sm mb-0" style="font-size:.82rem;">
                    @foreach($algoInfo as $k => $v)
                    <tr>
                        <td class="ps-3 py-2 text-muted fw-semibold" style="width:45%;border-bottom:1px solid #f0f0f0;">
                            {{ ucfirst(str_replace('_', ' ', $k)) }}
                        </td>
                        <td class="py-2 pe-3" style="border-bottom:1px solid #f0f0f0;">
                            <code style="color:#2e7d32;font-size:.8rem;">{{ $v }}</code>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    {{-- ===== PANEL KANAN: VISUALISASI ===== --}}
    <div class="col-lg-7">

        {{-- Placeholder sebelum run --}}
        <div id="emptyState" class="pg-empty">
            <div class="pg-empty-icon">🔒</div>
            <h5 class="fw-bold text-muted">Siap untuk diuji!</h5>
            <p class="text-muted small">Masukkan teks di panel kiri, lalu klik<br><strong>"Jalankan Enkripsi Blowfish"</strong></p>
        </div>

        {{-- HASIL (awalnya tersembunyi) --}}
        <div id="resultArea" style="display:none;">

            {{-- Step 1: Plaintext --}}
            <div class="pg-step step-animate" id="step1">
                <div class="pg-step-header step-plain">
                    <span class="pg-step-num">1</span>
                    <i class="fa-solid fa-file-lines me-2"></i>Plaintext (Data Asli)
                </div>
                <div class="pg-step-body">
                    <div class="pg-mono-box" id="s1_plain"></div>
                    <div class="pg-stat-row">
                        <span>Panjang: <code id="s1_len"></code> karakter</span>
                        <span>Ini yang <strong>TIDAK</strong> disimpan ke database</span>
                    </div>
                </div>
            </div>

            <div class="pg-arrow">↓</div>

            {{-- Step 2: Generate IV --}}
            <div class="pg-step step-animate" id="step2">
                <div class="pg-step-header step-iv">
                    <span class="pg-step-num">2</span>
                    <i class="fa-solid fa-dice me-2"></i>Generate IV Acak (Initialization Vector)
                </div>
                <div class="pg-step-body">
                    <div class="d-flex align-items-start gap-3">
                        <div class="flex-grow-1">
                            <div class="pg-label-mini">IV dalam Hexadecimal (64-bit = 8 byte = 16 hex chars)</div>
                            <div class="pg-mono-box pg-mono-blue" id="s2_iv"></div>
                        </div>
                        <div class="pg-iv-viz" id="ivBytesViz"></div>
                    </div>
                    <div class="pg-info-box mt-2">
                        <i class="fa-solid fa-lightbulb text-warning me-1"></i>
                        IV dibuat <strong>acak baru</strong> setiap enkripsi → ciphertext selalu berbeda meski plaintext sama!
                    </div>
                </div>
            </div>

            <div class="pg-arrow">↓</div>

            {{-- Step 3: Feistel --}}
            <div class="pg-step step-animate" id="step3">
                <div class="pg-step-header step-feistel">
                    <span class="pg-step-num">3</span>
                    <i class="fa-solid fa-rotate me-2"></i>Blowfish-CBC Encryption (16 Rounds Feistel Network)
                </div>
                <div class="pg-step-body">
                    {{-- Feistel visual --}}
                    <div class="pg-feistel" id="feistelViz">
                        <div class="pf-block">
                            <div class="pf-label">Plaintext Block</div>
                            <div class="pf-box pf-in" id="pf_in">—</div>
                        </div>
                        <div class="pf-arrow-col">
                            <div class="pf-rounds-col" id="roundsViz">
                                <!-- rounds akan di-generate JS -->
                            </div>
                        </div>
                        <div class="pf-block">
                            <div class="pf-label">Ciphertext Block</div>
                            <div class="pf-box pf-out" id="pf_out">—</div>
                        </div>
                    </div>
                    <div class="pg-stat-row mt-2">
                        <span><i class="fa-solid fa-clock text-warning me-1"></i>Waktu enkripsi: <strong id="s3_time"></strong> ms</span>
                        <span>Mode: CBC (XOR antar blok)</span>
                    </div>
                </div>
            </div>

            <div class="pg-arrow">↓</div>

            {{-- Step 4: Output --}}
            <div class="pg-step step-animate" id="step4">
                <div class="pg-step-header step-cipher">
                    <span class="pg-step-num">4</span>
                    <i class="fa-solid fa-database me-2"></i>Ciphertext — Yang Tersimpan di Database
                </div>
                <div class="pg-step-body">
                    <div class="pg-label-mini">Format: Base64( IV (8 byte) || Ciphertext raw )</div>
                    <div class="pg-mono-box pg-mono-red" id="s4_cipher" style="word-break:break-all;"></div>

                    <div class="row g-2 mt-2">
                        <div class="col-6">
                            <div class="pg-mini-card" style="border-color:#bbdefb;">
                                <div class="pg-mini-label" style="color:#1565c0;">IV bagian (hex)</div>
                                <code id="s4_iv_part" class="text-primary" style="font-size:.7rem;word-break:break-all;"></code>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="pg-mini-card" style="border-color:#ffcdd2;">
                                <div class="pg-mini-label" style="color:#c62828;">Cipher bagian (hex)</div>
                                <code id="s4_cipher_part" class="text-danger" style="font-size:.7rem;word-break:break-all;"></code>
                            </div>
                        </div>
                    </div>

                    <div class="pg-stat-row mt-2">
                        <span>Panjang ciphertext: <code id="s4_len"></code> karakter</span>
                        <button class="btn btn-sm" id="copyBtn"
                                style="background:#e8f5e9;color:#2e7d32;border:1px solid #a5d6a7;font-size:.75rem;"
                                onclick="copyToClipboard()">
                            <i class="fa-solid fa-copy me-1"></i>Salin
                        </button>
                    </div>
                </div>
            </div>

            {{-- Step 5: Dekripsi (muncul saat klik tombol dekripsi) --}}
            <div id="decryptSection" style="display:none;">
                <div class="pg-arrow">↓</div>
                <div class="pg-step step-animate" id="step5">
                    <div class="pg-step-header step-decrypt">
                        <span class="pg-step-num">5</span>
                        <i class="fa-solid fa-lock-open me-2"></i>Hasil Dekripsi (Hanya Admin)
                    </div>
                    <div class="pg-step-body">
                        <div class="pg-success-box">
                            <div class="pg-success-icon">✅</div>
                            <div>
                                <div class="pg-label-mini mb-1">Plaintext berhasil dipulihkan:</div>
                                <div class="pg-mono-box pg-mono-green" id="s5_result"></div>
                                <div class="pg-stat-row mt-2">
                                    <span><i class="fa-solid fa-clock text-success me-1"></i>Waktu dekripsi: <strong id="s5_time"></strong> ms</span>
                                    <span class="text-success fw-semibold"><i class="fa-solid fa-check me-1"></i>Data asli berhasil dipulihkan!</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Perbandingan enkripsi berulang --}}
            <div class="pg-card mt-4" id="compareCard" style="display:none;">
                <div class="pg-card-header" style="background:linear-gradient(135deg,#fff3e0,#ffe0b2);color:#e65100;">
                    <i class="fa-solid fa-not-equal me-2"></i>Bukti: Plaintext Sama → Ciphertext Berbeda (Karena IV Acak)
                </div>
                <div class="pg-card-body">
                    <div class="pg-label-mini mb-2">Enkripsi teks "<span id="cmpText"></span>" sebanyak 3x:</div>
                    <div id="compareList" class="d-flex flex-column gap-2"></div>
                    <div class="pg-info-box mt-2" style="background:#fff3e0;border-color:#ffcc80;">
                        <i class="fa-solid fa-shield-halved text-warning me-1"></i>
                        Inilah keunggulan <strong>mode CBC + IV acak</strong> dibanding ECB — tidak ada pola yang bisa dianalisis!
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
/* ======================== HERO ======================== */
.pg-hero {
    background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 50%, #004d40 100%);
    border-radius: 20px;
    padding: 2px;
    box-shadow: 0 8px 32px rgba(46,125,50,.25);
}
.pg-hero-inner {
    background: linear-gradient(135deg, rgba(255,255,255,.06), rgba(255,255,255,.02));
    border-radius: 18px;
    padding: 1.5rem 2rem;
}
.pg-hero-icon {
    width: 56px; height: 56px;
    background: rgba(255,255,255,.15);
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.6rem; color:#fff; flex-shrink:0;
}
.pg-badge {
    background: rgba(255,255,255,.18);
    color: #fff;
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 20px;
    padding: 3px 12px;
    font-size: .78rem;
    font-weight: 600;
}

/* ======================== CARDS ======================== */
.pg-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid rgba(0,0,0,.06);
    box-shadow: 0 2px 16px rgba(0,0,0,.04);
    overflow: hidden;
    transition: box-shadow .25s;
}
.pg-card:hover { box-shadow: 0 6px 24px rgba(0,0,0,.08); }
.pg-card-header {
    background: linear-gradient(135deg, #f8fdf5, #edf7e8);
    padding: .85rem 1.25rem;
    font-weight: 700;
    font-size: .88rem;
    color: #2e7d32;
    border-bottom: 1px solid #e0f0d8;
}
.pg-card-body { padding: 1.25rem; }

/* ======================== INPUT ======================== */
.pg-label { font-size:.82rem; font-weight:700; color:#444; margin-bottom:.4rem; display:block; }
.pg-label-mini { font-size:.75rem; font-weight:600; color:#888; margin-bottom:.3rem; text-transform:uppercase; letter-spacing:.4px; }
.pg-textarea {
    width:100%; border:2px solid #e0f0d8; border-radius:12px;
    padding:.75rem 1rem; font-family:monospace; font-size:.92rem;
    resize:vertical; outline:none; transition:border .2s;
}
.pg-textarea:focus { border-color:#86A775; box-shadow:0 0 0 3px rgba(134,167,117,.15); }

.pg-preset-row { display:flex; flex-wrap:wrap; gap:6px; margin-top:.75rem; align-items:center; }
.pg-preset-label { font-size:.72rem; color:#999; font-weight:600; }
.pg-preset {
    background:#f0f7ec; color:#2e7d32; border:1px solid #c6d9b5;
    border-radius:20px; padding:2px 12px; font-size:.75rem; font-weight:600; cursor:pointer;
    transition:all .15s;
}
.pg-preset:hover { background:#2e7d32; color:#fff; }

.pg-key-display {
    display:flex; align-items:center; gap:4px;
    background:#fffde7; border:1px solid #ffe082; border-radius:10px;
    padding:.5rem .9rem; font-size:.82rem; margin-bottom:.3rem;
}
.pg-key-badge {
    margin-left:auto; background:#f57f17; color:#fff;
    border-radius:20px; padding:1px 8px; font-size:.7rem; font-weight:700;
}

.pg-run-btn {
    background: linear-gradient(135deg, #2e7d32, #1b5e20);
    color: #fff; border: none; border-radius: 12px;
    padding: .8rem 1.5rem; font-size: .95rem; font-weight: 700;
    cursor: pointer; transition: all .25s;
    box-shadow: 0 4px 16px rgba(46,125,50,.3);
}
.pg-run-btn:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(46,125,50,.35); }
.pg-run-btn:disabled { opacity:.6; transform:none; cursor:not-allowed; }
.pg-dec-btn {
    background: linear-gradient(135deg, #1565c0, #0d47a1);
    color: #fff; border: none; border-radius: 12px;
    padding: .7rem 1.5rem; font-size: .88rem; font-weight: 700;
    cursor: pointer; transition: all .25s;
}
.pg-dec-btn:hover { transform:translateY(-1px); }

/* ======================== EMPTY STATE ======================== */
.pg-empty {
    background: #fff;
    border: 2px dashed #c6d9b5;
    border-radius: 20px;
    text-align: center;
    padding: 4rem 2rem;
}
.pg-empty-icon { font-size: 3rem; margin-bottom: 1rem; }

/* ======================== STEPS ======================== */
.pg-step {
    background: #fff;
    border-radius: 14px;
    border: 1px solid rgba(0,0,0,.07);
    box-shadow: 0 2px 12px rgba(0,0,0,.04);
    overflow: hidden;
    margin-bottom: 4px;
}
.pg-step-header {
    display: flex; align-items: center;
    padding: .75rem 1.1rem;
    font-weight: 700; font-size: .85rem;
}
.pg-step-num {
    width: 24px; height: 24px;
    border-radius: 50%;
    background: rgba(255,255,255,.3);
    display: flex; align-items: center; justify-content: center;
    font-size: .75rem; font-weight: 800;
    margin-right: .6rem; flex-shrink:0;
}
.pg-step-body { padding: 1rem 1.1rem; }

.step-plain   { background:linear-gradient(135deg,#eeeeee,#e0e0e0); color:#424242; }
.step-iv      { background:linear-gradient(135deg,#e3f2fd,#bbdefb); color:#1565c0; }
.step-feistel { background:linear-gradient(135deg,#f3e5f5,#e1bee7); color:#6a1b9a; }
.step-cipher  { background:linear-gradient(135deg,#ffebee,#ffcdd2); color:#c62828; }
.step-decrypt { background:linear-gradient(135deg,#e8f5e9,#c8e6c9); color:#2e7d32; }

.pg-arrow {
    text-align: center;
    font-size: 1.4rem;
    color: #86A775;
    line-height: 1.8;
    font-weight: 900;
}

/* ======================== MONO BOXES ======================== */
.pg-mono-box {
    background: #f5f5f5; border:1px solid #e0e0e0;
    border-radius: 8px; padding: .6rem .9rem;
    font-family: monospace; font-size: .88rem;
    color: #333; word-break: break-all;
    min-height: 36px;
}
.pg-mono-blue  { background:#e3f2fd; border-color:#90caf9; color:#1565c0; }
.pg-mono-red   { background:#fff5f5; border-color:#ffcdd2; color:#c62828; }
.pg-mono-green { background:#e8f5e9; border-color:#a5d6a7; color:#2e7d32; }

/* ======================== IV BYTE VIZ ======================== */
.pg-iv-viz {
    display: flex; flex-direction:column; gap:3px;
    flex-shrink:0;
}
.pf-byte {
    background: #1565c0; color:#fff;
    border-radius:5px; padding:2px 6px;
    font-size:.65rem; font-family:monospace; font-weight:700;
    text-align:center; min-width:32px;
}

/* ======================== FEISTEL VIZ ======================== */
.pg-feistel {
    display:flex; align-items:center; gap:8px;
    padding:.5rem; background:#fafafa; border-radius:12px;
    border:1px solid #e8d5f5; overflow-x:auto;
}
.pf-block { text-align:center; flex-shrink:0; }
.pf-label { font-size:.65rem; color:#888; font-weight:700; text-transform:uppercase; margin-bottom:4px; }
.pf-box {
    width:80px; height:80px;
    border-radius:12px;
    display:flex; align-items:center; justify-content:center;
    font-family:monospace; font-size:.65rem; font-weight:700;
    word-break:break-all; padding:6px; text-align:center;
}
.pf-in  { background:#e3f2fd; border:2px solid #90caf9; color:#1565c0; }
.pf-out { background:#ffebee; border:2px solid #ef9a9a; color:#c62828; }

.pf-rounds-col {
    display:flex; gap:3px; align-items:center; overflow-x:auto;
    padding:4px 0;
}
.pf-round {
    background: linear-gradient(180deg,#7b1fa2,#4a148c);
    color:#fff;
    border-radius:8px;
    width:32px; height:70px;
    display:flex; align-items:center; justify-content:center;
    font-size:.6rem; font-weight:800; writing-mode:vertical-rl;
    text-orientation:mixed; transform:rotate(180deg);
    cursor:default; transition:all .15s; flex-shrink:0;
    position:relative;
}
.pf-round:hover { background:linear-gradient(180deg,#9c27b0,#6a1b9a); transform:rotate(180deg) scale(1.1); }
.pf-round-active {
    background:linear-gradient(180deg,#f57f17,#e65100) !important;
    box-shadow:0 0 8px rgba(245,127,23,.6);
}
.pf-arrow-col { flex-grow:1; min-width:0; }

/* ======================== MISC ======================== */
.pg-info-box {
    background:#e8f5e9; border:1px solid #a5d6a7;
    border-radius:8px; padding:.5rem .75rem;
    font-size:.78rem; color:#2e7d32;
}
.pg-success-box {
    display:flex; gap:1rem; align-items:flex-start;
    background:#f1f8f0; border:1.5px solid #a5d6a7;
    border-radius:12px; padding:1rem;
}
.pg-success-icon { font-size:2rem; flex-shrink:0; }
.pg-stat-row {
    display:flex; justify-content:space-between; flex-wrap:wrap; gap:4px;
    font-size:.78rem; color:#666; margin-top:.4rem;
}
.pg-mini-card {
    background:#fafafa; border:1.5px solid #e0e0e0;
    border-radius:10px; padding:.6rem .75rem;
}
.pg-mini-label { font-size:.65rem; font-weight:700; text-transform:uppercase; margin-bottom:.25rem; }

/* ======================== COMPARE ======================== */
.pg-compare-item {
    background:#fff8e1; border:1px solid #ffe082;
    border-radius:8px; padding:.5rem .75rem;
}
.pg-compare-num {
    display:inline-block; width:22px; height:22px;
    background:#f57f17; color:#fff; border-radius:50%;
    text-align:center; line-height:22px; font-size:.7rem; font-weight:800;
    margin-right:.4rem; flex-shrink:0;
}

/* ======================== ANIMATION ======================== */
.step-animate { animation: stepIn .4s ease both; }
@keyframes stepIn {
    from { opacity:0; transform:translateY(12px); }
    to   { opacity:1; transform:translateY(0); }
}
</style>
@endpush

@push('scripts')
<script>
const CSRF     = '{{ csrf_token() }}';
const SIM_URL  = '{{ route("admin.kriptografi.simulate") }}';

let lastEncrypted = '';
let lastPlain     = '';

function setPreset(val) {
    document.getElementById('inputText').value = val;
}

function copyToClipboard() {
    navigator.clipboard.writeText(lastEncrypted).then(() => {
        const btn = document.getElementById('copyBtn');
        btn.innerHTML = '<i class="fa-solid fa-check me-1"></i>Tersalin!';
        btn.style.background = '#c8e6c9';
        setTimeout(() => {
            btn.innerHTML = '<i class="fa-solid fa-copy me-1"></i>Salin';
            btn.style.background = '#e8f5e9';
        }, 2000);
    });
}

async function runEncrypt() {
    const plainText = document.getElementById('inputText').value.trim();
    if (!plainText) {
        Swal.fire({icon:'warning', title:'Perhatian!', text:'Masukkan teks terlebih dahulu.', confirmButtonColor:'#2e7d32'});
        return;
    }

    lastPlain = plainText;

    const btn = document.getElementById('encBtn');
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Mengenkripsi...';
    btn.disabled = true;

    try {
        const res  = await fetch(SIM_URL, {
            method: 'POST',
            headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
            body: JSON.stringify({plain_text: plainText})
        });
        const data = await res.json();
        lastEncrypted = data.encrypted;

        // Sembunyikan empty state, tampilkan result
        document.getElementById('emptyState').style.display = 'none';
        document.getElementById('resultArea').style.display  = 'block';
        document.getElementById('decryptSection').style.display = 'none';
        document.getElementById('decBtn').style.display = 'inline-block';

        // ---- Step 1: Plaintext ----
        document.getElementById('s1_plain').textContent = data.plain_text;
        document.getElementById('s1_len').textContent   = data.plain_length + ' karakter';

        // ---- Step 2: IV ----
        document.getElementById('s2_iv').textContent = data.iv_hex;
        renderIvBytes(data.iv_hex);

        // ---- Step 3: Feistel ----
        document.getElementById('s3_time').textContent = data.time_enc_ms;
        renderFeistel(data.plain_text, data.encrypted);

        // ---- Step 4: Ciphertext ----
        document.getElementById('s4_cipher').textContent      = data.encrypted;
        document.getElementById('s4_len').textContent         = data.cipher_length + ' karakter';
        document.getElementById('s4_iv_part').textContent     = data.iv_hex;
        document.getElementById('s4_cipher_part').textContent = data.cipher_hex;

        // Jalankan compare jika belum ada
        runCompare(plainText);

    } catch(e) {
        Swal.fire({icon:'error', title:'Error!', text:'Gagal melakukan enkripsi.', confirmButtonColor:'#2e7d32'});
    }

    btn.innerHTML = '<i class="fa-solid fa-play me-2"></i>Jalankan Enkripsi Blowfish';
    btn.disabled = false;
}

async function runDecrypt() {
    if (!lastEncrypted) return;

    const btn = document.getElementById('decBtn');
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Mendekripsi...';
    btn.disabled = true;

    // Kita gunakan encrypt lagi untuk dapat time_dec — simulasi sudah include both
    try {
        const res  = await fetch(SIM_URL, {
            method: 'POST',
            headers: {'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
            body: JSON.stringify({plain_text: lastPlain})
        });
        const data = await res.json();

        document.getElementById('decryptSection').style.display = 'block';
        document.getElementById('s5_result').textContent = data.decrypted;
        document.getElementById('s5_time').textContent   = data.time_dec_ms;

        // Animasi step5
        const step5 = document.getElementById('step5');
        step5.style.animation = 'none';
        step5.offsetHeight; // reflow
        step5.style.animation = 'stepIn .4s ease both';

        // Scroll ke bawah
        document.getElementById('step5').scrollIntoView({behavior:'smooth', block:'center'});

    } catch(e) {}

    btn.innerHTML = '<i class="fa-solid fa-lock-open me-2"></i>Dekripsi Kembali';
    btn.disabled = false;
}

function renderIvBytes(ivHex) {
    const cont = document.getElementById('ivBytesViz');
    cont.innerHTML = '';
    // Setiap 2 hex char = 1 byte
    for (let i = 0; i < ivHex.length; i += 2) {
        const b = document.createElement('div');
        b.className = 'pf-byte';
        b.textContent = '0x' + ivHex.substr(i, 2);
        cont.appendChild(b);
    }
}

function renderFeistel(plain, cipher) {
    // Input block (potong max 6 chars untuk display)
    const inDisplay  = plain.length  > 6 ? plain.substr(0,6)+'…' : plain;
    const outDisplay = cipher.length > 6 ? cipher.substr(0,6)+'…' : cipher;

    document.getElementById('pf_in').textContent  = inDisplay;
    document.getElementById('pf_out').textContent = outDisplay;

    // Render 16 rounds
    const cont = document.getElementById('roundsViz');
    cont.innerHTML = '';

    for (let i = 1; i <= 16; i++) {
        const r = document.createElement('div');
        r.className = 'pf-round';
        r.textContent = 'R' + i;
        r.title = 'Round ' + i + ': F-function + XOR + Swap';
        cont.appendChild(r);
    }

    // Animasi round aktif satu per satu
    animateRounds(cont.querySelectorAll('.pf-round'));
}

function animateRounds(rounds) {
    let i = 0;
    const interval = setInterval(() => {
        if (i > 0) rounds[i-1].classList.remove('pf-round-active');
        if (i < rounds.length) {
            rounds[i].classList.add('pf-round-active');
            i++;
        } else {
            clearInterval(interval);
            // Semua aktif sebentar lalu reset
            setTimeout(() => {
                rounds.forEach(r => r.classList.remove('pf-round-active'));
            }, 400);
        }
    }, 60);
}

async function runCompare(plainText) {
    const card = document.getElementById('compareCard');
    const list = document.getElementById('compareList');
    const cmpText = document.getElementById('cmpText');

    card.style.display = 'none';
    list.innerHTML = '<div class="text-muted small text-center py-2"><i class="fa-solid fa-spinner fa-spin me-1"></i>Mengenkripsi 3x untuk perbandingan...</div>';
    cmpText.textContent = plainText.length > 20 ? plainText.substr(0,20)+'...' : plainText;
    card.style.display = 'block';

    const results = [];
    for (let i = 0; i < 3; i++) {
        try {
            const r = await fetch(SIM_URL, {
                method:'POST',
                headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
                body: JSON.stringify({plain_text: plainText})
            });
            const d = await r.json();
            results.push(d.encrypted);
        } catch(e) { results.push('Error'); }
    }

    list.innerHTML = results.map((cipher, idx) => `
        <div class="pg-compare-item">
            <div class="d-flex align-items-start gap-2">
                <span class="pg-compare-num">${idx+1}</span>
                <div class="flex-grow-1">
                    <div class="pg-label-mini mb-1">Enkripsi ke-${idx+1}</div>
                    <code style="font-size:.72rem;word-break:break-all;color:#c62828;">${cipher}</code>
                </div>
            </div>
        </div>
    `).join('');

    // Highlight perbedaan
    const allSame = results.every(c => c === results[0]);
    if (!allSame) {
        const notif = document.createElement('div');
        notif.className = 'pg-info-box mt-2';
        notif.style.background = '#e8f5e9';
        notif.innerHTML = '<i class="fa-solid fa-check-circle text-success me-1"></i><strong>Terbukti!</strong> Ketiga ciphertext di atas <strong>berbeda semua</strong> meskipun plaintextnya sama. Inilah kekuatan IV acak pada mode CBC!';
        list.appendChild(notif);
    }
}

// Enter key di textarea → run
document.getElementById('inputText').addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && e.ctrlKey) runEncrypt();
});
</script>
@endpush
