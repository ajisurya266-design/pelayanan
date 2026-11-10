<?php

namespace App\Http\Controllers;

use App\Models\TamuPelayanan;
use App\Services\SimpleXLSXGen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TamuPelayananController extends Controller
{
    /**
     * Tampilkan data buku tamu pelayanan (Index)
     */
    public function index(Request $request)
    {
        $query = TamuPelayanan::query();

        // Pencarian Teks
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($w) use ($q) {
                $w->where('nama', 'like', "%{$q}%")
                  ->orWhere('instansi', 'like', "%{$q}%")
                  ->orWhere('no_hp', 'like', "%{$q}%")
                  ->orWhere('keperluan', 'like', "%{$q}%")
                  ->orWhere('kode_kunjungan', 'like', "%{$q}%");
            });
        }

        // Filter Rentang Tanggal
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
        } elseif ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        } elseif ($request->filter_periode == 'hari_ini') {
            $query->whereDate('tanggal', Carbon::today());
        } elseif ($request->filter_periode == 'bulan_ini') {
            $query->whereYear('tanggal', Carbon::now()->year)
                  ->whereMonth('tanggal', Carbon::now()->month);
        }

        // Filter Kategori Instansi
        if ($request->filled('kategori_instansi')) {
            $query->where('kategori_instansi', $request->kategori_instansi);
        }

        // Filter Tujuan Bidang
        if ($request->filled('tujuan_bidang')) {
            $query->where('tujuan_bidang', $request->tujuan_bidang);
        }

        // Urutkan berdasarkan tanggal & id terbaru
        $tamuList = $query->orderBy('tanggal', 'desc')
                          ->orderBy('nomor_urut', 'desc')
                          ->orderBy('id', 'desc')
                          ->paginate(15)
                          ->withQueryString();

        // Kategori Instansi & Bidang untuk opsi filter
        $kategoriList = ['SD', 'SMP', 'TK/PAUD', 'PKBM', 'SMA/SMK', 'Kemenag', 'Dinas/Instansi', 'Masyarakat Umum', 'Lainnya'];
        $bidangList = [
            'Bidang Pembinaan Ketenagaan (GTK)',
            'Bidang Pembinaan SD',
            'Bidang Pembinaan SMP',
            'Bidang Pembinaan PAUD & PNF',
            'Sekretariat (Umum & Kepegawaian)',
            'Sekretariat (Keuangan & Aset)',
            'Ruang Kepala Dinas / Sekdis',
            'Layanan Informasi / Ruang Tamu',
        ];

        return view('tamu.index', compact('tamuList', 'kategoriList', 'bidangList'));
    }

    /**
     * Form Tambah Tamu Baru
     */
    public function create()
    {
        $today = Carbon::today();
        $namaHari = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ][$today->format('l')];

        $nextKode = TamuPelayanan::generateKodeKunjungan();
        $nextNomorUrut = TamuPelayanan::getNextNomorUrut();
        $jamSekarang = Carbon::now()->format('H:i');

        $kategoriList = ['SD', 'SMP', 'TK/PAUD', 'PKBM', 'SMA/SMK', 'Kemenag', 'Dinas/Instansi', 'Masyarakat Umum', 'Lainnya'];
        $jabatanList = ['Guru', 'Kepala Sekolah', 'Operator Sekolah (OPS)', 'Bendahara Sekolah', 'Staff Tata Usaha (TU)', 'Wali Murid / Orang Tua', 'Masyarakat Umum', 'Lainnya'];
        $bidangList = [
            'Bidang Pembinaan Ketenagaan (GTK)',
            'Bidang Pembinaan SD',
            'Bidang Pembinaan SMP',
            'Bidang Pembinaan PAUD & PNF',
            'Sekretariat (Umum & Kepegawaian)',
            'Sekretariat (Keuangan & Aset)',
            'Ruang Kepala Dinas / Sekdis',
            'Layanan Informasi / Ruang Tamu',
        ];

        // Keperluan populer yang sering ada di buku manual
        $keperluanChips = [
            'Pengurusan SKUMPTK (Tunjangan Keluarga)',
            'Laporan Bulanan e-Kinerja (e-Kin)',
            'Pengajuan / Pengambilan Surat Cuti',
            'Pemberkasan Kenaikan Pangkat ASN / P3K',
            'Sinkronisasi / Validasi Info GTK',
            'Perbaikan Data Dapodik & Verval PTK',
            'Konsultasi SKP Evaluasi Kinerja',
            'Pengesahan RKAS / Laporan Dana BOS',
            'Pengurusan Mutasi Siswa / Sekolah',
            'Antar Berkas Paruh Waktu / PPPK PW',
            'Antar Bahan Jabatan Fungsional (Jafung)',
            'Konsultasi Kepegawaian & Sertifikasi Guru',
            'Konsultasi SPPD & Administrasi Keuangan',
            'Leges Ijazah SD',
            'Leges Ijazah SMP',
            'Leges Ijazah Paket C',
            'Legalitas Ijazah / Piagam',
        ];

        return view('tamu.create', compact(
            'today',
            'namaHari',
            'nextKode',
            'nextNomorUrut',
            'jamSekarang',
            'kategoriList',
            'jabatanList',
            'bidangList',
            'keperluanChips'
        ));
    }

    /**
     * Simpan Tamu Baru ke Database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'instansi' => ['nullable', 'string', 'max:255'],
            'kategori_instansi' => ['required', 'string', 'max:50', 'in:SD,SMP,TK/PAUD,PKBM,SMA/SMK,Kemenag,Dinas/Instansi,Masyarakat Umum,Lainnya'],
            'jabatan' => ['nullable', 'string', 'max:100'],
            'no_hp' => ['required', 'string', 'max:30'],
            'tujuan_bidang' => ['required', 'string', 'max:100', 'in:Bidang Pembinaan Ketenagaan (GTK),Bidang Pembinaan SD,Bidang Pembinaan SMP,Bidang Pembinaan PAUD & PNF,Sekretariat (Umum & Kepegawaian),Sekretariat (Keuangan & Aset),Ruang Kepala Dinas / Sekdis,Layanan Informasi / Ruang Tamu'],
            'pejabat_staf' => ['nullable', 'string', 'max:255'],
            'keperluan' => ['required', 'string'],
            'tanggal' => ['required', 'date'],
            'jam_masuk' => ['required'],
            'jam_keluar' => ['nullable'],
            'nomor_urut' => ['nullable', 'integer'],
            'keterangan_tindak_lanjut' => ['nullable', 'string'],
            'tanda_tangan' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'max:4096'],
        ], [
            'nama.required' => 'Nama lengkap / instansi wajib diisi.',
            'no_hp.required' => 'Nomor HP/WhatsApp wajib diisi.',
            'tujuan_bidang.required' => 'Bidang yang dituju wajib dipilih.',
            'keperluan.required' => 'Keperluan/maksud kunjungan wajib diisi.',
            'tanggal.required' => 'Tanggal kunjungan wajib diisi.',
            'jam_masuk.required' => 'Jam masuk wajib diisi.',
        ]);

        // Hitung nama hari dari tanggal
        $carbonDate = Carbon::parse($validated['tanggal']);
        $namaHari = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ][$carbonDate->format('l')];

        // Foto tamu jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'tamu_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/foto_tamu', $filename);
            $fotoPath = 'foto_tamu/' . $filename;
        }

        // Tanda tangan dari webcam/snapshot data base64 jika ada
        $tandaTanganData = $request->input('tanda_tangan');

        // Buat record (nomor urut otomatis bertambah +1)
        $kodeKunjungan = TamuPelayanan::generateKodeKunjungan();
        $nomorUrut = TamuPelayanan::getNextNomorUrut();
        $nama = $validated['nama'];
        $instansi = !empty($validated['instansi']) ? $validated['instansi'] : $nama;

        $tamu = TamuPelayanan::create([
            'nomor_urut' => $nomorUrut,
            'kode_kunjungan' => $kodeKunjungan,
            'tanggal' => $validated['tanggal'],
            'hari' => $namaHari,
            'jam_masuk' => $validated['jam_masuk'],
            'jam_keluar' => $validated['jam_keluar'] ?? null,
            'nama' => $nama,
            'instansi' => $instansi,
            'kategori_instansi' => $validated['kategori_instansi'],
            'jabatan' => $validated['jabatan'] ?? null,
            'no_hp' => $validated['no_hp'],
            'tujuan_bidang' => $validated['tujuan_bidang'],
            'pejabat_staf' => $validated['pejabat_staf'] ?? null,
            'keperluan' => $validated['keperluan'],
            'tanda_tangan' => $tandaTanganData,
            'foto' => $fotoPath,
            'status' => 'selesai',
            'keterangan_tindak_lanjut' => $validated['keterangan_tindak_lanjut'] ?? null,
            'is_mandiri' => false,
            'petugas_id' => Auth::id(),
        ]);

        return redirect()->route('tamu.show', $tamu->id)
            ->with('success', "Data tamu {$tamu->nama} ({$tamu->kode_kunjungan}) berhasil dicatat!");
    }

    /**
     * Detail Tamu & Kartu Pengunjung
     */
    public function show($id)
    {
        $tamu = TamuPelayanan::with('petugas')->findOrFail($id);
        return view('tamu.show', compact('tamu'));
    }

    /**
     * Form Edit Tamu
     */
    public function edit($id)
    {
        $tamu = TamuPelayanan::findOrFail($id);
        $kategoriList = ['SD', 'SMP', 'TK/PAUD', 'PKBM', 'SMA/SMK', 'Kemenag', 'Dinas/Instansi', 'Masyarakat Umum', 'Lainnya'];
        $jabatanList = ['Guru', 'Kepala Sekolah', 'Operator Sekolah (OPS)', 'Bendahara Sekolah', 'Staff Tata Usaha (TU)', 'Wali Murid / Orang Tua', 'Masyarakat Umum', 'Lainnya'];
        $bidangList = [
            'Bidang Pembinaan Ketenagaan (GTK)',
            'Bidang Pembinaan SD',
            'Bidang Pembinaan SMP',
            'Bidang Pembinaan PAUD & PNF',
            'Sekretariat (Umum & Kepegawaian)',
            'Sekretariat (Keuangan & Aset)',
            'Ruang Kepala Dinas / Sekdis',
            'Layanan Informasi / Ruang Tamu',
        ];

        return view('tamu.edit', compact('tamu', 'kategoriList', 'jabatanList', 'bidangList'));
    }

    /**
     * Update Data Tamu
     */
    public function update(Request $request, $id)
    {
        $tamu = TamuPelayanan::findOrFail($id);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'instansi' => ['nullable', 'string', 'max:255'],
            'kategori_instansi' => ['required', 'string', 'max:50', 'in:SD,SMP,TK/PAUD,PKBM,SMA/SMK,Kemenag,Dinas/Instansi,Masyarakat Umum,Lainnya'],
            'jabatan' => ['nullable', 'string', 'max:100'],
            'no_hp' => ['required', 'string', 'max:30'],
            'tujuan_bidang' => ['required', 'string', 'max:100', 'in:Bidang Pembinaan Ketenagaan (GTK),Bidang Pembinaan SD,Bidang Pembinaan SMP,Bidang Pembinaan PAUD & PNF,Sekretariat (Umum & Kepegawaian),Sekretariat (Keuangan & Aset),Ruang Kepala Dinas / Sekdis,Layanan Informasi / Ruang Tamu'],
            'pejabat_staf' => ['nullable', 'string', 'max:255'],
            'keperluan' => ['required', 'string'],
            'tanggal' => ['required', 'date'],
            'jam_masuk' => ['required'],
            'jam_keluar' => ['nullable'],
            'nomor_urut' => ['nullable', 'integer'],
            'keterangan_tindak_lanjut' => ['nullable', 'string'],
            'tanda_tangan' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'max:4096'],
        ]);

        $carbonDate = Carbon::parse($validated['tanggal']);
        $namaHari = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ][$carbonDate->format('l')];

        // Handle foto baru jika ada
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'tamu_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/foto_tamu', $filename);
            $validated['foto'] = 'foto_tamu/' . $filename;
        }

        // Tanda tangan
        if ($request->filled('tanda_tangan')) {
            $validated['tanda_tangan'] = $request->tanda_tangan;
        }

        $validated['instansi'] = !empty($validated['instansi']) ? $validated['instansi'] : $validated['nama'];
        $validated['pejabat_staf'] = $validated['pejabat_staf'] ?? null;
        $validated['hari'] = $namaHari;

        $tamu->update($validated);

        return redirect()->route('tamu.show', $tamu->id)
            ->with('success', "Data tamu {$tamu->nama} berhasil diperbarui.");
    }

    /**
     * Hapus Data Tamu
     */
    public function destroy($id)
    {
        $tamu = TamuPelayanan::findOrFail($id);
        $nama = $tamu->nama;
        $tamu->delete();

        return redirect()->route('tamu.index')
            ->with('success', "Data tamu {$nama} berhasil dihapus dari sistem.");
    }

    /**
     * Quick Status Update (Ajax / Quick Action)
     */
    public function updateStatus(Request $request, $id)
    {
        $tamu = TamuPelayanan::findOrFail($id);
        $status = $request->input('status');

        if (!in_array($status, ['menunggu', 'sedang_dilayani', 'selesai', 'dibatalkan'])) {
            return back()->with('error', 'Status tidak valid.');
        }

        $tamu->status = $status;
        if ($status === 'selesai' && empty($tamu->jam_keluar)) {
            $tamu->jam_keluar = Carbon::now()->format('H:i');
        }
        $tamu->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status pelayanan tamu berhasil diperbarui.',
                'status' => $tamu->status,
                'jam_keluar' => $tamu->jam_keluar,
            ]);
        }

        return back()->with('success', "Status pelayanan {$tamu->nama} diubah menjadi " . ucfirst(str_replace('_', ' ', $status)));
    }

    /**
     * Cetak Laporan Register Tamu (Print-friendly format Kop Surat)
     */
    public function cetakLaporan(Request $request)
    {
        $query = TamuPelayanan::query();

        $periodeLabel = "Semua Data";

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
            $periodeLabel = Carbon::parse($request->tanggal_mulai)->translatedFormat('d F Y') . ' s/d ' . Carbon::parse($request->tanggal_selesai)->translatedFormat('d F Y');
        } elseif ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
            $periodeLabel = Carbon::parse($request->tanggal)->translatedFormat('l, d F Y');
        } elseif ($request->filter_periode == 'hari_ini') {
            $query->whereDate('tanggal', Carbon::today());
            $periodeLabel = Carbon::today()->translatedFormat('l, d F Y');
        } elseif ($request->filter_periode == 'bulan_ini') {
            $query->whereYear('tanggal', Carbon::now()->year)
                  ->whereMonth('tanggal', Carbon::now()->month);
            $periodeLabel = Carbon::now()->translatedFormat('F Y');
        }

        if ($request->filled('kategori_instansi')) {
            $query->where('kategori_instansi', $request->kategori_instansi);
        }
        if ($request->filled('tujuan_bidang')) {
            $query->where('tujuan_bidang', $request->tujuan_bidang);
        }

        $dataLaporan = $query->orderBy('tanggal', 'asc')
                             ->orderBy('nomor_urut', 'asc')
                             ->get();

        return view('tamu.cetak_laporan', compact('dataLaporan', 'periodeLabel'));
    }

    /**
     * Export Buku Tamu ke Microsoft Excel (.xlsx) dengan format resmi & rapi
     */
    public function exportExcel(Request $request)
    {
        $query = TamuPelayanan::query();

        $periodeLabel = 'Semua Data';
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
            $periodeLabel = Carbon::parse($request->tanggal_mulai)->translatedFormat('d F Y') . ' s.d. ' . Carbon::parse($request->tanggal_selesai)->translatedFormat('d F Y');
        } elseif ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
            $periodeLabel = Carbon::parse($request->tanggal)->translatedFormat('d F Y');
        } elseif ($request->filled('bulan') && $request->filled('tahun')) {
            $query->whereMonth('tanggal', $request->bulan)->whereYear('tanggal', $request->tahun);
            $periodeLabel = Carbon::createFromDate($request->tahun, $request->bulan, 1)->translatedFormat('F Y');
        }

        if ($request->filled('kategori_instansi')) {
            $query->where('kategori_instansi', $request->kategori_instansi);
        }
        if ($request->filled('tujuan_bidang')) {
            $query->where('tujuan_bidang', $request->tujuan_bidang);
        }

        $data = $query->orderBy('tanggal', 'asc')->orderBy('nomor_urut', 'asc')->get();

        // Susun baris lembar kerja Excel (.xlsx)
        $rows = [
            ['<center><b><style font-size="14" color="#1E3A8A">PEMERINTAH KOTA JAMBI</style></b></center>', '', '', '', '', '', '', '', '', '', ''],
            ['<center><b><style font-size="16" color="#1E3A8A">DINAS PENDIDIKAN</style></b></center>', '', '', '', '', '', '', '', '', '', ''],
            ['<center><b><style font-size="12" color="#0F172A">BUKU REGISTER TAMU RUANG PELAYANAN</style></b></center>', '', '', '', '', '', '', '', '', '', ''],
            ['<center><i><style font-size="10" color="#64748B">Periode: ' . $periodeLabel . ' | Dicetak pada: ' . Carbon::now()->translatedFormat('d F Y, H:i') . ' WIB</style></i></center>', '', '', '', '', '', '', '', '', '', ''],
            ['', '', '', '', '', '', '', '', '', '', ''], // Baris pemisah kosong
            [
                '<center><middle><b><style bgcolor="#2563EB" color="#FFFFFF" border="thin#93C5FD">NO</style></b></middle></center>',
                '<center><middle><b><style bgcolor="#2563EB" color="#FFFFFF" border="thin#93C5FD">KODE REGISTER</style></b></middle></center>',
                '<center><middle><b><style bgcolor="#2563EB" color="#FFFFFF" border="thin#93C5FD">HARI</style></b></middle></center>',
                '<center><middle><b><style bgcolor="#2563EB" color="#FFFFFF" border="thin#93C5FD">TANGGAL</style></b></middle></center>',
                '<center><middle><b><style bgcolor="#2563EB" color="#FFFFFF" border="thin#93C5FD">JAM MASUK</style></b></middle></center>',
                '<center><middle><b><style bgcolor="#2563EB" color="#FFFFFF" border="thin#93C5FD">NAMA LENGKAP / INSTANSI</style></b></middle></center>',
                '<center><middle><b><style bgcolor="#2563EB" color="#FFFFFF" border="thin#93C5FD">KATEGORI INSTANSI</style></b></middle></center>',
                '<center><middle><b><style bgcolor="#2563EB" color="#FFFFFF" border="thin#93C5FD">JABATAN / PERAN</style></b></middle></center>',
                '<center><middle><b><style bgcolor="#2563EB" color="#FFFFFF" border="thin#93C5FD">NO. HP / WHATSAPP</style></b></middle></center>',
                '<center><middle><b><style bgcolor="#2563EB" color="#FFFFFF" border="thin#93C5FD">TUJUAN BIDANG / RUANGAN</style></b></middle></center>',
                '<center><middle><b><style bgcolor="#2563EB" color="#FFFFFF" border="thin#93C5FD">MAKSUD & KEPERLUAN</style></b></middle></center>'
            ]
        ];

        if ($data->isEmpty()) {
            $rows[] = [
                '<center><middle><i><style bgcolor="#F8FAFC" border="thin#CBD5E1" color="#64748B">Tidak ada data buku tamu untuk kriteria/periode ini.</style></i></middle></center>',
                '', '', '', '', '', '', '', '', '', ''
            ];
        } else {
            foreach ($data as $index => $row) {
                $bg = ($index % 2 === 0) ? '#FFFFFF' : '#F8FAFC';
                $border = 'thin#CBD5E1';

                $nomorUrut = $row->nomor_urut ?: ($index + 1);
                $hari = $row->hari ?: ($row->tanggal ? $row->tanggal->locale('id')->isoFormat('dddd') : '-');
                $tanggal = $row->tanggal ? $row->tanggal->format('d/m/Y') : '-';
                $jamMasuk = $row->jam_masuk ? $row->jam_masuk . ' WIB' : '-';
                $nama = htmlspecialchars($row->nama, ENT_QUOTES);
                $kategori = htmlspecialchars($row->kategori_instansi ?: '-', ENT_QUOTES);
                $jabatan = htmlspecialchars($row->jabatan ?: '-', ENT_QUOTES);
                $noHp = $row->no_hp ?: '-';
                $tujuan = htmlspecialchars($row->tujuan_bidang ?: '-', ENT_QUOTES);
                $keperluan = htmlspecialchars($row->keperluan ?: '-', ENT_QUOTES);

                $rows[] = [
                    '<center><middle><style bgcolor="' . $bg . '" border="' . $border . '">' . $nomorUrut . '</style></middle></center>',
                    '<center><middle><style bgcolor="' . $bg . '" border="' . $border . '"><raw>' . $row->kode_kunjungan . '</raw></style></middle></center>',
                    '<center><middle><style bgcolor="' . $bg . '" border="' . $border . '">' . $hari . '</style></middle></center>',
                    '<center><middle><style bgcolor="' . $bg . '" border="' . $border . '"><raw>' . $tanggal . '</raw></style></middle></center>',
                    '<center><middle><style bgcolor="' . $bg . '" border="' . $border . '"><raw>' . $jamMasuk . '</raw></style></middle></center>',
                    '<left><middle><wraptext><style bgcolor="' . $bg . '" border="' . $border . '"><b>' . $nama . '</b></style></wraptext></middle></left>',
                    '<center><middle><style bgcolor="' . $bg . '" border="' . $border . '">' . $kategori . '</style></middle></center>',
                    '<center><middle><style bgcolor="' . $bg . '" border="' . $border . '">' . $jabatan . '</style></middle></center>',
                    '<center><middle><style bgcolor="' . $bg . '" border="' . $border . '"><raw>' . $noHp . '</raw></style></middle></center>',
                    '<left><middle><wraptext><style bgcolor="' . $bg . '" border="' . $border . '">' . $tujuan . '</style></wraptext></middle></left>',
                    '<left><middle><wraptext><style bgcolor="' . $bg . '" border="' . $border . '">' . $keperluan . '</style></wraptext></middle></left>'
                ];
            }
        }

        $xlsx = SimpleXLSXGen::fromArray($rows, 'Buku Register Tamu');

        // Merge Header Kop Surat (A1:K1 s.d. A4:K4)
        $xlsx->mergeCells('A1:K1');
        $xlsx->mergeCells('A2:K2');
        $xlsx->mergeCells('A3:K3');
        $xlsx->mergeCells('A4:K4');

        if ($data->isEmpty()) {
            $xlsx->mergeCells('A7:K7');
        }

        // Tentukan lebar kolom yang proporsional & rapi
        $xlsx->setColWidth(1, 8);   // NO
        $xlsx->setColWidth(2, 24);  // KODE REGISTER
        $xlsx->setColWidth(3, 14);  // HARI
        $xlsx->setColWidth(4, 16);  // TANGGAL
        $xlsx->setColWidth(5, 15);  // JAM MASUK
        $xlsx->setColWidth(6, 35);  // NAMA LENGKAP / INSTANSI
        $xlsx->setColWidth(7, 20);  // KATEGORI INSTANSI
        $xlsx->setColWidth(8, 22);  // JABATAN / PERAN
        $xlsx->setColWidth(9, 20);  // NO. HP / WHATSAPP
        $xlsx->setColWidth(10, 35); // TUJUAN BIDANG / RUANGAN
        $xlsx->setColWidth(11, 45); // MAKSUD & KEPERLUAN

        // Bekukan baris header agar tetap terlihat saat di-scroll ke bawah
        $xlsx->freezePanes('A7');

        $filename = "Buku_Register_Tamu_Disdik_Jambi_" . date('Ymd_His') . ".xlsx";

        return response()->streamDownload(function () use ($xlsx) {
            echo (string) $xlsx;
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0',
        ]);
    }
}
