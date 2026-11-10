<?php

namespace App\Http\Controllers;

use App\Models\TamuPelayanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class KioskController extends Controller
{
    /**
     * Tampilan selamat datang Kiosk Ruang Tamu Pelayanan
     */
    public function index()
    {
        $today = Carbon::today();
        $totalHariIni = TamuPelayanan::whereDate('tanggal', $today)->count();
        return view('kiosk.index', compact('totalHariIni'));
    }

    /**
     * Form Input Mandiri Pengunjung
     */
    public function form()
    {
        $kategoriList = ['SD', 'SMP', 'TK/PAUD', 'PKBM', 'Kemenag', 'Dinas/Instansi', 'Masyarakat Umum', 'Lainnya'];
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

        $keperluanChips = [
            'Leges Ijazah SD',
            'Leges Ijazah SMP',
            'Leges Ijazah Paket C',
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
            'Legalitas Ijazah / Piagam',
        ];

        return view('kiosk.form', compact('kategoriList', 'jabatanList', 'bidangList', 'keperluanChips'));
    }

    /**
     * Simpan data tamu mandiri
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'instansi' => ['nullable', 'string', 'max:255'],
            'kategori_instansi' => ['required', 'string', 'max:50', 'in:SD,SMP,TK/PAUD,PKBM,Kemenag,Dinas/Instansi,Masyarakat Umum,Lainnya'],
            'jabatan' => ['nullable', 'string', 'max:100'],
            'no_hp' => ['required', 'string', 'max:30'],
            'tujuan_bidang' => ['required', 'string', 'max:100', 'in:Bidang Pembinaan Ketenagaan (GTK),Bidang Pembinaan SD,Bidang Pembinaan SMP,Bidang Pembinaan PAUD & PNF,Sekretariat (Umum & Kepegawaian),Sekretariat (Keuangan & Aset),Ruang Kepala Dinas / Sekdis,Layanan Informasi / Ruang Tamu'],
            'pejabat_staf' => ['nullable', 'string', 'max:255'],
            'keperluan' => ['required', 'string'],
            'tanda_tangan' => ['nullable', 'string'],
        ], [
            'nama.required' => 'Nama lengkap / instansi wajib diisi.',
            'no_hp.required' => 'Nomor HP/WhatsApp wajib diisi.',
            'tujuan_bidang.required' => 'Bidang yang dituju wajib dipilih.',
            'keperluan.required' => 'Maksud & keperluan kunjungan wajib diisi.',
        ]);

        $today = Carbon::today();
        $namaHari = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ][$today->format('l')];

        $kodeKunjungan = TamuPelayanan::generateKodeKunjungan();
        $nomorUrut = TamuPelayanan::getNextNomorUrut();

        $nama = $validated['nama'];
        $instansi = !empty($validated['instansi']) ? $validated['instansi'] : $nama;

        $tamu = TamuPelayanan::create([
            'nomor_urut' => $nomorUrut,
            'kode_kunjungan' => $kodeKunjungan,
            'tanggal' => $today->format('Y-m-d'),
            'hari' => $namaHari,
            'jam_masuk' => Carbon::now()->format('H:i'),
            'nama' => $nama,
            'instansi' => $instansi,
            'kategori_instansi' => $validated['kategori_instansi'],
            'jabatan' => $validated['jabatan'] ?? null,
            'no_hp' => $validated['no_hp'],
            'tujuan_bidang' => $validated['tujuan_bidang'],
            'pejabat_staf' => $validated['pejabat_staf'] ?? null,
            'keperluan' => $validated['keperluan'],
            'tanda_tangan' => $request->input('tanda_tangan'),
            'status' => 'selesai',
            'is_mandiri' => true,
        ]);

        return redirect()->to(URL::signedRoute('kiosk.sukses', ['id' => $tamu->id]));
    }

    /**
     * Halaman Konfirmasi Sukses Tamu Mandiri
     */
    public function sukses($id)
    {
        $tamu = TamuPelayanan::findOrFail($id);
        return view('kiosk.sukses', compact('tamu'));
    }

    /**
     * Tampilan QR Code untuk dicetak dan ditempel di Meja Resepsionis
     */
    public function qrMeja()
    {
        return view('kiosk.qr_meja');
    }
}
