@extends('layouts.kiosk')

@section('title', 'Pendaftaran Berhasil')

@section('styles')
<style>
    .success-icon-wrap {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: linear-gradient(135deg, #059669, #10b981);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        box-shadow: 0 15px 40px rgba(16, 185, 129, 0.35);
        animation: popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) both;
    }

    @keyframes popIn {
        from { transform: scale(0.5); opacity: 0; }
        to   { transform: scale(1);   opacity: 1; }
    }

    .kode-badge {
        background: linear-gradient(135deg, #1e3a8a, #2563eb);
        color: white;
        border-radius: 14px;
        padding: 1rem 1.5rem;
        font-size: 1.5rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        display: inline-block;
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 0.6rem 0;
        border-bottom: 1px solid #f1f5f9;
        gap: 1rem;
    }

    .detail-row:last-child { border-bottom: none; }

    .detail-label {
        font-size: 0.82rem;
        color: #94a3b8;
        font-weight: 600;
        min-width: 140px;
    }

    .detail-value {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1e293b;
        text-align: right;
    }

    .countdown-bar {
        height: 6px;
        background: #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        margin-top: 0.5rem;
    }

    .countdown-fill {
        height: 100%;
        background: linear-gradient(90deg, #1e3a8a, #2563eb);
        border-radius: 10px;
        transition: width 1s linear;
    }
</style>
@endsection

@section('content')
<div class="container py-4" style="max-width: 600px;">
    <div class="card-kiosk p-4 p-md-5 text-center mb-4">

        {{-- Success Icon --}}
        <div class="success-icon-wrap">
            <i class="bi bi-check-lg text-white" style="font-size: 2.5rem;"></i>
        </div>

        <h3 class="fw-bold text-dark mb-1">Pendaftaran Berhasil!</h3>
        <p class="text-muted mb-4">
            Kunjungan Anda telah tercatat. Silakan duduk dan tunggu panggilan petugas.
        </p>

        {{-- Kode Kunjungan --}}
        <div class="mb-4">
            <div class="text-muted small fw-semibold mb-2">KODE KUNJUNGAN ANDA</div>
            <div class="kode-badge">{{ $tamu->kode_kunjungan }}</div>
            <div class="text-muted small mt-2">
                <i class="bi bi-info-circle me-1"></i>
                Hafalkan atau foto kode ini untuk referensi Anda
            </div>
        </div>

        {{-- Nomor Urut --}}
        <div class="d-inline-flex align-items-center gap-2 bg-warning-subtle text-warning-emphasis rounded-pill px-4 py-2 fw-bold mb-4">
            <i class="bi bi-ticket-perforated-fill fs-5"></i>
            Nomor Antrian: <span class="fs-4 fw-black">{{ str_pad($tamu->nomor_urut, 3, '0', STR_PAD_LEFT) }}</span>
        </div>

    </div>

    {{-- Detail Kunjungan --}}
    <div class="card-kiosk p-4 mb-4">
        <h6 class="fw-bold text-dark mb-3">
            <i class="bi bi-person-badge me-2 text-primary"></i>Ringkasan Kunjungan
        </h6>

        @if($tamu->nama === $tamu->instansi)
        <div class="detail-row">
            <span class="detail-label">Nama / Instansi</span>
            <span class="detail-value">{{ $tamu->nama }}</span>
        </div>
        @else
        <div class="detail-row">
            <span class="detail-label">Nama</span>
            <span class="detail-value">{{ $tamu->nama }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Instansi</span>
            <span class="detail-value">{{ $tamu->instansi }}</span>
        </div>
        @endif
        <div class="detail-row">
            <span class="detail-label">Tanggal & Waktu</span>
            <span class="detail-value">{{ $tamu->hari }}, {{ $tamu->tanggal->format('d M Y') }} &bull; {{ $tamu->jam_masuk }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Tujuan Bidang</span>
            <span class="detail-value">{{ $tamu->tujuan_bidang }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Keperluan</span>
            <span class="detail-value">{{ $tamu->keperluan }}</span>
        </div>
    </div>

    {{-- Auto Redirect Notice --}}
    <div class="card-kiosk p-3 text-center">
        <p class="text-muted small mb-1">
            <i class="bi bi-arrow-repeat me-1 text-primary"></i>
            Halaman akan kembali ke beranda dalam
            <strong class="text-primary" id="countdown-num">15</strong> detik
        </p>
        <div class="countdown-bar mx-auto" style="max-width: 300px;">
            <div class="countdown-fill" id="countdown-bar" style="width: 100%;"></div>
        </div>
        <a href="{{ route('kiosk.index') }}" class="btn btn-sm btn-outline-primary rounded-pill mt-3 px-4">
            <i class="bi bi-house me-1"></i>Kembali ke Beranda
        </a>
    </div>

</div>
@endsection

@section('scripts')
<script>
    let seconds = 15;
    const numEl = document.getElementById('countdown-num');
    const barEl = document.getElementById('countdown-bar');

    const timer = setInterval(() => {
        seconds--;
        numEl.textContent = seconds;
        barEl.style.width = (seconds / 15 * 100) + '%';
        if (seconds <= 0) {
            clearInterval(timer);
            window.location.href = "{{ route('kiosk.index') }}";
        }
    }, 1000);
</script>
@endsection

