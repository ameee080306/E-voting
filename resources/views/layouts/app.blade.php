<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem E-Voting</title>
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
            --matcha-soft: #EBEFDF; /* Soft Matcha (Navbar/Light elements) */
            --matcha-dark: #86A775; /* Primary Soft Matcha (Buttons) */
            --pink-soft: #FDFBF7; /* Soft Cream (Background) */
            --pink-dark: #6B8B5B; /* Darker Matcha (Hover/Accents) */
            --text-dark: #3A4B31; /* Elegant Dark Green for Text */
        }
        body {
            background-color: var(--pink-soft);
            color: var(--text-dark);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .bg-matcha {
            background-color: var(--matcha-soft) !important;
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
        .btn-pink {
            background-color: var(--pink-dark);
            color: #fff;
            border: none;
        }
        .btn-pink:hover {
            background-color: #557248;
            color: #fff;
            transform: translateY(-2px);
        }
        .navbar-custom {
            background-color: rgba(253, 251, 247, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(0,0,0,0.04);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        .card-custom {
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.03);
            overflow: hidden;
            transition: all 0.3s ease;
            background: #fff;
        }
        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.06);
        }
        .card-header-matcha {
            background-color: var(--matcha-dark);
            color: white;
            font-weight: bold;
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand fw-bold text-dark d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('img/logo.png') }}" alt="E-Voting Logo" height="36" class="me-2">
                <span style="letter-spacing: -0.5px;">E-VOTING</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-toggle="target" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/#tentang') }}">Tentang</a>
                    </li>
                    @guest
                    <li class="nav-item">
                        <a class="nav-link btn btn-pink text-white ms-2 px-3 rounded-pill" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-dark ms-2 px-3 rounded-pill" href="{{ route('register') }}">Register</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link btn btn-matcha text-white ms-2 px-3 rounded-pill" href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : route('mahasiswa.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-danger text-white ms-2 px-3 rounded-pill">Logout</button>
                        </form>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
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
