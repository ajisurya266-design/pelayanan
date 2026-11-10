@extends('layouts.kiosk')

@section('title', 'Selamat Datang')

@section('styles')
<style>
    .hero-section {
        padding: 3rem 0 2rem;
    }

    .hero-badge {
        background: linear-gradient(135deg, #dbeafe, #eff6ff);
        border: 1px solid #bfdbfe;
        color: #1d4ed8;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        border-radius: 50px;
        padding: 0.4rem 1rem;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .hero-title {
        font-size: clamp(1.8rem, 4vw, 2.8rem);
        font-weight: 800;
        line-height: 1.2;
        color: #0f172a;
    }

    .hero-subtitle {
        color: #64748b;
        font-size: 1.05rem;
    }

    .counter-card {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        border-radius: 20px;
        color: white;
        padding: 1.5rem 2rem;
        display: inline-flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.35);
        min-width: 220px;
    }

    .counter-number {
        font-size: 2.8rem;
        font-weight: 800;
        line-height: 1;
    }

    .counter-label {
        font-size: 0.78rem;
        opacity: 0.8;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    .btn-start {
        background: linear-gradient(135deg, #1e3a8a, #2563eb);
        color: white;
        border: none;
        font-weight: 700;
        font-size: 1.15rem;
        border-radius: 16px;
        padding: 1rem 2.5rem;
        box-shadow: 0 8px 25px rgba(37, 99, 235, 0.35);
        transition: all 0.25s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
    }

    .btn-start:hover {
        color: white;
        background: linear-gradient(135deg, #1e40af, #1d4ed8);
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(37, 99, 235, 0.45);
    }

    .btn-start i {
        font-size: 1.3rem;
    }

    .info-card {
        background: white;
        border-radius: 16px;
        padding: 1.2rem 1.5rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        height: 100%;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .info-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    .info-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
    }

    .clock-display {
        font-size: 1rem;
        font-weight: 600;
        color: #475569;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 50px;
        padding: 0.4rem 1rem;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .divider-or {
        display: flex;
        align-items: center;
        gap: 1rem;
        color: #94a3b8;
        font-size: 0.85rem;
        font-weight: 600;
        margin: 0.5rem 0;
    }

    .divider-or::before,
    .divider-or::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e2e8f0;
    }
</style>
@endsection

@section('content')
<div class="container py-2">

    {{-- Hero Section --}}
    <div class="hero-section text-center">
        <div class="mb-3">
            <span class="hero-badge">
                <i class="bi bi-building-check-fill"></i>
                DINAS PENDIDIKAN KOTA JAMBI
            </span>
        </div>

        <h1 class="hero-title mb-3">
            Selamat Datang di<br>
            <span style="color: #1d4ed8;">Ruang Pelayanan</span>
        </h1>

        <p class="hero-subtitle mb-4 mx-auto" style="max-width: 480px;">
            Silakan isi buku tamu digital untuk membantu kami mencatat kunjungan dan memberikan pelayanan terbaik.
        </p>

        {{-- Live Clock --}}
        <div class="mb-4">
            <span class="clock-display">
                <i class="bi bi-clock-fill text-primary"></i>
                <span id="jam-sekarang">--:--:--</span>
                &bull;
                <span id="tanggal-sekarang">---</span>
            </span>
        </div>

        {{-- Visitor Counter --}}
        <div class="d-flex justify-content-center mb-5">
            <div class="counter-card">
                <div class="rounded-3 p-2 bg-white bg-opacity-25 d-flex align-items-center justify-content-center" style="width:52px;height:52px;">
                    <i class="bi bi-people-fill fs-2 text-white"></i>
                </div>
                <div class="text-start">
                    <div class="counter-number">{{ $totalHariIni }}</div>
                    <div class="counter-label">Kunjungan Hari Ini</div>
                </div>
            </div>
        </div>

        {{-- CTA Button --}}
        <div class="mb-3">
            <a href="{{ route('kiosk.form') }}" class="btn-start">
                <i class="bi bi-pencil-square"></i>
                Isi Buku Tamu Sekarang
            </a>
        </div>

        <p class="text-muted small mt-2">
            <i class="bi bi-shield-check me-1 text-success"></i>
            Data Anda aman dan hanya digunakan untuk keperluan administrasi pelayanan.
        </p>
    </div>

    <hr class="my-2 border-light">

    {{-- Info Cards --}}
    <div class="row g-3 mt-2 mb-4">
        <div class="col-md-4">
            <div class="info-card">
                <div class="d-flex align-items-start gap-3">
                    <div class="info-icon bg-primary-subtle text-primary">
                        <i class="bi bi-1-circle-fill"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark mb-1">Isi Formulir</div>
                        <div class="text-muted small">Lengkapi nama, instansi, dan keperluan kunjungan Anda.</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-card">
                <div class="d-flex align-items-start gap-3">
                    <div class="info-icon bg-warning-subtle text-warning">
                        <i class="bi bi-2-circle-fill"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark mb-1">Tunggu Panggilan</div>
                        <div class="text-muted small">Petugas kami akan memandu Anda ke bidang yang dituju.</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-card">
                <div class="d-flex align-items-start gap-3">
                    <div class="info-icon bg-success-subtle text-success">
                        <i class="bi bi-3-circle-fill"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark mb-1">Dilayani</div>
                        <div class="text-muted small">Urusan Anda akan diselesaikan dengan cepat dan ramah.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Jam Operasional --}}
    <div class="card-kiosk p-4 text-center">
        <h6 class="fw-bold text-dark mb-3">
            <i class="bi bi-calendar3 me-2 text-primary"></i>Jam Operasional Pelayanan
        </h6>
        <div class="row justify-content-center g-2">
            <div class="col-auto">
                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-semibold">
                    <i class="bi bi-sun me-1"></i> Senin – Kamis: 08.00 – 16.00 WIB
                </span>
            </div>
            <div class="col-auto">
                <span class="badge bg-warning-subtle text-warning-emphasis px-3 py-2 rounded-pill fw-semibold">
                    <i class="bi bi-sun-fill me-1"></i> Jumat: 08.00 – 11.30 WIB
                </span>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    function updateClock() {
        const now = new Date();
        const jam = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        const hari = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
        document.getElementById('jam-sekarang').textContent = jam;
        document.getElementById('tanggal-sekarang').textContent = hari;
    }
    updateClock();
    setInterval(updateClock, 1000);
</script>
@endsection

