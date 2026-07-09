@extends('layouts.admin')

@section('content')
{{-- =====================================================================
     HERO HEADER
====================================================================== --}}
<div class="dash-hero rounded-4 mb-4 p-4 p-lg-5 position-relative overflow-hidden shadow-sm">
    <div class="row align-items-center position-relative" style="z-index:2;">
        <div class="col-lg-8">
            <span class="badge dash-badge-pill mb-3 px-3 py-2 fw-semibold" style="letter-spacing:1px; font-size:.72rem;">
                <i class="fa-solid fa-shield-halved me-1"></i> SISTEM E-VOTING AMAN
            </span>
            <h1 class="fw-bolder text-white mb-2 dash-hero-title">Selamat Datang, Admin! 👋</h1>
            <p class="text-white opacity-75 mb-0" style="font-size:1.05rem;">
                Pantau aktivitas pemilihan, kelola data, dan analisis keamanan dari satu dashboard.
            </p>
            @if($periodeAktif)
            <div class="mt-3 d-inline-flex align-items-center gap-2 px-3 py-2 rounded-3"
                 style="background:rgba(255,255,255,.15); backdrop-filter:blur(6px);">
                <span class="d-inline-block rounded-circle bg-success" style="width:8px;height:8px;"></span>
                <span class="text-white fw-semibold small">Periode Aktif: {{ $periodeAktif->nama_periode }}</span>
            </div>
            @else
            <div class="mt-3 d-inline-flex align-items-center gap-2 px-3 py-2 rounded-3"
                 style="background:rgba(255,255,255,.12); backdrop-filter:blur(6px);">
                <span class="d-inline-block rounded-circle bg-warning" style="width:8px;height:8px;"></span>
                <span class="text-white fw-semibold small">Tidak ada periode aktif</span>
            </div>
            @endif
        </div>
        <div class="col-lg-4 text-end d-none d-lg-block">
            <i class="fa-solid fa-landmark text-white" style="font-size:7rem;opacity:.12;transform:rotate(-10deg);"></i>
        </div>
    </div>
    {{-- decorative blobs --}}
    <div class="dash-blob dash-blob-1"></div>
    <div class="dash-blob dash-blob-2"></div>
</div>

