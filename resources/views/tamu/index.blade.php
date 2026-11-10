@extends('layouts.app')

@section('title', 'Buku Tamu Register Pelayanan')
@section('page_title', 'Buku Tamu Register Pelayanan')

@section('content')
<div class="container-fluid p-0">
    <!-- Header Action Bar -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">
                <i class="bi bi-journal-bookmark-fill text-primary me-2"></i>Buku Register Tamu Pelayanan
            </h4>
            <p class="text-muted small mb-0">Pengganti buku manual ruang tamu pelayanan Dinas Pendidikan Kota Jambi secara digital & terstruktur.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('tamu.create') }}" class="btn btn-disdik d-inline-flex align-items-center gap-2">
                <i class="bi bi-person-plus-fill"></i>
                <span>Input Tamu Baru</span>
            </a>
            <a href="{{ route('tamu.cetakLaporan', request()->query()) }}" target="_blank" class="btn btn-outline-primary d-inline-flex align-items-center gap-2 bg-white">
                <i class="bi bi-printer-fill"></i>
                <span>Cetak Register</span>
            </a>
            <a href="{{ route('tamu.exportExcel', request()->query()) }}" class="btn btn-outline-success d-inline-flex align-items-center gap-2 bg-white">
                <i class="bi bi-file-earmark-spreadsheet-fill"></i>
                <span>Export Excel</span>
            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3 p-md-4">
            <form action="{{ route('tamu.index') }}" method="GET" class="row g-2 align-items-end">
                <!-- Search Keyword -->
                <div class="col-lg-3 col-md-6">
                    <label class="form-label small fw-bold text-secondary mb-1">Cari Tamu / Instansi / Keperluan</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control border-start-0" placeholder="Ketik nama, instansi, keperluan...">
                    </div>
                </div>

                <!-- Tanggal Mulai -->
                <div class="col-lg-2 col-md-3 col-6">
                    <label class="form-label small fw-bold text-secondary mb-1">Dari Tanggal</label>
                    <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="form-control">
                </div>

                <!-- Tanggal Selesai -->
                <div class="col-lg-2 col-md-3 col-6">
                    <label class="form-label small fw-bold text-secondary mb-1">Sampai Tanggal</label>
                    <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="form-control">
                </div>

                <!-- Kategori Instansi -->
                <div class="col-lg-2 col-md-4 col-6">
                    <label class="form-label small fw-bold text-secondary mb-1">Jenjang / Kategori</label>
                    <select name="kategori_instansi" class="form-select">
                        <option value="">Semua Jenjang</option>
                        @foreach($kategoriList as $kat)
                            <option value="{{ $kat }}" {{ request('kategori_instansi') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tujuan Bidang -->
                <div class="col-lg-2 col-md-4 col-6">
                    <label class="form-label small fw-bold text-secondary mb-1">Bidang Dituju</label>
                    <select name="tujuan_bidang" class="form-select">
                        <option value="">Semua Bidang</option>
                        @foreach($bidangList as $bid)
                            <option value="{{ $bid }}" {{ request('tujuan_bidang') == $bid ? 'selected' : '' }}>{{ $bid }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Actions -->
                <div class="col-lg-1 col-md-4 d-flex gap-1">
                    <button type="submit" class="btn btn-primary w-100" title="Terapkan Filter">
                        <i class="bi bi-funnel-fill"></i>
                    </button>
                    @if(request()->anyFilled(['q', 'tanggal_mulai', 'tanggal_selesai', 'kategori_instansi', 'tujuan_bidang', 'status', 'filter_periode']))
                        <a href="{{ route('tamu.index') }}" class="btn btn-light border" title="Reset Filter">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    @endif
                </div>
            </form>

            <!-- Quick Filter Badges -->
            <div class="d-flex flex-wrap gap-2 mt-3 pt-3 border-top align-items-center">
                <span class="small text-muted fw-semibold">Filter Cepat:</span>
                <a href="{{ route('tamu.index', ['filter_periode' => 'hari_ini']) }}" class="badge {{ request('filter_periode') == 'hari_ini' ? 'bg-primary text-white' : 'bg-light text-dark border' }} text-decoration-none py-2 px-3 rounded-pill">
                    <i class="bi bi-clock me-1"></i>Hari Ini
                </a>
                <a href="{{ route('tamu.index', ['filter_periode' => 'bulan_ini']) }}" class="badge {{ request('filter_periode') == 'bulan_ini' ? 'bg-primary text-white' : 'bg-light text-dark border' }} text-decoration-none py-2 px-3 rounded-pill">
                    <i class="bi bi-calendar-month me-1"></i>Bulan Ini
                </a>
            </div>
        </div>
    </div>

    <!-- Master Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary small">
                    <tr>
                        <th class="ps-3 py-3" style="width: 60px;">NO</th>
                        <th style="min-width: 130px;">HARI / TGL</th>
                        <th style="min-width: 220px;">NAMA LENGKAP / INSTANSI</th>
                        <th style="min-width: 140px;">NO. HP / WA</th>
                        <th style="min-width: 260px;">TUJUAN & KEPERLUAN</th>
                        <th class="text-center" style="width: 110px;">PARAF / TTD</th>
                        <th class="text-center pe-3" style="width: 130px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tamuList as $tamu)
                        <tr>
                            <!-- Nomor Urut -->
                            <td class="ps-3 fw-bold text-secondary">
                                <span class="badge bg-light text-dark border">
                                    {{ $tamu->nomor_urut ?: $loop->iteration }}
                                </span>
                            </td>

                            <!-- Hari / Tanggal -->
                            <td>
                                <div class="fw-bold text-dark">{{ $tamu->hari }}</div>
                                <div class="text-muted small">
                                    {{ $tamu->tanggal ? $tamu->tanggal->format('d/m/Y') : '-' }}
                                </div>
                                <small class="text-secondary" style="font-size: 0.72rem;">
                                    <i class="bi bi-clock me-1"></i>{{ $tamu->jam_masuk }} {{ $tamu->jam_keluar ? '- ' . $tamu->jam_keluar : '' }}
                                </small>
                            </td>

                            <!-- Nama Lengkap / Instansi & Kategori -->
                            <td>
                                <div class="fw-bold text-dark">{{ $tamu->nama }}</div>
                                <div class="d-flex align-items-center gap-1 mt-1">
                                    <span class="badge bg-primary-subtle text-primary border" style="font-size: 0.7rem;">
                                        {{ $tamu->kategori_instansi }}
                                    </span>
                                    @if($tamu->jabatan)
                                        <span class="text-muted small">({{ $tamu->jabatan }})</span>
                                    @endif
                                    @if($tamu->is_mandiri)
                                        <span class="badge bg-info-subtle text-info border px-1" style="font-size: 0.65rem;">
                                            <i class="bi bi-qr-code me-1"></i>Mandiri
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- No HP -->
                            <td>
                                <a href="{{ $tamu->whatsapp_link }}" target="_blank" class="btn btn-sm btn-light border text-success rounded-pill px-2 py-1 small" title="Kirim Pesan WhatsApp">
                                    <i class="bi bi-whatsapp me-1"></i>{{ $tamu->no_hp }}
                                </a>
                            </td>

                            <!-- Keperluan & Bidang -->
                            <td>
                                <div class="small fw-bold text-primary mb-1">
                                    <i class="bi bi-geo-alt-fill me-1"></i>{{ $tamu->tujuan_bidang }}
                                </div>
                                <div class="text-secondary small">{{ $tamu->keperluan }}</div>
                            </td>

                            <!-- Tanda Tangan -->
                            <td class="text-center">
                                @if($tamu->tanda_tangan)
                                    <button type="button" class="btn btn-sm btn-light border p-1 rounded-2 shadow-sm" onclick="previewTtd('{{ $tamu->tanda_tangan }}', '{{ $tamu->nama }}')" title="Lihat Tanda Tangan">
                                        <img src="{{ $tamu->tanda_tangan }}" alt="TTD" style="height: 32px; max-width: 65px; object-fit: contain;">
                                    </button>
                                @else
                                    <span class="badge bg-light text-muted border" style="font-size: 0.7rem;">
                                        <i class="bi bi-pen"></i> Belum ada
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="text-center pe-3">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('tamu.show', $tamu->id) }}" class="btn btn-light border" title="Lihat Detail & Kartu Tamu">
                                        <i class="bi bi-eye text-primary"></i>
                                    </a>
                                    <a href="{{ route('tamu.edit', $tamu->id) }}" class="btn btn-light border" title="Edit Data">
                                        <i class="bi bi-pencil text-warning"></i>
                                    </a>
                                    <button type="button" class="btn btn-light border text-danger" title="Hapus Data" onclick="confirmDelete({{ $tamu->id }}, '{{ $tamu->nama }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                                <form id="delete-form-{{ $tamu->id }}" action="{{ route('tamu.destroy', $tamu->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                Tidak ada data tamu yang cocok dengan kriteria pencarian / filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($tamuList->hasPages())
            <div class="card-footer bg-white d-flex align-items-center justify-content-between py-3">
                <div class="text-muted small">
                    Menampilkan <strong>{{ $tamuList->firstItem() ?? 0 }}</strong> s/d <strong>{{ $tamuList->lastItem() ?? 0 }}</strong> dari total <strong>{{ $tamuList->total() }}</strong> data tamu
                </div>
                <div>
                    {{ $tamuList->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal Preview Tanda Tangan -->
<div class="modal fade" id="modalTtd" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom py-3">
                <h6 class="modal-title fw-bold" id="modalTtdTitle">Tanda Tangan Pengunjung</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-4 bg-light">
                <div class="bg-white p-3 rounded-3 border shadow-sm d-inline-block">
                    <img id="modalTtdImg" src="" alt="Tanda Tangan" style="max-height: 200px; max-width: 100%;">
                </div>
            </div>
            <div class="modal-footer border-0 py-2">
                <button type="button" class="btn btn-secondary btn-sm rounded-pill px-3" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewTtd(src, nama) {
        document.getElementById('modalTtdTitle').innerText = 'Tanda Tangan: ' + nama;
        document.getElementById('modalTtdImg').src = src;
        const modal = new bootstrap.Modal(document.getElementById('modalTtd'));
        modal.show();
    }

    function confirmDelete(id, nama) {
        Swal.fire({
            title: 'Hapus data tamu ini?',
            text: `Data tamu atas nama "${nama}" akan dihapus permanen dari register.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus Data!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection

