<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahasiswa Dashboard - E-Voting</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="preload" href="{{ asset('img/logo.png') }}" as="image">
    <!-- Custom CSS -->
    <style>
        :root {
            --matcha-soft: #EBEFDF; /* Soft Matcha */
            --matcha-dark: #86A775; /* Primary Soft Matcha */
            --pink-soft: #FDFBF7; /* Soft Cream */
            --pink-dark: #6B8B5B; /* Darker Matcha */
            --text-dark: #3A4B31; /* Elegant Dark Green */
        }
        body {
            background-color: var(--pink-soft);
            color: var(--text-dark);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .navbar-custom {
            background-color: rgba(253, 251, 247, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(0,0,0,0.04);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        .nav-custom-link.active {
            font-weight: 700;
            border-bottom: 2px solid var(--text-dark);
        }
        .card-custom {
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.03);
            overflow: hidden;
            background-color: #fff;
            transition: all 0.3s ease;
        }
        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.06);
        }
        .btn {
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-matcha {
            background-color: var(--matcha-dark);
            color: #fff;
            border: none;
            box-shadow: 0 4px 6px rgba(134, 167, 117, 0.2);
        }
        .btn-matcha:hover {
            background-color: var(--pink-dark);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(107, 139, 91, 0.3);
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-dark d-flex align-items-center" href="{{ route('mahasiswa.dashboard') }}">
                <img src="{{ asset('img/logo.png') }}" alt="E-Voting Logo" height="36" class="me-2">
                <span style="letter-spacing: -0.5px;">E-VOTING</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-4">
                    <li class="nav-item">
                        <a class="nav-link nav-custom-link" href="{{ url('/') }}" target="_blank">Beranda Publik</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-custom-link {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}" href="{{ route('mahasiswa.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-custom-link {{ request()->routeIs('mahasiswa.kandidat.*') ? 'active' : '' }}" href="{{ route('mahasiswa.kandidat.index') }}">Daftar Kandidat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-custom-link {{ request()->routeIs('mahasiswa.voting.*') ? 'active' : '' }}" href="{{ route('mahasiswa.voting.index') }}">Voting</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-custom-link {{ request()->routeIs('mahasiswa.hasil.*') ? 'active' : '' }}" href="{{ route('mahasiswa.hasil.index') }}">Hasil Pemilihan</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            @if(auth()->user()->foto)
                                <img src="{{ asset(auth()->user()->foto) }}" alt="Foto" class="rounded-circle me-2" style="width: 35px; height: 35px; object-fit: cover;">
                            @else
                                <i class="fa-solid fa-user-circle fs-4 text-secondary me-2"></i>
                            @endif
                            {{ auth()->user()->nama }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                            <li><a class="dropdown-item" href="{{ route('mahasiswa.profil.index') }}"><i class="fa-solid fa-user-gear me-2"></i> Profil Saya</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit"><i class="fa-solid fa-sign-out-alt me-2"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>
</html>
