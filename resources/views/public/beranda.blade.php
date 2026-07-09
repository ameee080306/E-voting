@extends('layouts.app')

@section('content')
<div class="row align-items-center mt-5 mb-5 pb-4">
    <div class="col-md-6 text-center text-md-start mb-5 mb-md-0 pe-md-5">
        <span class="badge bg-matcha text-dark mb-3 px-3 py-2 rounded-pill fw-bold" style="letter-spacing: 1px; font-size: 0.85rem;">SISTEM E-VOTING MODERN</span>
        <h1 class="display-4 fw-bolder mb-4" style="line-height: 1.2; letter-spacing: -1px; color: var(--text-dark);">
            Pilih Pemimpin Masa Depan <span style="background: linear-gradient(135deg, var(--matcha-dark), var(--pink-dark)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Lebih Mudah & Aman</span>
        </h1>
        <p class="lead mb-5 text-secondary" style="font-size: 1.15rem; line-height: 1.6;">Gunakan hak suara Anda untuk memilih pemimpin Organisasi Mahasiswa yang berkualitas, transparan, dan terpercaya tanpa antre.</p>
        <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-md-start gap-3">
            <a href="{{ route('login') }}" class="btn btn-matcha btn-lg rounded-pill px-5 py-3 fs-5 shadow-sm">Mulai Voting <i class="fa-solid fa-arrow-right ms-2"></i></a>
            <a href="#tentang" class="btn btn-outline-secondary btn-lg rounded-pill px-4 py-3 fs-5 bg-white shadow-sm border-0 text-dark">Pelajari Lebih Lanjut</a>
        </div>
    </div>
    <div class="col-md-6 text-center position-relative">
        <!-- Decoration Behind Image -->
        <div class="position-absolute rounded-circle" style="width: 400px; height: 400px; background-color: var(--matcha-soft); top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: -1; filter: blur(50px); opacity: 0.7;"></div>
        <!-- Hero Illustration -->
        <img src="{{ asset('img/hero.png') }}" alt="E-Voting Illustration" class="img-fluid rounded-4 shadow-lg" style="max-width: 90%; animation: float 6s ease-in-out infinite;">
    </div>
</div>

<style>
@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-15px); }
    100% { transform: translateY(0px); }
}
</style>

<div class="row mt-5 text-center g-4">
    <div class="col-md-4">
        <div class="card card-custom p-4 h-100">
            <div class="display-4 text-success mb-3"><i class="fa-solid fa-lock"></i></div>
            <h4 class="fw-bold">Aman</h4>
            <p class="text-secondary">Pilihan Anda dienkripsi menggunakan algoritma Blowfish untuk menjaga kerahasiaan.</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-custom p-4 h-100">
            <div class="display-4 text-primary mb-3"><i class="fa-solid fa-bolt"></i></div>
            <h4 class="fw-bold">Cepat</h4>
            <p class="text-secondary">Proses pemilihan dilakukan secara online, langsung, dan real-time.</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-custom p-4 h-100">
            <div class="display-4 text-warning mb-3"><i class="fa-solid fa-chart-line"></i></div>
            <h4 class="fw-bold">Transparan</h4>
            <p class="text-secondary">Hasil pemilihan dapat dilihat secara terbuka setelah periode berakhir.</p>
        </div>
    </div>
</div>

