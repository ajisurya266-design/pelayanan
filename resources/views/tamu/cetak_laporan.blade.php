<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Register Tamu Pelayanan - Dinas Pendidikan Kota Jambi</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
            font-size: 11pt;
            color: #111827;
            background: #f1f5f9;
            padding: 20px;
        }

        .no-print-bar {
            max-width: 1100px;
            margin: 0 auto 20px auto;
            background: #ffffff;
            padding: 12px 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .btn-print {
            background: #1e3a8a;
            color: #ffffff;
            border: none;
            padding: 8px 18px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-print:hover {
            background: #1d4ed8;
        }

        .btn-close-window {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-close-window:hover {
            background: #e2e8f0;
        }

        /* Lembar Kertas Laporan */
        .page {
            max-width: 1100px;
            margin: 0 auto;
            background: #ffffff;
            padding: 30px 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border-radius: 4px;
        }

        /* Kop Surat */
        .kop-surat {
            text-align: center;
            border-bottom: 3px double #111827;
            padding-bottom: 12px;
            margin-bottom: 20px;
            position: relative;
        }

        .kop-surat h4 {
            font-size: 13pt;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: #111827;
            margin-bottom: 2px;
        }

        .kop-surat h2 {
            font-size: 17pt;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .kop-surat p {
            font-size: 9.5pt;
            color: #475569;
            line-height: 1.4;
        }

        /* Judul Laporan */
        .judul-laporan {
            text-align: center;
            margin-bottom: 20px;
        }

        .judul-laporan h3 {
            font-size: 13pt;
            font-weight: 800;
            text-transform: uppercase;
            color: #0f172a;
            letter-spacing: 0.04em;
            margin-bottom: 4px;
        }

        .judul-laporan .badge-periode {
            display: inline-block;
            background: #e0f2fe;
            color: #0369a1;
            font-size: 10pt;
            font-weight: 700;
            padding: 3px 14px;
            border-radius: 20px;
        }

        /* Tabel Data */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
            margin-bottom: 25px;
        }

        table.data-table th,
        table.data-table td {
            border: 1px solid #334155;
            padding: 6px 8px;
            vertical-align: middle;
        }

        table.data-table th {
            background-color: #f1f5f9;
            color: #0f172a;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 8.5pt;
            text-align: center;
        }

        table.data-table tr:nth-child(even) td {
            background-color: #fafbfc;
        }

        .text-center { text-align: center; }
        .text-start  { text-align: left; }
        .text-end    { text-align: right; }
        .fw-bold     { font-weight: 700; }

        .ttd-img {
            max-height: 38px;
            max-width: 75px;
            display: block;
            margin: 0 auto;
        }

        .badge-status {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 7.5pt;
            text-transform: uppercase;
        }
        .badge-selesai { background: #dcfce7; color: #15803d; }
        .badge-sedang_dilayani { background: #e0f2fe; color: #0369a1; }
        .badge-menunggu { background: #fef3c7; color: #b45309; }
        .badge-dibatalkan { background: #fee2e2; color: #b91c1c; }

        /* Area Tanda Tangan Pengesahan */
        .footer-ttd {
            display: flex;
            justify-content: flex-end;
            margin-top: 30px;
            font-size: 10pt;
        }

        .ttd-box {
            text-align: center;
            width: 250px;
        }

        .ttd-space {
            height: 65px;
        }

        /* Print Settings */
        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }
            .no-print-bar {
                display: none !important;
            }
            .page {
                box-shadow: none;
                padding: 0;
                margin: 0;
                max-width: 100%;
            }
            table.data-table th {
                background-color: #e2e8f0 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            @page {
                size: A4 landscape;
                margin: 10mm 10mm;
            }
        }
    </style>
</head>
<body>

    <!-- Tombol Bar (Disembunyikan saat dicetak) -->
    <div class="no-print-bar">
        <div>
            <strong>Laporan Register Buku Tamu Pelayanan</strong>
            <span style="color: #64748b; font-size: 12px; margin-left: 10px;">
                Total: <strong>{{ $dataLaporan->count() }} Tamu</strong>
            </span>
        </div>
        <div style="display: flex; gap: 8px;">
            <button onclick="window.print()" class="btn-print">
                <i class="bi bi-printer-fill"></i> Cetak Dokumen (Print)
            </button>
            <a href="javascript:window.close()" class="btn-close-window">
                Tutup
            </a>
        </div>
    </div>

    <!-- Halaman Kertas Resmi -->
    <div class="page">
        <!-- Kop Surat -->
        <div class="kop-surat">
            <h4>Pemerintah Kota Jambi</h4>
            <h2>Dinas Pendidikan</h2>
            <p>
                Ruang Tamu Pelayanan Terpadu &bull; Jl. H. Zainir Haviz No. 1, Paal Lima, Kota Baru, Kota Jambi 36128<br>
                Laman: disdik.jambikota.go.id &bull; Pos-el: disdik@jambikota.go.id &bull; Kota Jambi
            </p>
        </div>

        <!-- Judul Laporan -->
        <div class="judul-laporan">
            <h3>BUKU REGISTER TAMU RUANG PELAYANAN</h3>
            <span class="badge-periode">Periode: {{ $periodeLabel }}</span>
        </div>

        <!-- Tabel Register -->
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 35px;">No</th>
                    <th style="width: 85px;">Waktu</th>
                    <th style="width: 200px;">Nama Lengkap / Instansi</th>
                    <th style="width: 120px;">Kategori & Jabatan</th>
                    <th style="width: 95px;">No. HP / WA</th>
                    <th style="width: 160px;">Tujuan Bidang / Ruangan</th>
                    <th>Maksud & Keperluan</th>
                    <th style="width: 85px;">Tanda Tangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dataLaporan as $index => $row)
                    <tr>
                        <td class="text-center fw-bold">{{ $row->nomor_urut ?: ($index + 1) }}</td>
                        <td class="text-center">
                            <div>{{ $row->tanggal ? $row->tanggal->format('d/m/Y') : '-' }}</div>
                            <small style="color: #64748b; font-weight: 600;">{{ $row->jam_masuk }} WIB</small>
                        </td>
                        <td>
                            <div class="fw-bold">{{ $row->nama }}</div>
                            @if($row->instansi && $row->instansi !== $row->nama)
                                <div style="color: #475569; font-size: 8pt;">{{ $row->instansi }}</div>
                            @endif
                        </td>
                        <td>
                            <span style="font-weight: 600; color: #1e3a8a;">{{ $row->kategori_instansi }}</span>
                            @if($row->jabatan)
                                <div style="color: #64748b; font-size: 8pt;">{{ $row->jabatan }}</div>
                            @endif
                        </td>
                        <td class="text-center" style="font-family: monospace;">{{ $row->no_hp }}</td>
                        <td>{{ $row->tujuan_bidang }}</td>
                        <td>{{ $row->keperluan }}</td>
                        <td class="text-center">
                            @if($row->tanda_tangan)
                                <img src="{{ $row->tanda_tangan }}" alt="Tanda Tangan" class="ttd-img">
                            @else
                                <span style="color: #cbd5e1; font-size: 8pt;">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center" style="padding: 30px; color: #94a3b8;">
                            <i class="bi bi-inbox" style="font-size: 20pt; display: block; margin-bottom: 6px;"></i>
                            Tidak ada data register tamu pada periode yang dipilih.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Ringkasan Statistik Singkat & Pengesahan -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div style="font-size: 9pt; color: #64748b;">
                <div>Total Tamu Terdata: <strong>{{ $dataLaporan->count() }} orang</strong></div>
                <div>Dicetak pada: {{ now()->translatedFormat('l, d F Y - H:i') }} WIB</div>
            </div>

            <div class="footer-ttd" style="margin-top: 0;">
                <div class="ttd-box">
                    <div>Kota Jambi, {{ now()->translatedFormat('d F Y') }}</div>
                    <div style="font-weight: 600; margin-top: 4px;">Petugas Pelayanan / Admin,</div>
                    <div class="ttd-space"></div>
                    <div style="font-weight: 700; text-decoration: underline;">
                        {{ Auth::user()->name ?? 'Petugas Ruang Pelayanan' }}
                    </div>
                    <div style="color: #64748b; font-size: 8.5pt;">NIP. {{ Auth::user()->nip ?? '------------------------' }}</div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
