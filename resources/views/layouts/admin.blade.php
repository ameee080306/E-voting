<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - E-Voting</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="preload" href="{{ asset('img/logo.png') }}" as="image">
    <!-- Custom CSS -->
    <style>
        :root {
            --matcha-soft: #EBEFDF;
            --matcha-dark: #86A775;
            --pink-soft: #FDFBF7;
            --pink-dark: #6B8B5B;
            --sidebar-bg: #86A775;
            --sidebar-color: #FFFFFF;
        }
        body {
            background-color: var(--pink-soft);
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
        }
        .wrapper {
            display: flex;
            width: 100%;
        }
        #sidebar {
            width: 250px;
            height: 100vh;
            position: sticky;
            top: 0;
            overflow-y: auto;
            background: var(--sidebar-bg);
            color: var(--sidebar-color);
            transition: all 0.3s;
            z-index: 1000;
        }
        /* Custom scrollbar for sidebar */
        #sidebar::-webkit-scrollbar {
            width: 6px;
        }
        #sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }
        #sidebar .sidebar-header {
            padding: 20px;
            background: #1a252f;
        }
        #sidebar ul.components {
            padding: 20px 0;
        }
        #sidebar ul p {
            color: #fff;
            padding: 10px;
        }
        #sidebar ul li a {
            padding: 15px 20px;
            font-size: 1.1em;
            display: block;
            color: var(--sidebar-color);
            text-decoration: none;
            transition: 0.3s;
        }
        #sidebar ul li a:hover {
            color: #fff;
            background: var(--matcha-dark);
        }
        #sidebar ul li.active > a {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            font-weight: 700;
        }
        #content {
            width: calc(100% - 250px);
            min-height: 100vh;
            transition: all 0.3s;
        }
        .navbar-custom {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(0,0,0,0.03);
            border-bottom: 1px solid rgba(0,0,0,0.03);
            position: sticky;
            top: 0;
            z-index: 1050;
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
    </style>
    @stack('styles')
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header d-flex align-items-center justify-content-center">
                <img src="{{ asset('img/logo.png') }}" alt="E-Voting Logo" class="me-2 rounded-circle shadow-sm" style="height: 45px; width: 45px; object-fit: cover; border: 2px solid white;">
                <h4 class="mb-0 fw-bold" style="letter-spacing: -0.5px;">E-VOTING</h4>
            </div>

            <ul class="list-unstyled components">
                <li>
                    <a href="{{ url('/') }}" target="_blank"><i class="fa-solid fa-globe me-2"></i> Beranda Publik</a>
                </li>
                <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" hx-get="{{ route('admin.dashboard') }}" hx-target="#content" hx-select="#content" hx-swap="outerHTML" hx-push-url="true"><i class="fa-solid fa-house me-2"></i> Dashboard</a>
                </li>
                <li class="{{ request()->routeIs('admin.mahasiswa.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.mahasiswa.index') }}" hx-get="{{ route('admin.mahasiswa.index') }}" hx-target="#content" hx-select="#content" hx-swap="outerHTML" hx-push-url="true"><i class="fa-solid fa-users me-2"></i> Data Mahasiswa</a>
                </li>
                <li class="{{ request()->routeIs('admin.kandidat.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.kandidat.index') }}" hx-get="{{ route('admin.kandidat.index') }}" hx-target="#content" hx-select="#content" hx-swap="outerHTML" hx-push-url="true"><i class="fa-solid fa-user-tie me-2"></i> Data Kandidat</a>
                </li>
                <li class="{{ request()->routeIs('admin.periode.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.periode.index') }}" hx-get="{{ route('admin.periode.index') }}" hx-target="#content" hx-select="#content" hx-swap="outerHTML" hx-push-url="true"><i class="fa-regular fa-calendar-alt me-2"></i> Periode Pemilihan</a>
                </li>
                <li class="{{ request()->routeIs('admin.voting.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.voting.index') }}" hx-get="{{ route('admin.voting.index') }}" hx-target="#content" hx-select="#content" hx-swap="outerHTML" hx-push-url="true"><i class="fa-solid fa-person-booth me-2"></i> Data Voting</a>
                </li>
                <li class="{{ request()->routeIs('admin.hasil.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.hasil.index') }}" hx-get="{{ route('admin.hasil.index') }}" hx-target="#content" hx-select="#content" hx-swap="outerHTML" hx-push-url="true"><i class="fa-solid fa-chart-pie me-2"></i> Hasil Voting</a>
                </li>
                <li class="{{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.laporan.index') }}" hx-get="{{ route('admin.laporan.index') }}" hx-target="#content" hx-select="#content" hx-swap="outerHTML" hx-push-url="true"><i class="fa-solid fa-file-pdf me-2"></i> Laporan</a>
                </li>

            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light navbar-custom py-3 px-4">
                <div class="container-fluid">
                    <span class="navbar-brand fw-bold">Admin Panel</span>
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                @if(auth()->user()->foto)
                                    <img src="{{ asset(auth()->user()->foto) }}" alt="Foto" class="rounded-circle me-2" style="width: 35px; height: 35px; object-fit: cover;">
                                @else
                                    <i class="fa-solid fa-user-circle fs-4 text-secondary me-2"></i>
                                @endif
                                <span class="fw-bold">{{ auth()->user()->nama }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.profil.index') }}"><i class="fa-solid fa-user-gear me-2"></i> Pengaturan Profil</a>
                                </li>
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
            </nav>

            <div class="p-4">
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
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- HTMX -->
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>
    <script>
        function initDataTables() {
            if ($.fn.DataTable.isDataTable('.datatable')) {
                $('.datatable').DataTable().destroy();
            }
            $('.datatable').DataTable();
        }
        $(document).ready(function() {
            initDataTables();
        });
        
        document.body.addEventListener('htmx:afterSwap', function(evt) {
            if (evt.detail.target.id === 'content') {
                initDataTables();
                // Update active class in sidebar based on new URL
                const newUrl = window.location.href.split('?')[0];
                $('#sidebar ul li').removeClass('active');
                $('#sidebar ul li a').each(function() {
                    if (this.href === newUrl) {
                        $(this).parent().addClass('active');
                    }
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
