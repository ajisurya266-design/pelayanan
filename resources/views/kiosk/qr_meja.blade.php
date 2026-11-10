@extends('layouts.kiosk')

@section('title', 'QR Meja Pelayanan')

@section('styles')
<style>
    @media print {
        .no-print { display: none !important; }
        body { background: white !important; }
        .card-kiosk { box-shadow: none !important; border: 1px solid #e2e8f0 !important; }
    }

    .qr-container {
        background: white;
        border-radius: 24px;
        padding: 2rem;
        text-align: center;
        border: 3px solid #1e3a8a;
        max-width: 380px;
        margin: 0 auto;
    }

    .qr-header-stripe {
        background: linear-gradient(135deg, #1e3a8a, #2563eb);
        border-radius: 14px;
        color: white;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
    }

    .qr-img-wrap {
        border: 3px dashed #e2e8f0;
        border-radius: 16px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 220px;
    }

    .qr-img-wrap img {
        max-width: 100%;
        width: 200px;
        height: 200px;
    }

    .qr-url {
        font-size: 0.75rem;
        word-break: break-all;
        color: #64748b;
        background: #f1f5f9;
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        font-family: monospace;
    }

    .instruction-step {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.6rem 0;
    }

    .step-dot {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1e3a8a, #2563eb);
        color: white;
        font-size: 0.7rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 2px;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            {{-- Page Header --}}
            <div class="d-flex align-items-center gap-3 mb-4 no-print">
                <a href="{{ route('kiosk.index') }}" class="btn btn-light border rounded-circle p-2" style="width:40px;height:40px;display:grid;place-items:center;">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h4 class="fw-bold mb-0">QR Code Meja Pelayanan</h4>
                    <p class="text-muted small mb-0">Cetak dan tempel di meja resepsionis untuk akses mandiri tamu</p>
                </div>
            </div>

            <div class="row g-4 align-items-start">

                {{-- QR Card (Printable) --}}
                <div class="col-md-5">
                    <div class="qr-container">
                        <div class="qr-header-stripe">
                            <div class="fw-bold fs-6 mb-1">DINAS PENDIDIKAN</div>
                            <div class="fw-black fs-5">KOTA JAMBI</div>
                            <div class="small opacity-75 mt-1">Buku Tamu Digital — Mandiri</div>
                        </div>

                        <div class="qr-img-wrap" id="qr-wrap">
                            <div id="qrcode"></div>
                        </div>

                        <div class="fw-bold text-dark mb-1" style="font-size: 1rem;">
                            <i class="bi bi-qr-code me-1 text-primary"></i>
                            Scan untuk Daftar Kunjungan
                        </div>
                        <p class="text-muted small mb-2">Arahkan kamera HP ke QR code ini</p>
                        <div class="qr-url">{{ url(route('kiosk.form', [], false)) }}</div>
                    </div>
                </div>

                {{-- Info & Controls --}}
                <div class="col-md-7">
                    <div class="card-kiosk p-4 mb-3 no-print">
                        <h6 class="fw-bold text-dark mb-3">
                            <i class="bi bi-info-circle me-2 text-primary"></i>Cara Penggunaan
                        </h6>
                        <div class="instruction-step">
                            <div class="step-dot">1</div>
                            <div class="small text-muted">Cetak QR code ini dan laminating agar tahan lama.</div>
                        </div>
                        <div class="instruction-step">
                            <div class="step-dot">2</div>
                            <div class="small text-muted">Tempel di meja resepsionis yang mudah terlihat tamu.</div>
                        </div>
                        <div class="instruction-step">
                            <div class="step-dot">3</div>
                            <div class="small text-muted">Tamu tinggal scan QR dengan kamera HP untuk mengisi buku tamu mandiri.</div>
                        </div>
                        <div class="instruction-step">
                            <div class="step-dot">4</div>
                            <div class="small text-muted">Data kunjungan otomatis masuk ke sistem dan tampil di dashboard petugas.</div>
                        </div>
                    </div>

                    <div class="card-kiosk p-4 no-print">
                        <h6 class="fw-bold text-dark mb-3">
                            <i class="bi bi-printer me-2 text-primary"></i>Cetak QR Code
                        </h6>
                        <p class="text-muted small mb-3">
                            Klik tombol di bawah untuk membuka dialog cetak browser. Pilih ukuran kertas <strong>A5</strong> atau <strong>A4</strong> agar QR tampil jelas.
                        </p>
                        <button onclick="window.print()" class="btn btn-kiosk-primary w-100 mb-2">
                            <i class="bi bi-printer-fill me-2"></i>Cetak / Print QR Code
                        </button>
                        <a href="{{ route('kiosk.form') }}" class="btn btn-outline-primary w-100 rounded-3" target="_blank">
                            <i class="bi bi-box-arrow-up-right me-2"></i>Preview Formulir Tamu
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    const formUrl = "{{ url(route('kiosk.form', [], false)) }}";
    new QRCode(document.getElementById('qrcode'), {
        text: formUrl,
        width: 200,
        height: 200,
        colorDark: '#1e3a8a',
        colorLight: '#ffffff',
        correctLevel: QRCode.CorrectLevel.H
    });
</script>
@endsection

