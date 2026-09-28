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
            --text-dark: #2c3e24; /* Elegant Dark Green for Text */
            --text-muted: #5f7056; /* Softer gray/green for descriptions */
            --shadow-soft: 0 10px 40px rgba(107, 139, 91, 0.08);
            --shadow-hover: 0 16px 48px rgba(107, 139, 91, 0.15);
        }
        body {
            background-color: var(--pink-soft);
            color: var(--text-dark);
            font-family: 'Plus Jakarta Sans', sans-serif;
            line-height: 1.6;
        }
        h1, h2, h3, h4, h5, h6 {
            color: var(--text-dark);
            letter-spacing: -0.5px;
        }
        p {
            color: var(--text-muted);
        }
        .bg-matcha {
            background-color: var(--matcha-soft) !important;
        }
        .btn {
            font-weight: 600;
            transition: all 0.2s ease;
            border-radius: 50rem;
            padding: 0.6rem 1.5rem;
        }
        .btn-lg {
            padding: 1rem 2rem;
            font-size: 1.1rem;
        }
        .btn-matcha {
            background-color: var(--matcha-dark);
            color: #fff;
            border: none;
            box-shadow: 0 4px 12px rgba(134, 167, 117, 0.3);
        }
        .btn-matcha:hover {
            background-color: var(--pink-dark);
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(107, 139, 91, 0.4);
        }
        .btn-pink {
            background-color: var(--pink-dark);
            color: #fff;
            border: none;
            box-shadow: 0 4px 12px rgba(107, 139, 91, 0.3);
        }
        .btn-pink:hover {
            background-color: #557248;
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(85, 114, 72, 0.4);
        }
        .btn-outline-secondary {
            border: 2px solid #e2e6d9 !important;
            color: var(--text-dark) !important;
        }
        .btn-outline-secondary:hover {
            background-color: var(--matcha-soft) !important;
            border-color: var(--matcha-soft) !important;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        }
        .navbar-custom {
            background-color: rgba(253, 251, 247, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            border-bottom: 1px solid rgba(0,0,0,0.03);
            padding-top: 0.8rem;
            padding-bottom: 0.8rem;
        }
        .card-custom {
            border-radius: 24px;
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(255,255,255,0.4);
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            background: #fff;
        }
        .card-custom:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-hover);
        }
        .card-header-matcha {
            background-color: var(--matcha-dark);
            color: white;
            font-weight: bold;
        }
        
        /* Micro-interactions (Scroll Reveal) */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.5, 0, 0, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        .delay-100 { transition-delay: 100ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }
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
    
    <!-- Scroll Reveal Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function reveal() {
                var reveals = document.querySelectorAll(".reveal");
                for (var i = 0; i < reveals.length; i++) {
                    var windowHeight = window.innerHeight;
                    var elementTop = reveals[i].getBoundingClientRect().top;
                    var elementVisible = 100;
                    if (elementTop < windowHeight - elementVisible) {
                        reveals[i].classList.add("active");
                    }
                }
            }
            window.addEventListener("scroll", reveal);
            reveal(); // Trigger on load
        });
    </script>
    @stack('scripts')
</body>
</html>
