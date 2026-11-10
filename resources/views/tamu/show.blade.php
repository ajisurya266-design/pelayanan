@extends('layouts.app')

@section('title', 'Detail Tamu - ' . $tamu->nama)
@section('page_title', 'Detail Tamu Pelayanan')

@section('content')
<div class="container-fluid p-0">
    <div class="row justify-content-center">
        <div class="col-xl-10">

            {{-- Header --}}
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                <div>
                    <h4 class="fw-bold text-dark mb-1">
                        <i class="bi bi-person-badge-fill text-primary me-2"></i>Detail Data Tamu Pelayanan
                    </h4>
                    <p class="text-muted small mb-0">Informasi lengkap kunjungan tamu ke Dinas Pendidikan Kota Jambi.</p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('tamu.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2 bg-white">
                        <i class="bi bi-arrow-left"></i>
                        <span>Kembali ke Register</span>
                    </a>
                    <a href="{{ route('tamu.edit', $tamu->id) }}" class="btn btn-warning d-inline-flex align-items-center gap-2">
                        <i class="bi bi-pencil-square"></i>
                        <span>Edit Data</span>
                    </a>
                    <button onclick="window.print()" class="btn btn-outline-primary d-inline-flex align-items-center gap-2 bg-white">
                        <i class="bi bi-printer-fill"></i>
                        <span>Cetak Kartu</span>
                    </button>
                </div>
            </div>

            {{-- Alert Success --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Kartu Kunjungan / Visitor Card --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4" id="kartu-pengunjung">
                <div class="card-header p-4" style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="text-white">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="bi bi-building fs-5"></i>
                                <span class="badge bg-white text-primary fw-bold">KARTU PENGUNJUNG</span>
                            </div>
                            <h5 class="mb-0 fw-bold text-white">Dinas Pendidikan Kota Jambi</h5>
                            <small class="text-white-50">Ruang Pelayanan Tamu</small>
                        </div>
                        <div class="text-end text-white">
                            <div class="fw-bold fs-5">{{ $tamu->kode_kunjungan }}</div>
                            <small class="text-white-50">Kode Kunjungan</small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4">
                        {{-- Kolom Kiri: Data Pengunjung --}}
                        <div class="col-md-8">
                            <div class="row g-3">
                                {{-- Nama & Instansi --}}
                                @if($tamu->nama === $tamu->instansi)
                                <div class="col-12">
                                    <label class="form-label text-muted small fw-bold mb-1">
                                        <i class="bi bi-person-badge me-1"></i>Nama Pengunjung / Instansi
                                    </label>
                                    <div class="fw-bold text-dark fs-5">{{ $tamu->nama }}</div>
                                    <span class="badge bg-primary-subtle text-primary border mt-1" style="font-size: 0.72rem;">{{ $tamu->kategori_instansi }}</span>
                                </div>
                                @else
                                <div class="col-sm-6">
                                    <label class="form-label text-muted small fw-bold mb-1">
                                        <i class="bi bi-person me-1"></i>Nama Lengkap
                                    </label>
                                    <div class="fw-bold text-dark fs-6">{{ $tamu->nama }}</div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label text-muted small fw-bold mb-1">
                                        <i class="bi bi-building me-1"></i>Instansi / Sekolah
                                    </label>
                                    <div class="fw-semibold text-dark">{{ $tamu->instansi }}</div>
                                    <span class="badge bg-primary-subtle text-primary border mt-1" style="font-size: 0.72rem;">{{ $tamu->kategori_instansi }}</span>
                                </div>
                                @endif

                                {{-- Jabatan --}}
                                <div class="col-sm-6">
                                    <label class="form-label text-muted small fw-bold mb-1">
                                        <i class="bi bi-briefcase me-1"></i>Jabatan
                                    </label>
                                    <div class="text-dark">{{ $tamu->jabatan ?: '-' }}</div>
                                </div>

                                {{-- No HP --}}
                                <div class="col-sm-6">
                                    <label class="form-label text-muted small fw-bold mb-1">
                                        <i class="bi bi-telephone me-1"></i>No. HP / WhatsApp
                                    </label>
                                    <div>
                                        <a href="{{ $tamu->whatsapp_link }}" target="_blank" class="btn btn-sm btn-light border text-success rounded-pill px-3 py-1">
                                            <i class="bi bi-whatsapp me-1"></i>{{ $tamu->no_hp }}
                                        </a>
                                    </div>
                                </div>

                                {{-- Keperluan --}}
                                <div class="col-12">
                                    <label class="form-label text-muted small fw-bold mb-1">
                                        <i class="bi bi-chat-left-text me-1"></i>Keperluan / Maksud Kunjungan
                                    </label>
                                    <div class="text-dark bg-light rounded-3 p-3 border">{{ $tamu->keperluan }}</div>
                                </div>

                                {{-- Tujuan Bidang --}}
                                <div class="col-12">
                                    <label class="form-label text-muted small fw-bold mb-1">
                                        <i class="bi bi-arrow-right-circle me-1"></i>Bidang yang Dituju
                                    </label>
                                    <div class="fw-semibold text-primary">{{ $tamu->tujuan_bidang }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- Kolom Kanan: Waktu, Status, TTD --}}
                        <div class="col-md-4">
                            {{-- Info Waktu --}}
                            <div class="bg-light rounded-3 p-3 border mb-3">
                                <div class="text-center mb-2">
                                    <span class="badge bg-dark fw-bold px-3 py-2 fs-6">
                                        <i class="bi bi-calendar-event me-1"></i>{{ $tamu->hari }}, {{ $tamu->tanggal ? $tamu->tanggal->format('d/m/Y') : '-' }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-center gap-3">
                                    <div class="text-center">
                                        <small class="text-muted d-block">Jam Masuk</small>
                                        <span class="fw-bold text-success">{{ $tamu->jam_masuk ?: '-' }}</span>
                                    </div>
                                    <div class="text-center">
                                        <small class="text-muted d-block">Jam Keluar</small>
                                        <span class="fw-bold text-danger">{{ $tamu->jam_keluar ?: '-' }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Nomor Urut --}}
                            <div class="text-center mb-3">
                                <label class="form-label text-muted small fw-bold mb-1">Nomor Urut</label>
                                <div class="fw-bold fs-3 text-primary">#{{ $tamu->nomor_urut }}</div>
                            </div>

                            {{-- Tanda Tangan --}}
                            <div class="text-center">
                                <label class="form-label text-muted small fw-bold mb-1">Tanda Tangan</label>
                                <div class="bg-white rounded-3 border p-2 shadow-sm d-inline-block">
                                    @if($tamu->tanda_tangan)
                                        <img src="{{ $tamu->tanda_tangan }}" alt="Tanda Tangan" style="max-height: 90px; max-width: 100%;">
                                    @else
                                        <div class="text-muted small p-3">
                                            <i class="bi bi-pen fs-4 d-block mb-1"></i>
                                            Belum ada tanda tangan
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="card-footer bg-light border-top py-3 px-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div class="small text-muted">
                            @if($tamu->is_mandiri)
                                <span class="badge bg-info-subtle text-info border me-2"><i class="bi bi-qr-code me-1"></i>Input Mandiri</span>
                            @endif
                            @if($tamu->petugas)
                                <i class="bi bi-person-check me-1"></i>Dicatat oleh: <strong>{{ $tamu->petugas->name }}</strong>
                            @endif
                        </div>
                        <div class="small text-muted">
                            @if($tamu->keterangan_tindak_lanjut)
                                <i class="bi bi-info-circle me-1"></i>Tindak Lanjut: <em>{{ $tamu->keterangan_tindak_lanjut }}</em>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Foto Tamu --}}
            @if($tamu->foto)
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-white p-3 border-bottom">
                    <h6 class="fw-bold mb-0"><i class="bi bi-camera-fill text-primary me-2"></i>Foto Pengunjung</h6>
                </div>
                <div class="card-body text-center p-4">
                    <img src="{{ asset('storage/' . $tamu->foto) }}" alt="Foto {{ $tamu->nama }}" class="rounded-3 shadow-sm border" style="max-height: 300px; max-width: 100%; object-fit: contain;">
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    @media print {
        .sidebar, .topbar, .btn, .alert, nav, footer {
            display: none !important;
        }
        .main-content {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        #kartu-pengunjung {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
        @page {
            size: A4 portrait;
            margin: 10mm;
        }
    }
</style>
@endsection

