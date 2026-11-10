<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Buku Tamu Digital') - Dinas Pendidikan Kota Jambi</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        :root {
            --disdik-navy: #0f172a;
            --disdik-blue: #1e3a8a;
            --disdik-accent: #2563eb;
            --disdik-gold: #f59e0b;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #f0fdf4 0%, #eff6ff 50%, #f8fafc 100%);
            min-height: 100vh;
            color: #1e293b;
        }

        .kiosk-navbar {
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            border-bottom: 2px solid #e2e8f0;
            padding: 1rem 2rem;
        }

        .btn-kiosk-primary {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            color: white;
            border: none;
            font-weight: 700;
            border-radius: 14px;
            padding: 0.9rem 2rem;
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
            transition: all 0.25s ease;
        }

        .btn-kiosk-primary:hover {
            color: white;
            background: linear-gradient(135deg, #1e40af, #1d4ed8);
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(37, 99, 235, 0.4);
        }

        .card-kiosk {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.06);
            background: #ffffff;
        }
    </style>
    @yield('styles')
</head>
<body class="d-flex flex-column">

    <!-- Header Navbar -->
    <header class="kiosk-navbar">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-primary text-white rounded-3 p-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px;">
                    <i class="bi bi-mortarboard-fill fs-3"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold text-dark">DINAS PENDIDIKAN KOTA JAMBI</h5>
                    <small class="text-primary fw-semibold"><i class="bi bi-heart-pulse-fill me-1"></i>Ruang Tamu & Pusat Pelayanan Terpadu</small>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                        <i class="bi bi-speedometer2 me-1"></i>Dashboard Petugas
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        <i class="bi bi-shield-lock me-1"></i>Login Petugas
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Content Area -->
    <main class="flex-grow-1 py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-top py-3 text-center text-muted small mt-auto">
        <div class="container">
            <div>Dinas Pendidikan Kota Jambi &bull; Ruang Tamu Pelayanan Publik &bull; Jl. H. Zainir Haviz, Paal Lima, Kota Jambi</div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('scripts')
</body>
</html>

