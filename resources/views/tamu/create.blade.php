@extends('layouts.app')

@section('title', 'Input Tamu Pelayanan Baru')
@section('page_title', 'Input Tamu Pelayanan')

@section('content')
<div class="container-fluid p-0">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <!-- Header Card -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="fw-bold text-dark mb-1">
                        <i class="bi bi-person-plus-fill text-primary me-2"></i>Formulir Registrasi Tamu Pelayanan
                    </h4>
                    <p class="text-muted small mb-0">Pencatatan data pengunjung Ruang Tamu Pelayanan Dinas Pendidikan Kota Jambi.</p>
                </div>
                <a href="{{ route('tamu.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2 bg-white">
                    <i class="bi bi-arrow-left"></i>
                    <span>Kembali ke Register</span>
                </a>
            </div>

            <!-- Main Form Card -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white p-3 p-md-4">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div>
                            <span class="badge bg-white text-primary fw-bold mb-1">REGISTER RESMI</span>
                            <h5 class="mb-0 fw-bold">No. Urut: #{{ $nextNomorUrut }} &bull; Register: {{ $nextKode }}</h5>
                        </div>
                        <div class="text-md-end">
                            <div class="badge bg-white text-primary fw-semibold px-3 py-2 shadow-sm rounded-3" id="badgeLiveClock">
                                <i class="bi bi-calendar3 me-1"></i>{{ $namaHari }}, {{ $today->translatedFormat('d F Y') }} &bull; {{ $jamSekarang }} WIB
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    @if($errors->any())
                        <div class="alert alert-danger rounded-3 border-0 mb-4">
                            <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i>Harap periksa isian formulir:</div>
                            <ul class="mb-0 ps-3 small">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('tamu.store') }}" method="POST" enctype="multipart/form-data" id="formTamu">
                        @csrf

                        <!-- Hidden Signature base64 -->
                        <input type="hidden" name="tanda_tangan" id="tanda_tangan_input">

                        <!-- BAGIAN 1: WAKTU & REGISTER -->
                        <div class="border-bottom pb-4 mb-4">
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="bi bi-clock-history me-2"></i>1. WAKTU & REGISTER BUKU
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-4 col-12">
                                    <label class="form-label small fw-bold text-secondary">Nomor Urut Buku (Otomatis)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-primary fw-bold">#</span>
                                        <input type="text" class="form-control bg-light fw-bold text-primary" value="{{ $nextNomorUrut }}" readonly>
                                        <span class="input-group-text bg-light text-success small fw-semibold"><i class="bi bi-magic me-1"></i>Otomatis</span>
                                    </div>
                                    <div class="form-text small text-muted">Nomor urut bertambah otomatis dari sistem.</div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <label class="form-label small fw-bold text-secondary">Tanggal Kunjungan</label>
                                    <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $today->format('Y-m-d')) }}" required>
                                </div>
                                <div class="col-md-4 col-6">
                                    <label class="form-label small fw-bold text-secondary">Jam Masuk (WIB)</label>
                                    <div class="input-group">
                                        <input type="time" name="jam_masuk" id="inputJamMasuk" class="form-control" value="{{ old('jam_masuk', $jamSekarang) }}" required>
                                        <button type="button" class="btn btn-outline-secondary" id="btnJamSekarang" title="Reset ke Jam Sekarang">
                                            <i class="bi bi-clock"></i>
                                        </button>
                                    </div>
                                    <div class="form-text small text-muted">Otomatis mengikuti jam sekarang saat dibuka.</div>
                                </div>
                            </div>
                        </div>

                        <!-- BAGIAN 2: IDENTITAS TAMU & INSTANSI -->
                        <div class="border-bottom pb-4 mb-4">
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="bi bi-person-vcard-fill me-2"></i>2. IDENTITAS PENGUNJUNG / ASAL INSTANSI
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-secondary">Nama Lengkap / Instansi <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-person-badge"></i></span>
                                        <input type="text" name="nama" id="inputNamaInstansi" list="listSekolah" class="form-control" value="{{ old('nama', old('instansi')) }}" required placeholder="Contoh: Budi Santoso / SDN 046 Kota Jambi">
                                    </div>
                                    <div class="form-text small">Bebas diisi nama pribadi atau nama sekolah/instansi asal.</div>
                                    <datalist id="listSekolah">
                                        <option value="SDN 01/IV Kota Jambi">
                                        <option value="SDN 046 Kota Jambi">
                                        <option value="SDN 54 Kota Jambi">
                                        <option value="SDN 94 Kota Jambi">
                                        <option value="SDN 95/IV Kota Jambi">
                                        <option value="SDN 118/IV Kota Jambi">
                                        <option value="SDN 151 Kota Jambi">
                                        <option value="SDN 216 Kota Jambi">
                                        <option value="SMPN 1 Kota Jambi">
                                        <option value="SMPN 14 Kota Jambi">
                                        <option value="SMPN 15 Kota Jambi">
                                        <option value="SMPN 18 Kota Jambi">
                                        <option value="SMPN 22 Kota Jambi">
                                        <option value="SMP AL-Ikhlas Kota Jambi">
                                        <option value="TK ABA IV Kota Jambi">
                                        <option value="SKB Kota Jambi">
                                        <option value="PKBM Istanaku">
                                        <option value="Masyarakat / Umum">
                                    </datalist>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-secondary">Nomor HP / WhatsApp <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-whatsapp text-success"></i></span>
                                        <input type="tel" name="no_hp" class="form-control" value="{{ old('no_hp') }}" required placeholder="Contoh: 082178760065">
                                    </div>
                                    <div class="form-text small">Dapat digunakan untuk konfirmasi status layanan via WhatsApp</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-secondary">Jenjang / Kategori <span class="text-danger">*</span></label>
                                    <select name="kategori_instansi" class="form-select" required>
                                        @foreach($kategoriList as $kat)
                                            <option value="{{ $kat }}" {{ old('kategori_instansi') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-secondary">Jabatan / Profesi</label>
                                    <select name="jabatan" class="form-select">
                                        <option value="">-- Pilih Jabatan --</option>
                                        @foreach($jabatanList as $jab)
                                            <option value="{{ $jab }}" {{ old('jabatan') == $jab ? 'selected' : '' }}>{{ $jab }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- BAGIAN 3: TUJUAN BIDANG & KEPERLUAN -->
                        <div class="border-bottom pb-4 mb-4">
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="bi bi-diagram-3-fill me-2"></i>3. TUJUAN BIDANG & KEPERLUAN KUNJUNGAN
                            </h6>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label small fw-bold text-secondary">Bidang yang Dituju <span class="text-danger">*</span></label>
                                    <select name="tujuan_bidang" class="form-select" required>
                                        @foreach($bidangList as $bid)
                                            <option value="{{ $bid }}" {{ old('tujuan_bidang') == $bid ? 'selected' : '' }}>{{ $bid }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label small fw-bold text-secondary">Maksud & Keperluan Kunjungan <span class="text-danger">*</span></label>
                                    <textarea name="keperluan" id="inputKeperluan" rows="3" class="form-control" required placeholder="Tuliskan keperluan kunjungan secara detail...">{{ old('keperluan') }}</textarea>
                                </div>

                                <!-- Quick Chips Keperluan -->
                                <div class="col-12">
                                    <div class="small fw-bold text-muted mb-2">
                                        <i class="bi bi-lightning-charge-fill text-warning me-1"></i>Klik Cepat Pilihan Keperluan yang Sering Diajukan:
                                    </div>
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach($keperluanChips as $chip)
                                            <button type="button" class="btn btn-sm btn-light border rounded-pill py-1 px-2 small text-secondary chip-btn" onclick="addKeperluan('{{ $chip }}')">
                                                + {{ $chip }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- BAGIAN 4: TANDA TANGAN DIGITAL (CANVAS) -->
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="bi bi-pen-fill me-2"></i>4. TANDA TANGAN DIGITAL / PARAF TAMU
                            </h6>
                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <div class="card border p-2 bg-light">
                                        <div class="d-flex align-items-center justify-content-between mb-2 px-1">
                                            <span class="small fw-semibold text-muted">
                                                <i class="bi bi-hand-index-thumb me-1"></i>Tanda tangan langsung pada kotak di bawah:
                                            </span>
                                            <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2 rounded-pill small" id="clearPad">
                                                <i class="bi bi-eraser-fill me-1"></i>Hapus
                                            </button>
                                        </div>
                                        <div class="bg-white rounded-3 border overflow-hidden position-relative" style="height: 180px;">
                                            <canvas id="signatureCanvas" style="width: 100%; height: 100%; cursor: crosshair;"></canvas>
                                            <div id="padPlaceholder" class="position-absolute top-50 start-50 translate-middle text-muted opacity-50 pe-none small">
                                                (Goreskan paraf / tanda tangan di sini)
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <label class="form-label small fw-bold text-secondary">Catatan / Tindak Lanjut Pelayanan (Opsional)</label>
                                    <textarea name="keterangan_tindak_lanjut" rows="4" class="form-control" placeholder="Contoh: Berkas telah diterima dan diteruskan ke Seksi Tenaga Pendidik.">{{ old('keterangan_tindak_lanjut') }}</textarea>
                                    <div class="form-text small">Catatan internal petugas front office mengenai disposisi atau hasil pelayanan.</div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                            <a href="{{ route('tamu.index') }}" class="btn btn-light border px-4 py-2 rounded-3">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-disdik px-5 py-2 fs-6">
                                <i class="bi bi-check-circle-fill me-2"></i>Simpan Data Tamu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Quick chips append to textarea
    function addKeperluan(text) {
        const textarea = document.getElementById('inputKeperluan');
        if (textarea.value.trim() === '') {
            textarea.value = text;
        } else {
            textarea.value += ', ' + text;
        }
        textarea.focus();
    }

    // Digital Signature Pad (Pure Canvas Implementation)
    const canvas = document.getElementById('signatureCanvas');
    const placeholder = document.getElementById('padPlaceholder');
    const hiddenInput = document.getElementById('tanda_tangan_input');
    const clearBtn = document.getElementById('clearPad');
    const ctx = canvas.getContext('2d');

    // Set canvas dimensions
    function resizeCanvas() {
        const rect = canvas.getBoundingClientRect();
        canvas.width = rect.width;
        canvas.height = rect.height;
        ctx.strokeStyle = '#0f172a';
        ctx.lineWidth = 2.5;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
    }
    window.addEventListener('resize', resizeCanvas);
    setTimeout(resizeCanvas, 200);

    let drawing = false;
    let hasSigned = false;

    function getPos(e) {
        const rect = canvas.getBoundingClientRect();
        const clientX = e.clientX || (e.touches && e.touches[0].clientX);
        const clientY = e.clientY || (e.touches && e.touches[0].clientY);
        return {
            x: clientX - rect.left,
            y: clientY - rect.top
        };
    }

    function startDraw(e) {
        drawing = true;
        hasSigned = true;
        if (placeholder) placeholder.style.display = 'none';
        const pos = getPos(e);
        ctx.beginPath();
        ctx.moveTo(pos.x, pos.y);
        e.preventDefault();
    }

    function moveDraw(e) {
        if (!drawing) return;
        const pos = getPos(e);
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
        e.preventDefault();
    }

    function endDraw(e) {
        if (drawing) {
            ctx.closePath();
            drawing = false;
            hiddenInput.value = canvas.toDataURL('image/png');
        }
    }

    // Mouse Events
    canvas.addEventListener('mousedown', startDraw);
    canvas.addEventListener('mousemove', moveDraw);
    canvas.addEventListener('mouseup', endDraw);
    canvas.addEventListener('mouseleave', endDraw);

    // Touch Events for Tablets & Mobile
    canvas.addEventListener('touchstart', startDraw, { passive: false });
    canvas.addEventListener('touchmove', moveDraw, { passive: false });
    canvas.addEventListener('touchend', endDraw);

    // Clear Button
    clearBtn.addEventListener('click', function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        hiddenInput.value = '';
        hasSigned = false;
        if (placeholder) placeholder.style.display = 'block';
    });

    // Form Submit check
    document.getElementById('formTamu').addEventListener('submit', function() {
        if (hasSigned) {
            hiddenInput.value = canvas.toDataURL('image/png');
        }
    });

    // Auto-sync jam masuk dengan waktu sekarang (WIB / real-time)
    const jamInput = document.getElementById('inputJamMasuk');
    let userEditedJam = false;

    function getNowTimeHHMM() {
        const now = new Date();
        const hh = String(now.getHours()).padStart(2, '0');
        const mm = String(now.getMinutes()).padStart(2, '0');
        return `${hh}:${mm}`;
    }

    if (jamInput) {
        @if(!old('jam_masuk'))
            jamInput.value = getNowTimeHHMM();
        @endif

        jamInput.addEventListener('input', function() {
            userEditedJam = true;
        });

        const btnJam = document.getElementById('btnJamSekarang');
        if (btnJam) {
            btnJam.addEventListener('click', function() {
                jamInput.value = getNowTimeHHMM();
                userEditedJam = false;
            });
        }

        // Jika halaman dibiarkan terbuka, terus update jam secara berkala
        // selama pengguna belum mengubahnya secara manual
        setInterval(function() {
            if (!userEditedJam && document.activeElement !== jamInput) {
                jamInput.value = getNowTimeHHMM();
            }
        }, 15000);
    }

    // Live update badge tanggal & jam di pojok kanan atas
    function updateBadgeLiveClock() {
        const el = document.getElementById('badgeLiveClock');
        if (!el) return;
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const now = new Date();
        const hari = days[now.getDay()];
        const tgl = String(now.getDate()).padStart(2, '0');
        const bln = months[now.getMonth()];
        const thn = now.getFullYear();
        const hh = String(now.getHours()).padStart(2, '0');
        const mm = String(now.getMinutes()).padStart(2, '0');
        const ss = String(now.getSeconds()).padStart(2, '0');
        el.innerHTML = `<i class="bi bi-calendar3 me-1"></i>${hari}, ${tgl} ${bln} ${thn} &bull; ${hh}:${mm}:${ss} WIB`;
    }
    updateBadgeLiveClock();
    setInterval(updateBadgeLiveClock, 1000);
</script>
@endsection