<!-- Bagian Tentang & Tentang Kami -->
<div class="row mt-5 pt-5 pb-5 px-3" id="tentang" style="background-color: #fff; border-radius: 30px; box-shadow: 0 10px 40px rgba(0,0,0,0.02);">
    <div class="col-12 text-center mb-5">
        <span class="badge bg-matcha text-dark mb-2 px-3 py-2 rounded-pill fw-bold" style="letter-spacing: 1px;">MENGENAL LEBIH DEKAT</span>
        <h2 class="fw-bolder display-6" style="color: var(--text-dark);">Tentang E-Voting & Kami</h2>
    </div>

    <div class="col-md-11 mx-auto">
        <div class="row g-4 align-items-stretch">
            <!-- Tentang Aplikasi -->
            <div class="col-lg-6">
                <div class="card card-custom p-5 h-100 border-0 shadow-sm" style="background-color: var(--pink-soft);">
                    <div class="mb-4" style="font-size: 2.5rem; color: var(--matcha-dark);">
                        <i class="fa-solid fa-laptop-code"></i>
                    </div>
                    <h3 class="fw-bold mb-3">Tentang Sistem E-Voting</h3>
                    <p class="text-secondary mb-4" style="line-height: 1.8; font-size: 1.05rem;">
                        Sistem E-Voting ini dirancang khusus untuk merevolusi cara pemilihan pemimpin di lingkungan organisasi atau kampus. Kami menggabungkan antarmuka yang ramah pengguna dengan tingkat keamanan berlapis.
                    </p>
                    <ul class="list-unstyled text-secondary mt-auto">
                        <li class="mb-3 d-flex align-items-center"><i class="fa-solid fa-check-circle me-3 fs-5" style="color: var(--matcha-dark);"></i> Enkripsi Data Tingkat Tinggi (Blowfish)</li>
                        <li class="mb-3 d-flex align-items-center"><i class="fa-solid fa-check-circle me-3 fs-5" style="color: var(--matcha-dark);"></i> Penghitungan Suara Akurat & Real-time</li>
                        <li class="mb-0 d-flex align-items-center"><i class="fa-solid fa-check-circle me-3 fs-5" style="color: var(--matcha-dark);"></i> Ramah Lingkungan (100% Digital / Paperless)</li>
                    </ul>
                </div>
            </div>

            <!-- Tentang Kami (Tim) -->
            <div class="col-lg-6">
                <div class="card card-custom p-5 h-100 border-0 shadow-sm" style="background-color: var(--matcha-dark); color: white;">
                    <div class="mb-4 text-white" style="font-size: 2.5rem;">
                        <i class="fa-solid fa-users-gear"></i>
                    </div>
                    <h3 class="fw-bold mb-3 text-white">Tentang Tim Kami</h3>
                    <p class="mb-4" style="line-height: 1.8; color: rgba(255,255,255,0.9); font-size: 1.05rem;">
                        Kami adalah tim pengembang yang berdedikasi untuk menciptakan solusi digital yang transparan, cerdas, dan efisien. Misi utama kami adalah memberantas kecurangan dalam pemilihan dan memastikan setiap suara pemilih dihitung secara presisi.
                    </p>
                    <p class="mb-0 mt-auto" style="line-height: 1.8; color: rgba(255,255,255,0.9); font-size: 1.05rem;">
                        Dengan semangat inovasi tanpa henti, kami terus memutakhirkan teknologi sistem ini agar selalu relevan dengan kebutuhan demokrasi digital masa kini. Kepercayaan Anda adalah prioritas kami.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Nilai Tambah -->
        <div class="row mt-4 g-4 text-center">
            <div class="col-md-4">
                <div class="p-4 rounded-4 shadow-sm h-100 card-custom" style="background-color: var(--pink-soft);">
                    <div class="mb-3" style="font-size: 2rem; color: var(--pink-dark);"><i class="fa-solid fa-bullseye"></i></div>
                    <h5 class="fw-bold">Visi</h5>
                    <p class="text-secondary small mt-2 mb-0">Menjadi platform e-voting tepercaya yang menciptakan demokrasi digital yang adil.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 rounded-4 shadow-sm h-100 card-custom" style="background-color: var(--pink-soft);">
                    <div class="mb-3" style="font-size: 2rem; color: var(--pink-dark);"><i class="fa-solid fa-rocket"></i></div>
                    <h5 class="fw-bold">Misi</h5>
                    <p class="text-secondary small mt-2 mb-0">Menyediakan layanan voting yang anti-ribet, aman, dan tanpa kendala teknis.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 rounded-4 shadow-sm h-100 card-custom" style="background-color: var(--pink-soft);">
                    <div class="mb-3" style="font-size: 2rem; color: var(--pink-dark);"><i class="fa-solid fa-handshake"></i></div>
                    <h5 class="fw-bold">Nilai Inti</h5>
                    <p class="text-secondary small mt-2 mb-0">Integritas, Transparansi Hasil, Inovasi Cepat, dan Keamanan Privasi Pengguna.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
