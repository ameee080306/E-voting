@extends('layouts.app')

@section('content')
<div class="row align-items-center mt-3 mb-5 py-5 reveal">
    <div class="col-md-6 text-center text-md-start mb-5 mb-md-0 pe-md-5">
        <span class="badge bg-matcha text-dark mb-3 px-3 py-2 rounded-pill fw-bold" style="letter-spacing: 1px; font-size: 0.85rem;">SISTEM E-VOTING MODERN</span>
        <h1 class="display-4 fw-bolder mb-4 reveal delay-100" style="line-height: 1.25; letter-spacing: -1.5px; color: var(--text-dark);">
            Pilih Pemimpin Masa Depan <span style="background: linear-gradient(135deg, var(--matcha-dark), var(--pink-dark)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Lebih Mudah & Aman</span>
        </h1>
        <p class="lead mb-5 text-secondary reveal delay-200" style="font-size: 1.15rem; line-height: 1.7;">Gunakan hak suara Anda untuk memilih pemimpin Organisasi Mahasiswa yang berkualitas, transparan, dan terpercaya tanpa antre.</p>
        <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-md-start gap-3 reveal delay-300">
            <a href="{{ route('login') }}" class="btn btn-matcha btn-lg shadow-sm">Mulai Voting <i class="fa-solid fa-arrow-right ms-2"></i></a>
            <a href="#tentang" class="btn btn-outline-secondary btn-lg shadow-sm text-dark">Pelajari Lebih Lanjut</a>
        </div>
    </div>
    <div class="col-md-6 text-center position-relative reveal delay-200">
        <!-- Decoration Behind Image -->
        <div class="position-absolute rounded-circle" style="width: 400px; height: 400px; background-color: var(--matcha-soft); top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: -1; filter: blur(60px); opacity: 0.8;"></div>
        <!-- Hero Illustration -->
        <img src="{{ asset('img/hero.png') }}" alt="E-Voting Illustration" class="img-fluid shadow-lg" style="max-width: 90%; border-radius: 24px; animation: float 6s ease-in-out infinite;">
    </div>
</div>

<style>
@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-15px); }
    100% { transform: translateY(0px); }
}
</style>

<div class="row mt-5 text-center g-4 reveal">
    <div class="col-md-4 reveal delay-100">
        <div class="card card-custom p-4 h-100 border-0">
            <div class="display-4 text-success mb-3"><i class="fa-solid fa-lock"></i></div>
            <h4 class="fw-bold mb-3">Aman</h4>
            <p class="text-secondary mb-0">Pilihan Anda dienkripsi menggunakan algoritma Blowfish untuk menjaga kerahasiaan.</p>
        </div>
    </div>
    <div class="col-md-4 reveal delay-200">
        <div class="card card-custom p-4 h-100 border-0">
            <div class="display-4 text-primary mb-3"><i class="fa-solid fa-bolt"></i></div>
            <h4 class="fw-bold mb-3">Cepat</h4>
            <p class="text-secondary mb-0">Proses pemilihan dilakukan secara online, langsung, dan real-time.</p>
        </div>
    </div>
    <div class="col-md-4 reveal delay-300">
        <div class="card card-custom p-4 h-100 border-0">
            <div class="display-4 text-warning mb-3"><i class="fa-solid fa-chart-line"></i></div>
            <h4 class="fw-bold mb-3">Transparan</h4>
            <p class="text-secondary mb-0">Hasil pemilihan dapat dilihat secara terbuka setelah periode berakhir.</p>
        </div>
    </div>
</div>

<!-- Bagian Tentang & Tentang Kami -->
<div class="row mt-5 py-5 px-3 reveal" id="tentang" style="background-color: #ffffff; border-radius: 32px; box-shadow: var(--shadow-soft);">
    <div class="col-12 text-center mb-5 reveal delay-100">
        <span class="badge bg-matcha text-dark mb-2 px-3 py-2 rounded-pill fw-bold" style="letter-spacing: 1px;">MENGENAL LEBIH DEKAT</span>
        <h2 class="fw-bolder display-6 mt-2" style="color: var(--text-dark); letter-spacing: -1px;">Tentang E-Voting & Kami</h2>
    </div>

    <div class="col-md-11 mx-auto">
        <div class="row g-4 align-items-stretch">
            <!-- Tentang Aplikasi -->
            <div class="col-lg-6 reveal delay-100">
                <div class="card card-custom p-5 h-100 border-0" style="background-color: var(--pink-soft);">
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
                        <li class="mb-0 d-flex align-items-center"><i class="fa-solid fa-check-circle me-3 fs-5" style="color: var(--matcha-dark);"></i> Ramah Lingkungan (100% Digital)</li>
                    </ul>
                </div>
            </div>

            <!-- Tentang Kami (Tim) -->
            <div class="col-lg-6 reveal delay-200">
                <div class="card card-custom p-5 h-100 border-0" style="background-color: var(--matcha-dark); color: white;">
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
        <div class="row mt-5 g-4 text-center reveal delay-300">
            <div class="col-md-4">
                <div class="p-4 h-100 card-custom border-0" style="background-color: var(--pink-soft);">
                    <div class="mb-3" style="font-size: 2rem; color: var(--pink-dark);"><i class="fa-solid fa-bullseye"></i></div>
                    <h5 class="fw-bold">Visi</h5>
                    <p class="text-secondary mt-2 mb-0" style="font-size: 0.95rem;">Menjadi platform e-voting tepercaya yang menciptakan demokrasi digital yang adil.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 h-100 card-custom border-0" style="background-color: var(--pink-soft);">
                    <div class="mb-3" style="font-size: 2rem; color: var(--pink-dark);"><i class="fa-solid fa-rocket"></i></div>
                    <h5 class="fw-bold">Misi</h5>
                    <p class="text-secondary mt-2 mb-0" style="font-size: 0.95rem;">Menyediakan layanan voting yang anti-ribet, aman, dan tanpa kendala teknis.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 h-100 card-custom border-0" style="background-color: var(--pink-soft);">
                    <div class="mb-3" style="font-size: 2rem; color: var(--pink-dark);"><i class="fa-solid fa-handshake"></i></div>
                    <h5 class="fw-bold">Nilai Inti</h5>
                    <p class="text-secondary mt-2 mb-0" style="font-size: 0.95rem;">Integritas, Transparansi Hasil, Inovasi Cepat, dan Keamanan Privasi Pengguna.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
