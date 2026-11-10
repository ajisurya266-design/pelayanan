@extends('layouts.app')

@section('title', 'Edit Tamu Pelayanan')
@section('page_title', 'Edit Data Tamu Pelayanan')

@section('content')
<div class="container-fluid p-0">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <!-- Header Card -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="fw-bold text-dark mb-1">
                        <i class="bi bi-pencil-square text-warning me-2"></i>Perbarui Data Tamu Pelayanan
                    </h4>
                    <p class="text-muted small mb-0">Ubah data kunjungan untuk register: <strong>{{ $tamu->kode_kunjungan }}</strong></p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('tamu.show', $tamu->id) }}" class="btn btn-outline-primary bg-white">
                        <i class="bi bi-eye me-1"></i>Lihat Detail
                    </a>
                    <a href="{{ route('tamu.index') }}" class="btn btn-outline-secondary bg-white">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-bottom p-3 p-md-4">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                        <div>
                            <span class="badge bg-primary text-white mb-1">REGISTER #{{ $tamu->nomor_urut }}</span>
                            <h5 class="mb-0 fw-bold text-dark">{{ $tamu->nama }}{{ ($tamu->instansi && $tamu->instansi !== $tamu->nama) ? ' &mdash; ' . $tamu->instansi : '' }}</h5>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    @if($errors->any())
                        <div class="alert alert-danger rounded-3 border-0 mb-4">
                            <ul class="mb-0 ps-3 small">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('tamu.update', $tamu->id) }}" method="POST" id="formEdit">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="tanda_tangan" id="tanda_tangan_input" value="{{ $tamu->tanda_tangan }}">

                        <!-- Row 1: Waktu & Register -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-3 col-6">
                                <label class="form-label small fw-bold text-secondary">Nomor Urut Buku</label>
                                <input type="number" name="nomor_urut" class="form-control" value="{{ old('nomor_urut', $tamu->nomor_urut) }}">
                            </div>
                            <div class="col-md-3 col-6">
                                <label class="form-label small fw-bold text-secondary">Tanggal Kunjungan</label>
                                <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $tamu->tanggal ? $tamu->tanggal->format('Y-m-d') : '') }}" required>
                            </div>
                            <div class="col-md-3 col-6">
                                <label class="form-label small fw-bold text-secondary">Jam Masuk (WIB)</label>
                                <input type="time" name="jam_masuk" class="form-control" value="{{ old('jam_masuk', $tamu->jam_masuk) }}" required>
                            </div>
                            <div class="col-md-3 col-6">
                                <label class="form-label small fw-bold text-secondary">Jam Keluar (WIB)</label>
                                <div class="input-group">
                                    <input type="time" name="jam_keluar" id="inputJamKeluar" class="form-control" value="{{ old('jam_keluar', $tamu->jam_keluar) }}">
                                    <button type="button" class="btn btn-outline-secondary" id="btnJamKeluarNow" title="Set ke Jam Sekarang">
                                        <i class="bi bi-clock"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Row 2: Identitas Tamu -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">Nama Lengkap / Instansi</label>
                                <input type="text" name="nama" class="form-control" value="{{ old('nama', $tamu->nama) }}" required placeholder="Contoh: Budi Santoso / SDN 046 Kota Jambi">
                                <div class="form-text small">Bebas diisi nama pribadi atau nama sekolah/instansi asal.</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">Nomor HP / WhatsApp</label>
                                <input type="tel" name="no_hp" class="form-control" value="{{ old('no_hp', $tamu->no_hp) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">Kategori Instansi</label>
                                <select name="kategori_instansi" class="form-select">
                                    @foreach($kategoriList as $kat)
                                        <option value="{{ $kat }}" {{ old('kategori_instansi', $tamu->kategori_instansi) == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-secondary">Jabatan</label>
                                <select name="jabatan" class="form-select">
                                    <option value="">-- Pilih Jabatan --</option>
                                    @foreach($jabatanList as $jab)
                                        <option value="{{ $jab }}" {{ old('jabatan', $tamu->jabatan) == $jab ? 'selected' : '' }}>{{ $jab }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Row 3: Bidang & Keperluan -->
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <label class="form-label small fw-bold text-secondary">Bidang yang Dituju</label>
                                <select name="tujuan_bidang" class="form-select" required>
                                    @foreach($bidangList as $bid)
                                        <option value="{{ $bid }}" {{ old('tujuan_bidang', $tamu->tujuan_bidang) == $bid ? 'selected' : '' }}>{{ $bid }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-secondary">Maksud & Keperluan Kunjungan</label>
                                <textarea name="keperluan" rows="3" class="form-control" required>{{ old('keperluan', $tamu->keperluan) }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-secondary">Catatan / Tindak Lanjut Pelayanan</label>
                                <textarea name="keterangan_tindak_lanjut" rows="3" class="form-control">{{ old('keterangan_tindak_lanjut', $tamu->keterangan_tindak_lanjut) }}</textarea>
                            </div>
                        </div>

                        <!-- Tanda Tangan Preview / Update -->
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-secondary mb-2">Tanda Tangan Pengunjung</label>
                            <div class="d-flex flex-wrap align-items-center gap-4 p-3 bg-light rounded-3 border">
                                @if($tamu->tanda_tangan)
                                    <div>
                                        <div class="small text-muted mb-1">Tanda Tangan Saat Ini:</div>
                                        <div class="bg-white p-2 rounded border d-inline-block">
                                            <img src="{{ $tamu->tanda_tangan }}" alt="TTD" style="max-height: 80px;">
                                        </div>
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <div class="small text-muted mb-1">Perbarui Tanda Tangan (Opsional):</div>
                                    <div class="bg-white rounded border overflow-hidden position-relative" style="height: 120px;">
                                        <canvas id="signatureCanvas" style="width: 100%; height: 100%; cursor: crosshair;"></canvas>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger mt-1 py-0 px-2 small" id="clearPad">
                                        <i class="bi bi-eraser me-1"></i>Bersihkan Kotak TTD
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                            <a href="{{ route('tamu.show', $tamu->id) }}" class="btn btn-light border px-4 py-2 rounded-3">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-5 py-2">
                                <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
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
    const canvas = document.getElementById('signatureCanvas');
    const hiddenInput = document.getElementById('tanda_tangan_input');
    const clearBtn = document.getElementById('clearPad');
    const ctx = canvas.getContext('2d');

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

    canvas.addEventListener('mousedown', startDraw);
    canvas.addEventListener('mousemove', moveDraw);
    canvas.addEventListener('mouseup', endDraw);
    canvas.addEventListener('mouseleave', endDraw);

    canvas.addEventListener('touchstart', startDraw, { passive: false });
    canvas.addEventListener('touchmove', moveDraw, { passive: false });
    canvas.addEventListener('touchend', endDraw);

    clearBtn.addEventListener('click', function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        hasSigned = false;
    });

    document.getElementById('formEdit').addEventListener('submit', function() {
        if (hasSigned) {
            hiddenInput.value = canvas.toDataURL('image/png');
        }
    });

    const btnJamKeluarNow = document.getElementById('btnJamKeluarNow');
    if (btnJamKeluarNow) {
        btnJamKeluarNow.addEventListener('click', function() {
            const now = new Date();
            const hh = String(now.getHours()).padStart(2, '0');
            const mm = String(now.getMinutes()).padStart(2, '0');
            document.getElementById('inputJamKeluar').value = `${hh}:${mm}`;
        });
    }
</script>
@endsection

