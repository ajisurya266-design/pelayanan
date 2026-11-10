<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Buku Tamu Pelayanan') - Disdik Kota Jambi</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        :root {
            --disdik-primary: #1e3a8a;
            --disdik-dark: #0f172a;
            --disdik-accent: #2563eb;
            --disdik-gold: #d97706;
            --disdik-bg: #f8fafc;
            --sidebar-width: 270px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--disdik-bg);
            color: #334155;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.05);
        }

        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            text-decoration: none;
        }

        .sidebar-brand-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: #f8fafc;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.35);
        }

        .sidebar-menu {
            padding: 1.25rem 0.85rem;
            list-style: none;
            margin: 0;
        }

        .sidebar-header {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94a3b8;
            font-weight: 700;
            padding: 0.85rem 0.75rem 0.4rem;
        }

        .sidebar-item {
            margin-bottom: 4px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.75rem 1rem;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 500;
            font-size: 0.92rem;
            transition: all 0.2s ease;
        }

        .sidebar-link:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
            transform: translateX(3px);
        }

        .sidebar-link.active {
            color: #ffffff;
            background: linear-gradient(90deg, #2563eb 0%, #1d4ed8 100%);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .sidebar-link i {
            font-size: 1.2rem;
        }

        /* Main Content Wrapper */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        /* Top Navbar */
        .top-navbar {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.85rem 2rem;
            position: sticky;
            top: 0;
            z-index: 900;
        }

        /* Main Page Content */
        .content-body {
            padding: 2rem;
            flex: 1;
        }

        /* Card Styles */
        .card {
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            background: #ffffff;
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid #f1f5f9;
            padding: 1.1rem 1.4rem;
        }

        /* Stat Badges */
        .badge-status {
            padding: 0.45em 0.85em;
            font-weight: 600;
            border-radius: 50rem;
            font-size: 0.75rem;
        }

        .badge-status-selesai {
            background-color: #dcfce7;
            color: #15803d;
        }

        .badge-status-sedang_dilayani {
            background-color: #e0f2fe;
            color: #0369a1;
        }

        .badge-status-menunggu {
            background-color: #fef3c7;
            color: #b45309;
        }

        .badge-status-dibatalkan {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        /* Button Custom */
        .btn-disdik {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            color: white;
            border: none;
            font-weight: 600;
            border-radius: 10px;
            padding: 0.6rem 1.25rem;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25);
            transition: all 0.2s;
        }

        .btn-disdik:hover {
            color: white;
            background: linear-gradient(135deg, #1e40af, #1d4ed8);
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.35);
        }

        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-wrapper {
                margin-left: 0;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <div>
                <div class="fw-bold fs-6 lh-1">BUKU TAMU</div>
                <div class="text-white-50" style="font-size: 0.72rem; margin-top: 4px;">Disdik Kota Jambi</div>
            </div>
        </a>

        <ul class="sidebar-menu">
            <li class="sidebar-header">MENU UTAMA</li>
            <li class="sidebar-item">
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('tamu.create') }}" class="sidebar-link {{ request()->routeIs('tamu.create') ? 'active' : '' }}">
                    <i class="bi bi-person-plus-fill"></i>
                    <span>Input Tamu Baru</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('tamu.index') }}" class="sidebar-link {{ request()->routeIs('tamu.index') || request()->routeIs('tamu.show') || request()->routeIs('tamu.edit') ? 'active' : '' }}">
                    <i class="bi bi-journal-bookmark-fill"></i>
                    <span>Buku Tamu Register</span>
                </a>
            </li>

            <li class="sidebar-header">LAPORAN & DOKUMENTASI</li>
            <li class="sidebar-item">
                <a href="{{ route('tamu.cetakLaporan') }}" target="_blank" class="sidebar-link">
                    <i class="bi bi-printer-fill"></i>
                    <span>Cetak Register Tamu</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('tamu.exportExcel') }}" class="sidebar-link">
                    <i class="bi bi-file-earmark-spreadsheet-fill text-success"></i>
                    <span>Export Data (Excel)</span>
                </a>
            </li>

            <li class="sidebar-header">FITUR TAMU / KIOSK</li>
            <li class="sidebar-item">
                <a href="{{ route('kiosk.qr_meja') }}" target="_blank" class="sidebar-link">
                    <i class="bi bi-qr-code-scan text-warning"></i>
                    <span>Cetak QR Meja Tamu</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('kiosk.index') }}" target="_blank" class="sidebar-link">
                    <i class="bi bi-display text-info"></i>
                    <span>Layar Kiosk Tamu <i class="bi bi-box-arrow-up-right ms-auto fs-6"></i></span>
                </a>
            </li>
        </ul>

        <div style="position: absolute; bottom: 20px; left: 16px; right: 16px; background: rgba(255,255,255,0.06); padding: 12px; border-radius: 10px;">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; font-weight: 700;">
                    {{ strtoupper(substr(Auth::user()->name ?? 'P', 0, 1)) }}
                </div>
                <div class="text-truncate">
                    <div class="text-white small fw-bold text-truncate">{{ Auth::user()->name ?? 'Petugas Magang' }}</div>
                    <div class="text-white-50" style="font-size: 0.72rem;">{{ Auth::user()->jabatan ?? 'Front Office' }}</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <header class="top-navbar d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light d-lg-none p-2 border" id="sidebarToggle">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <div>
                    <h5 class="mb-0 fw-bold text-dark">@yield('page_title', 'Ruang Tamu Pelayanan')</h5>
                    <small class="text-muted"><i class="bi bi-geo-alt-fill text-danger me-1"></i>Dinas Pendidikan Kota Jambi</small>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <!-- Live Clock -->
                <div class="d-none d-md-flex align-items-center bg-light px-3 py-1 rounded-pill border text-muted small">
                    <i class="bi bi-clock-fill text-primary me-2"></i>
                    <span id="liveClock">{{ now()->translatedFormat('l, d F Y') }} - <span id="clockTime">{{ now()->format('H:i:s') }} WIB</span></span>
                </div>

                <!-- Tombol Input Cepat -->
                <a href="{{ route('tamu.create') }}" class="btn btn-sm btn-disdik d-none d-sm-inline-flex align-items-center gap-2">
                    <i class="bi bi-plus-lg"></i>
                    <span>Input Tamu</span>
                </a>

                <!-- User Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-light border dropdown-toggle d-flex align-items-center gap-2 py-1 px-2 rounded-pill" type="button" data-bs-toggle="dropdown">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 0.8rem; font-weight: bold;">
                            {{ strtoupper(substr(Auth::user()->name ?? 'P', 0, 1)) }}
                        </div>
                        <span class="small fw-semibold d-none d-sm-inline">{{ Auth::user()->name ?? 'Petugas' }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-2">
                        <li class="px-3 py-2 border-bottom">
                            <div class="fw-bold text-dark">{{ Auth::user()->name ?? 'Petugas Pelayanan' }}</div>
                            <small class="text-muted">{{ Auth::user()->email ?? 'pelayanan@disdik.jambikota.go.id' }}</small>
                        </li>
                        <li><a class="dropdown-item py-2" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('kiosk.index') }}" target="_blank"><i class="bi bi-display me-2"></i>Layar Kiosk Tamu</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger py-2">
                                    <i class="bi bi-box-arrow-right me-2"></i>Keluar (Logout)
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="content-body">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center gap-2 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center gap-2 mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-5 text-danger"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center gap-2 mb-4" role="alert">
                    <i class="bi bi-info-circle-fill fs-5 text-info"></i>
                    <div>{{ session('info') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-top py-3 px-4 text-center text-muted small">
            <div>
                &copy; {{ date('Y') }} <strong>Dinas Pendidikan Kota Jambi</strong> &mdash; Ruang Tamu Pelayanan. Dikembangkan untuk Pelayanan Publik Prima.
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Toggle Sidebar on Mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('show');
        });

        // Realtime Clock Update
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const el = document.getElementById('clockTime');
            if (el) el.textContent = `${hours}:${minutes}:${seconds} WIB`;
        }
        setInterval(updateClock, 1000);
    </script>
    @yield('scripts')
</body>
</html>

