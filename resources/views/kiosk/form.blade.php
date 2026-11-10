@extends('layouts.kiosk')

@section('title', 'Isi Buku Tamu')

@section('styles')
<style>
    .form-section-title {
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #94a3b8;
        padding: 0.5rem 0 0.25rem;
    }

    .form-floating label {
        color: #94a3b8;
        font-size: 0.9rem;
    }

    .form-control, .form-select {
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        background: #f8fafc;
        font-size: 0.95rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        background: white;
    }

    .step-badge {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1e3a8a, #2563eb);
        color: white;
        font-size: 0.75rem;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .canvas-wrap {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        overflow: hidden;
        background: #f8fafc;
        cursor: crosshair;
    }

    #signature-pad {
        display: block;
        width: 100%;
        height: 160px;
        touch-action: none;
    }

    .is-invalid ~ .invalid-feedback {
        display: block;
    }
</style>
@endsection

@section('content')
<div class="container py-3" style="max-width: 720px;">

    {{-- Page Header --}}
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('kiosk.index') }}" class="btn btn-light border rounded-circle p-2" style="width:40px;height:40px;display:grid;place-items:center;">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h4 class="fw-bold mb-0">Formulir Buku Tamu</h4>
            <p class="text-muted small mb-0">Isi data kunjungan Anda dengan lengkap</p>
        </div>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
    <div class="alert alert-danger rounded-3 mb-4">
        <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Mohon periksa kembali isian Anda:</div>
        <ul class="mb-0 small ps-3">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('kiosk.store') }}" id="form-tamu">
        @csrf

        {{-- Section 1: Data Pribadi --}}
        <div class="card-kiosk p-4 mb-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <span class="step-badge">1</span>
                <div class="form-section-title mb-0">Data Diri Pengunjung</div>
            </div>

            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-semibold small text-dark">Nama Lengkap / Instansi <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                        placeholder="Contoh: Budi Santoso / SDN 40 Kota Jambi"
                        value="{{ old('nama') }}" required>
                    <div class="form-text small text-muted">Bisa diisi nama lengkap Anda atau nama instansi/sekolah yang diwakili.</div>
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold small text-dark">Kategori Instansi <span class="text-danger">*</span></label>
                    <select name="kategori_instansi" class="form-select @error('kategori_instansi') is-invalid @enderror" required>
                        <option value="">-- Pilih kategori --</option>
                        @foreach($kategoriList as $kat)
                            <option value="{{ $kat }}" {{ old('kategori_instansi') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                    </select>
                    @error('kategori_instansi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold small text-dark">Jabatan / Peran</label>
                    <select name="jabatan" class="form-select @error('jabatan') is-invalid @enderror">
                        <option value="">-- Pilih jabatan (opsional) --</option>
                        @foreach($jabatanList as $jab)
                            <option value="{{ $jab }}" {{ old('jabatan') == $jab ? 'selected' : '' }}>{{ $jab }}</option>
                        @endforeach
                    </select>
                    @error('jabatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold small text-dark">No. HP / WhatsApp <span class="text-danger">*</span></label>
                    <input type="tel" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
                        placeholder="Contoh: 0812-3456-7890"
                        value="{{ old('no_hp') }}" required>
                    @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        {{-- Section 2: Tujuan & Keperluan --}}
        <div class="card-kiosk p-4 mb-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <span class="step-badge">2</span>
                <div class="form-section-title mb-0">Tujuan & Keperluan Kunjungan</div>
            </div>

            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-semibold small text-dark">Tujuan Bidang / Ruangan <span class="text-danger">*</span></label>
                    <select name="tujuan_bidang" class="form-select @error('tujuan_bidang') is-invalid @enderror" required>
                        <option value="">-- Pilih bidang yang dituju --</option>
                        @foreach($bidangList as $bid)
                            <option value="{{ $bid }}" {{ old('tujuan_bidang') == $bid ? 'selected' : '' }}>{{ $bid }}</option>
                        @endforeach
                    </select>
                    @error('tujuan_bidang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold small text-dark">Maksud & Keperluan <span class="text-danger">*</span></label>
                    <textarea name="keperluan" id="keperluan-input" class="form-control @error('keperluan') is-invalid @enderror"
                        rows="3" placeholder="Contoh: Mengambil surat keterangan mengajar, konsultasi data GTK, pengajuan surat cuti, dll." required>{{ old('keperluan') }}</textarea>
                    @error('keperluan') <div class="invalid-feedback">{{ $message }}</div> @enderror

                    @if(isset($keperluanChips) && count($keperluanChips) > 0)
                        <div class="mt-2">
                            <div class="small fw-semibold text-muted mb-2">
                                <i class="bi bi-lightning-charge-fill text-warning me-1"></i>Pilihan Cepat Keperluan:
                            </div>
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($keperluanChips as $chip)
                                    <button type="button" class="btn btn-sm btn-light border rounded-pill py-1 px-2 small text-secondary" onclick="addKeperluanKiosk('{{ $chip }}')">
                                        + {{ $chip }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Section 3: Tanda Tangan --}}
        <div class="card-kiosk p-4 mb-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                <span class="step-badge">3</span>
                <div class="form-section-title mb-0">Tanda Tangan Digital (Opsional)</div>
            </div>

            <div class="canvas-wrap mb-2">
                <canvas id="signature-pad"></canvas>
            </div>
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" id="btn-clear-sign">
                    <i class="bi bi-eraser me-1"></i>Hapus Tanda Tangan
                </button>
            </div>
            <input type="hidden" name="tanda_tangan" id="tanda_tangan_input">
        </div>

        {{-- Submit --}}
        <div class="text-center pb-4">
            <button type="submit" class="btn btn-kiosk-primary px-5 py-3 fs-5" id="btn-submit">
                <i class="bi bi-send-fill me-2"></i>Kirim & Daftarkan Kunjungan
            </button>
            <p class="text-muted small mt-3">
                <i class="bi bi-lock-fill me-1 text-success"></i>
                Data Anda disimpan dengan aman dan hanya untuk keperluan pelayanan.
            </p>
        </div>

    </form>
</div>
@endsection

@section('scripts')
<script>
// === Signature Pad ===
const canvas = document.getElementById('signature-pad');
const ctx = canvas.getContext('2d');

function resizeCanvas() {
    const ratio = Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    ctx.scale(ratio, ratio);
}
resizeCanvas();

let drawing = false;
let lastX = 0, lastY = 0;

function getPos(e) {
    const rect = canvas.getBoundingClientRect();
    const src = e.touches ? e.touches[0] : e;
    return {
        x: (src.clientX - rect.left) * (canvas.offsetWidth / rect.width),
        y: (src.clientY - rect.top) * (canvas.offsetHeight / rect.height)
    };
}

canvas.addEventListener('mousedown', e => { drawing = true; const p = getPos(e); lastX = p.x; lastY = p.y; });
canvas.addEventListener('touchstart', e => { e.preventDefault(); drawing = true; const p = getPos(e); lastX = p.x; lastY = p.y; }, { passive: false });

canvas.addEventListener('mousemove', e => {
    if (!drawing) return;
    const p = getPos(e);
    ctx.beginPath();
    ctx.moveTo(lastX, lastY);
    ctx.lineTo(p.x, p.y);
    ctx.strokeStyle = '#0f172a';
    ctx.lineWidth = 2;
    ctx.lineCap = 'round';
    ctx.lineJoin = 'round';
    ctx.stroke();
    lastX = p.x; lastY = p.y;
});

canvas.addEventListener('touchmove', e => {
    e.preventDefault();
    if (!drawing) return;
    const p = getPos(e);
    ctx.beginPath();
    ctx.moveTo(lastX, lastY);
    ctx.lineTo(p.x, p.y);
    ctx.strokeStyle = '#0f172a';
    ctx.lineWidth = 2;
    ctx.lineCap = 'round';
    ctx.lineJoin = 'round';
    ctx.stroke();
    lastX = p.x; lastY = p.y;
}, { passive: false });

canvas.addEventListener('mouseup', () => drawing = false);
canvas.addEventListener('touchend', () => drawing = false);
canvas.addEventListener('mouseleave', () => drawing = false);

document.getElementById('btn-clear-sign').addEventListener('click', () => {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    document.getElementById('tanda_tangan_input').value = '';
});

// Save signature before submit
document.getElementById('form-tamu').addEventListener('submit', function(e) {
    const dataUrl = canvas.toDataURL('image/png');
    // Only save if canvas has actual drawing (not blank)
    const blank = document.createElement('canvas');
    blank.width = canvas.width; blank.height = canvas.height;
    if (dataUrl !== blank.toDataURL('image/png')) {
        document.getElementById('tanda_tangan_input').value = dataUrl;
    }
});

function addKeperluanKiosk(text) {
    const input = document.getElementById('keperluan-input');
    if (!input) return;
    if (input.value.trim() === '') {
        input.value = text;
    } else {
        input.value += ', ' + text;
    }
    input.focus();
}
</script>
@endsection