{{-- =====================================================================
     ROW 1 — STAT CARDS
====================================================================== --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="dash-stat-card h-100">
            <div class="dash-stat-icon" style="background:linear-gradient(135deg,#EBEFDF,#c6d9b5);color:#4a7c40;">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="dash-stat-body">
                <span class="dash-stat-label">Total Mahasiswa</span>
                <span class="dash-stat-value">{{ $totalMahasiswa }}</span>
            </div>
            <div class="dash-stat-bar" style="background:#86A775;"></div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="dash-stat-card h-100">
            <div class="dash-stat-icon" style="background:linear-gradient(135deg,#e8f5e9,#c8e6c9);color:#2e7d32;">
                <i class="fa-solid fa-check-to-slot"></i>
            </div>
            <div class="dash-stat-body">
                <span class="dash-stat-label">Sudah Memilih</span>
                <span class="dash-stat-value text-success">{{ $sudahMemilih }}</span>
            </div>
            <div class="dash-stat-bar" style="background:#2e7d32;"></div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="dash-stat-card h-100">
            <div class="dash-stat-icon" style="background:linear-gradient(135deg,#ffebee,#ffcdd2);color:#c62828;">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div class="dash-stat-body">
                <span class="dash-stat-label">Belum Memilih</span>
                <span class="dash-stat-value text-danger">{{ $belumMemilih }}</span>
            </div>
            <div class="dash-stat-bar" style="background:#c62828;"></div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="dash-stat-card h-100">
            <div class="dash-stat-icon" style="background:linear-gradient(135deg,#e3f2fd,#bbdefb);color:#1565c0;">
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <div class="dash-stat-body">
                <span class="dash-stat-label">Total Kandidat</span>
                <span class="dash-stat-value" style="color:#1565c0;">{{ $totalKandidat }}</span>
            </div>
            <div class="dash-stat-bar" style="background:#1565c0;"></div>
        </div>
    </div>
</div>

{{-- =====================================================================
     ROW 2 — PARTISIPASI + KEAMANAN
====================================================================== --}}
<div class="row g-3 mb-4">

    {{-- Partisipasi Pemilihan --}}
    <div class="col-lg-7">
        <div class="card dash-card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="dash-section-icon me-3" style="background:linear-gradient(135deg,#EBEFDF,#c6d9b5);color:#4a7c40;">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Partisipasi Pemilihan</h5>
                        <small class="text-muted">Tingkat partisipasi mahasiswa saat ini</small>
                    </div>
                    <span class="ms-auto badge rounded-pill fs-6 fw-bold px-3 py-2"
                          style="background:linear-gradient(135deg,#86A775,#6B8B5B);color:#fff;">
                        {{ $persentase }}%
                    </span>
                </div>

                {{-- Progress bar --}}
                <div class="position-relative mb-3" style="height:28px;border-radius:14px;background:#EBEFDF;overflow:hidden;">
                    <div class="position-absolute top-0 start-0 h-100 d-flex align-items-center justify-content-center fw-bold text-white"
                         style="width:{{ max($persentase, 5) }}%;background:linear-gradient(90deg,#86A775,#6B8B5B);border-radius:14px;font-size:.85rem;transition:width 1s ease;min-width:36px;">
                        {{ $persentase }}%
                    </div>
                </div>

                <div class="row g-2 mt-3">
                    <div class="col-4 text-center p-2 rounded-3" style="background:#f8fdf5;border:1px dashed #86A775;">
                        <div class="fw-bold text-success fs-5">{{ $sudahMemilih }}</div>
                        <div class="text-muted" style="font-size:.75rem;">Sudah Memilih</div>
                    </div>
                    <div class="col-4 text-center p-2 rounded-3" style="background:#fff5f5;border:1px dashed #e57373;">
                        <div class="fw-bold text-danger fs-5">{{ $belumMemilih }}</div>
                        <div class="text-muted" style="font-size:.75rem;">Belum Memilih</div>
                    </div>
                    <div class="col-4 text-center p-2 rounded-3" style="background:#f0f4ff;border:1px dashed #5c6bc0;">
                        <div class="fw-bold fs-5" style="color:#5c6bc0;">{{ $totalMahasiswa }}</div>
                        <div class="text-muted" style="font-size:.75rem;">Total Pemilih</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Status Keamanan Sistem --}}
    <div class="col-lg-5">
        <div class="card dash-card h-100" style="border-top:4px solid #86A775;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="dash-section-icon me-3" style="background:linear-gradient(135deg,#e8f5e9,#c8e6c9);color:#2e7d32;">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Status Keamanan</h5>
                        <small class="text-muted">Enkripsi Blowfish aktif</small>
                    </div>
                    <span class="ms-auto badge bg-success rounded-pill px-3">
                        <i class="fa-solid fa-circle-check me-1"></i>Aman
                    </span>
                </div>

                <div class="d-flex flex-column gap-2">
                    <div class="dash-info-row">
                        <span class="dash-info-label"><i class="fa-solid fa-key me-2 text-warning"></i>Algoritma</span>
                        <span class="dash-info-value fw-semibold">{{ $algoInfo['algoritma'] }} ({{ $algoInfo['implementasi'] ?? 'Pure PHP' }})</span>
                    </div>
                    <div class="dash-info-row">
                        <span class="dash-info-label"><i class="fa-solid fa-layer-group me-2 text-info"></i>Mode</span>
                        <span class="dash-info-value fw-semibold">CBC + IV Acak</span>
                    </div>
                    <div class="dash-info-row">
                        <span class="dash-info-label"><i class="fa-solid fa-ruler me-2 text-primary"></i>Panjang Kunci</span>
                        <span class="dash-info-value fw-semibold">{{ $algoInfo['key_length'] }}</span>
                    </div>
                    <div class="dash-info-row">
                        <span class="dash-info-label"><i class="fa-solid fa-database me-2 text-success"></i>Suara Terenkripsi</span>
                        <span class="dash-info-value fw-bold text-success">{{ $totalSuaraTerenkripsi }} record</span>
                    </div>
                    <div class="dash-info-row">
                        <span class="dash-info-label"><i class="fa-solid fa-rotate me-2 text-secondary"></i>Rounds</span>
                        <span class="dash-info-value fw-semibold">{{ $algoInfo['rounds'] }}</span>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

{{-- =====================================================================
     ROW 3 — REKAPITULASI SUARA + AKTIVITAS TERBARU
====================================================================== --}}
<div class="row g-3">

    {{-- Rekapitulasi Suara Sementara --}}
    <div class="col-lg-7">
        <div class="card dash-card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="dash-section-icon me-3" style="background:linear-gradient(135deg,#fce4ec,#f8bbd0);color:#ad1457;">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Rekapitulasi Suara</h5>
                        <small class="text-muted">Data sementara hasil perolehan</small>
                    </div>
                    <a href="{{ route('admin.hasil.index') }}" class="ms-auto btn btn-sm btn-outline-secondary rounded-pill">
                        Lihat Detail <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>

                @if($hasilVoting->isEmpty())
                <div class="text-center py-4">
                    <i class="fa-solid fa-box-open text-muted" style="font-size:2.5rem;"></i>
                    <p class="text-muted mt-2 mb-0">Belum ada suara masuk</p>
                </div>
                @else
                <div class="d-flex flex-column gap-2">
                    @php $totalSuara = $hasilVoting->sum('jumlah_suara'); @endphp
                    @foreach($hasilVoting as $h)
                    @php
                        $pct = $totalSuara > 0 ? round(($h->jumlah_suara / $totalSuara) * 100, 1) : 0;
                        $colors = ['#86A775','#5c6bc0','#f06292','#26a69a'];
                        $color = $colors[($loop->index) % count($colors)];
                    @endphp
                    <div class="p-3 rounded-3" style="background:#fafafa;border:1px solid #eee;">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-semibold small">
                                No.{{ $h->kandidat->nomor_urut ?? '-' }} —
                                {{ $h->kandidat->nama_ketua ?? 'N/A' }}
                                <span class="text-muted">&</span>
                                {{ $h->kandidat->nama_wakil ?? 'N/A' }}
                            </span>
                            <span class="badge rounded-pill fw-bold" style="background:{{ $color }};color:#fff;">
                                {{ $h->jumlah_suara }} suara
                            </span>
                        </div>
                        <div style="height:8px;border-radius:4px;background:#eee;overflow:hidden;">
                            <div style="height:100%;width:{{ $pct }}%;background:{{ $color }};border-radius:4px;transition:width 1s;"></div>
                        </div>
                        <div class="text-end mt-1" style="font-size:.72rem;color:#999;">{{ $pct }}%</div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Aktivitas Voting Terbaru --}}
    <div class="col-lg-5">
        <div class="card dash-card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="dash-section-icon me-3" style="background:linear-gradient(135deg,#fff8e1,#ffecb3);color:#f57f17;">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Aktivitas Terbaru</h5>
                        <small class="text-muted">5 suara masuk terakhir</small>
                    </div>
                </div>

                @if($recentVotings->isEmpty())
                <div class="text-center py-4">
                    <i class="fa-solid fa-inbox text-muted" style="font-size:2.5rem;"></i>
                    <p class="text-muted mt-2 mb-0">Belum ada aktivitas voting</p>
                </div>
                @else
                <div class="d-flex flex-column gap-2">
                    @foreach($recentVotings as $rv)
                    <div class="d-flex align-items-center gap-3 p-2 rounded-3" style="background:#fafafa;border:1px solid #f0f0f0;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                             style="width:38px;height:38px;background:linear-gradient(135deg,#EBEFDF,#c6d9b5);color:#4a7c40;font-weight:700;font-size:.75rem;">
                            {{ strtoupper(substr($rv->user->nama ?? 'U', 0, 2)) }}
                        </div>
                        <div class="flex-grow-1 min-width-0">
                            <div class="fw-semibold small text-truncate">{{ $rv->user->nama ?? 'Unknown' }}</div>
                            <div class="text-muted" style="font-size:.72rem;">{{ $rv->user->nim ?? '-' }}</div>
                        </div>
                        <div class="text-end flex-shrink-0">
                            <span class="badge bg-success rounded-pill" style="font-size:.65rem;">
                                <i class="fa-solid fa-lock me-1"></i>Terenkripsi
                            </span>
                            <div class="text-muted mt-1" style="font-size:.68rem;">
                                {{ \Carbon\Carbon::parse($rv->created_at)->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                <a href="{{ route('admin.voting.index') }}" class="btn btn-sm w-100 mt-3 btn-outline-secondary rounded-pill fw-semibold">
                    Lihat Semua Data Voting <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* =====================================================
   ADMIN DASHBOARD — CUSTOM STYLES
===================================================== */

/* Hero */
.dash-hero {
    background: linear-gradient(135deg, #86A775 0%, #4a7c40 60%, #3a5e31 100%);
    min-height: 180px;
}
.dash-hero-title { font-size: clamp(1.6rem, 3vw, 2.4rem); }
.dash-badge-pill {
    background: rgba(255,255,255,.22);
    color: #fff;
    border: 1px solid rgba(255,255,255,.3);
    backdrop-filter: blur(6px);
    letter-spacing: .8px;
}

/* Blobs */
.dash-blob {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
    z-index: 1;
}
.dash-blob-1 {
    width: 220px; height: 220px;
    background: rgba(255,255,255,.08);
    top: -60px; right: -40px;
}
.dash-blob-2 {
    width: 140px; height: 140px;
    background: rgba(255,255,255,.05);
    bottom: -50px; right: 160px;
}

/* Stat Cards */
.dash-stat-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,.04);
    border: 1px solid rgba(0,0,0,.04);
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 20px;
    position: relative;
    overflow: hidden;
    transition: transform .25s, box-shadow .25s;
}
.dash-stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,.08);
}
.dash-stat-icon {
    width: 52px; height: 52px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}
.dash-stat-body { flex: 1; min-width: 0; }
.dash-stat-label {
    display: block;
    font-size: .75rem;
    font-weight: 600;
    color: #888;
    text-transform: uppercase;
    letter-spacing: .6px;
    margin-bottom: 2px;
}
.dash-stat-value {
    display: block;
    font-size: 2rem;
    font-weight: 800;
    color: #2d3748;
    line-height: 1.1;
}
.dash-stat-bar {
    position: absolute;
    bottom: 0; left: 0;
    width: 100%; height: 4px;
    border-radius: 0 0 16px 16px;
}

/* General cards */
.dash-card {
    border-radius: 16px !important;
    border: 1px solid rgba(0,0,0,.05) !important;
    box-shadow: 0 2px 16px rgba(0,0,0,.04) !important;
    transition: box-shadow .25s;
}
.dash-card:hover { box-shadow: 0 6px 24px rgba(0,0,0,.08) !important; }

/* Section Icon */
.dash-section-icon {
    width: 42px; height: 42px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}

/* Info rows */
.dash-info-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 12px;
    border-radius: 10px;
    background: #fafafa;
    border: 1px solid #f0f0f0;
    font-size: .82rem;
}
.dash-info-label { color: #666; }
.dash-info-value { color: #333; font-size: .82rem; }

/* Responsive tweaks */
@media (max-width: 575px) {
    .dash-stat-value { font-size: 1.6rem; }
    .dash-hero { padding: 1.5rem !important; }
}
</style>
@endpush
