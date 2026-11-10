@extends('layouts.app')

@section('title', 'Dashboard Pelayanan')
@section('page_title', 'Dashboard Ruang Tamu Pelayanan')

@section('content')
<div class="container-fluid p-0">
    <!-- Welcome Banner -->
    <div class="card border-0 mb-4 overflow-hidden" style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);">
        <div class="card-body p-4 text-white position-relative">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="badge bg-white text-primary mb-2 px-3 py-1 fw-bold rounded-pill shadow-sm">
                        <i class="bi bi-geo-alt-fill text-danger me-1"></i> FRONT OFFICE PELAYANAN
                    </span>
                    <h3 class="fw-bold mb-1">Selamat Datang, {{ Auth::user()->name }}!</h3>
                    <p class="mb-0 text-white-50">Sistem Pencatatan dan Manajemen Tamu Ruang Pelayanan Dinas Pendidikan Kota Jambi.</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                        <a href="{{ route('tamu.create') }}" class="btn btn-warning fw-bold px-3 py-2 rounded-3 shadow-sm text-dark">
                            <i class="bi bi-person-plus-fill me-1"></i> Catat Tamu Baru
                        </a>
                        <a href="{{ route('kiosk.index') }}" target="_blank" class="btn btn-outline-light px-3 py-2 rounded-3">
                            <i class="bi bi-display me-1"></i> Kiosk Tamu
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats 4 Cards -->
    <div class="row g-3 mb-4">
        <!-- Total Hari Ini -->
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100 p-3 border-0 shadow-sm">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold">TAMU HARI INI</div>
                        <h2 class="fw-bold text-dark mt-1 mb-0">{{ $totalHariIni }}</h2>
                        <span class="badge bg-primary-subtle text-primary mt-2 small">
                            <i class="bi bi-calendar-event me-1"></i>{{ now()->translatedFormat('d M Y') }}
                        </span>
                    </div>
                    <div class="rounded-4 bg-primary text-white p-3 shadow-sm">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Bulan Ini -->
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100 p-3 border-0 shadow-sm">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold">TOTAL BULAN INI</div>
                        <h2 class="fw-bold text-primary mt-1 mb-0">{{ $totalBulanIni }}</h2>
                        <span class="badge bg-primary-subtle text-primary mt-2 small">
                            <i class="bi bi-calendar-month me-1"></i>{{ now()->translatedFormat('F Y') }}
                        </span>
                    </div>
                    <div class="rounded-4 bg-info text-white p-3 shadow-sm">
                        <i class="bi bi-calendar3 fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Input Mandiri (Kiosk) -->
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100 p-3 border-0 shadow-sm">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold">INPUT MANDIRI (KIOSK)</div>
                        <h2 class="fw-bold text-dark mt-1 mb-0">{{ $totalMandiri }}</h2>
                        <span class="badge bg-info-subtle text-info-emphasis mt-2 small">
                            <i class="bi bi-qr-code me-1"></i>Layar & HP Tamu
                        </span>
                    </div>
                    <div class="rounded-4 bg-warning text-dark p-3 shadow-sm">
                        <i class="bi bi-display fs-3"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Keseluruhan Buku -->
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100 p-3 border-0 shadow-sm">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted small fw-semibold">TOTAL KESELURUHAN</div>
                        <h2 class="fw-bold text-success mt-1 mb-0">{{ $totalKeseluruhan }}</h2>
                        <span class="badge bg-success-subtle text-success mt-2 small">
                            <i class="bi bi-check2-all me-1"></i>Arsip Register
                        </span>
                    </div>
                    <div class="rounded-4 bg-success text-white p-3 shadow-sm">
                        <i class="bi bi-journal-check fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <!-- Tren 7 Hari Terakhir -->
        <div class="col-lg-8">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
                    <h6 class="fw-bold text-dark mb-0">
                        <i class="bi bi-bar-chart-fill text-primary me-2"></i>Tren Kunjungan Tamu (7 Hari Terakhir)
                    </h6>
                    <span class="badge bg-light text-muted border">Live Database</span>
                </div>
                <div class="card-body">
                    <canvas id="trendChart" height="110"></canvas>
                </div>
            </div>
        </div>

        <!-- Kategori Instansi -->
        <div class="col-lg-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
                    <h6 class="fw-bold text-dark mb-0">
                        <i class="bi bi-pie-chart-fill text-info me-2"></i>Kategori Asal Tamu
                    </h6>
                    <span class="badge bg-light text-muted border">Jenjang</span>
                </div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <div style="width: 220px; height: 220px;">
                        <canvas id="kategoriChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Live Tamu Hari Ini Table -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white d-flex flex-wrap align-items-center justify-content-between py-3 gap-2">
            <div>
                <h6 class="fw-bold text-dark mb-1">
                    <i class="bi bi-table text-primary me-2"></i>Daftar Tamu Hari Ini ({{ now()->translatedFormat('l, d F Y') }})
                </h6>
                <small class="text-muted">Data tamu yang sedang atau telah dilayani hari ini di ruang tamu pelayanan</small>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('tamu.create') }}" class="btn btn-sm btn-primary rounded-pill px-3">
                    <i class="bi bi-plus-lg me-1"></i>Tambah Tamu
                </a>
                <a href="{{ route('tamu.index', ['filter_periode' => 'hari_ini']) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                    Lihat Semua
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3" style="width: 70px;">NO</th>
                        <th>WAKTU</th>
                        <th>NAMA LENGKAP / INSTANSI</th>
                        <th>KATEGORI & JABATAN</th>
                        <th>NO. HP / WA</th>
                        <th>TUJUAN BIDANG / RUANGAN</th>
                        <th>MAKSUD & KEPERLUAN</th>
                        <th class="text-center pe-3" style="width: 120px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tamuHariIni as $tamu)
                        <tr>
                            <td class="ps-3 fw-bold text-secondary">
                                #{{ $tamu->nomor_urut ?: $loop->iteration }}
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $tamu->jam_masuk }}</div>
                                <small class="text-muted">{{ $tamu->jam_keluar ? 's/d ' . $tamu->jam_keluar : 'Belum selesai' }}</small>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $tamu->nama }}</div>
                                @if($tamu->is_mandiri)
                                    <span class="badge bg-info-subtle text-info border px-1" style="font-size: 0.65rem;">Mandiri</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-secondary-subtle text-secondary me-1">{{ $tamu->kategori_instansi }}</span>
                                <small class="text-muted d-block">{{ $tamu->jabatan ?: '-' }}</small>
                            </td>
                            <td>
                                <a href="{{ $tamu->whatsapp_link }}" target="_blank" class="btn btn-sm btn-light border text-success py-1 px-2 rounded-pill small" title="Kirim Pesan WhatsApp">
                                    <i class="bi bi-whatsapp me-1"></i>{{ $tamu->no_hp }}
                                </a>
                            </td>
                            <td>
                                <div class="fw-semibold text-primary small">{{ $tamu->tujuan_bidang }}</div>
                            </td>
                            <td style="max-width: 250px;">
                                <div class="text-truncate" title="{{ $tamu->keperluan }}">{{ $tamu->keperluan }}</div>
                            </td>
                            <td class="text-center pe-3">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('tamu.show', $tamu->id) }}" class="btn btn-light border" title="Lihat Detail & Kartu Tamu">
                                        <i class="bi bi-eye-fill text-primary"></i>
                                    </a>
                                    <a href="{{ route('tamu.edit', $tamu->id) }}" class="btn btn-light border" title="Edit Data">
                                        <i class="bi bi-pencil-fill text-warning"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="bi bi-calendar-x fs-2 d-block mb-2 text-secondary"></i>
                                Belum ada data tamu tercatat hari ini. Klik <strong>Input Tamu Baru</strong> untuk mulai mencatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 1. Chart Tren 7 Hari Terakhir
    const ctxTrend = document.getElementById('trendChart').getContext('2d');
    new Chart(ctxTrend, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartDates) !!},
            datasets: [{
                label: 'Jumlah Kunjungan Tamu',
                data: {!! json_encode($chartCounts) !!},
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.35,
                pointBackgroundColor: '#1d4ed8',
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // 2. Chart Kategori Instansi (Doughnut)
    const ctxKategori = document.getElementById('kategoriChart').getContext('2d');
    const kategoriLabels = {!! json_encode($kategoriData->pluck('kategori_instansi')) !!};
    const kategoriValues = {!! json_encode($kategoriData->pluck('total')) !!};

    new Chart(ctxKategori, {
        type: 'doughnut',
        data: {
            labels: kategoriLabels,
            datasets: [{
                data: kategoriValues,
                backgroundColor: [
                    '#2563eb', '#059669', '#d97706', '#dc2626', '#8b5cf6', '#06b6d4', '#64748b'
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        font: { size: 10 }
                    }
                }
            }
        }
    });
</script>
@endsection

