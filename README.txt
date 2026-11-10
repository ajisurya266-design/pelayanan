================================================================================
          SISTEM BUKU TAMU DIGITAL RUANG PELAYANAN
                DINAS PENDIDIKAN KOTA JAMBI
================================================================================

Aplikasi web pencatatan dan manajemen tamu pelayanan digital, dilengkapi
layar kiosk mandiri (self-service), QR code meja resepsionis, tanda tangan digital,
dan dashboard pemantauan antrian tamu secara real-time.

--------------------------------------------------------------------------------
1. URL AKSES APLIKASI
--------------------------------------------------------------------------------
* URL Login Admin / Petugas : http://pelayanan.test/login
                              (atau http://localhost/pelayanan/public/login)
* URL Dashboard Pelayanan   : http://pelayanan.test/dashboard
* URL Layar Kiosk Tamu      : http://pelayanan.test/kiosk
* URL Cetak QR Code Meja    : http://pelayanan.test/kiosk/qr-meja

(Catatan: Jika menjalankan via php artisan serve, gunakan port 8000, 
misalnya: http://127.0.0.1:8000/login)

--------------------------------------------------------------------------------
2. AKUN LOGIN RESMI
--------------------------------------------------------------------------------

[AKUN 1 - ADMINISTRATOR]
* Email       : admin@disdik.jambikota.go.id
* Password    : password
* Role        : admin
* Nama        : Administrator Dinas Pendidikan
* Jabatan     : Admin Sistem & Pelayanan
* Hak Akses   : Akses penuh (Dashboard, Input Tamu, Edit Tamu, Hapus Tamu,
                Cetak Kartu Pengunjung, Manajemen Data & Rekapitulasi).

[AKUN 2 - PETUGAS FRONT OFFICE]
* Email       : pelayanan@disdik.jambikota.go.id
* Password    : password
* Role        : petugas
* Nama        : Petugas Ruang Tamu Pelayanan (Magang)
* Jabatan     : Front Office Ruang Tamu Pelayanan
* Hak Akses   : Dashboard Pelayanan, Register Buku Tamu, Input Tamu Baru,
                Update Status Layanan (Menunggu / Sedang Dilayani / Selesai).

--------------------------------------------------------------------------------
3. FITUR UTAMA SISTEM
--------------------------------------------------------------------------------
1. Layar Kiosk Mandiri (/kiosk):
   - Pengunjung mengisi buku tamu sendiri melalui layar tablet / komputer tamu
     atau scan QR Code dari smartphone masing-masing.
   - Kolom nama dan asal instansi telah digabung menjadi 1 kolom praktis:
     "Nama Lengkap / Instansi" (bebas diisi nama pribadi atau instansi sekolah).
   - Dilengkapi fitur tanda tangan digital langsung pada layar (canvas signature).
   - Cetak nomor antrian dan kode unik kunjungan (contoh: DISDIK-20261109-001).

2. Buku Register Pelayanan Petugas (/tamu):
   - Pencatatan buku manual yang telah didigitalkan secara rapi.
   - Filter cepat berdasarkan: Hari Ini, Bulan Ini, Status Layanan, Bidang Dituju,
     dan Kategori Instansi (SD, SMP, TK/PAUD, dll).
   - Pencarian cepat nama tamu, instansi, atau nomor HP/WhatsApp.
   - Tombol kirim pesan WhatsApp langsung ke pengunjung dengan 1 kali klik.

3. Cetak QR Code Meja Resepsionis (/kiosk/qr-meja):
   - Halaman siap cetak (Print A4) untuk diletakkan di meja front office.
   - Tamu cukup mengarahkan kamera HP ke QR Code untuk mengisi buku tamu mandiri.

4. Kartu Pengunjung & Tanda Tangan (/tamu/{id}):
   - Halaman kartu tanda kunjungan resmi Disdik Kota Jambi yang dapat dicetak.
   - Riwayat jam masuk, jam keluar, dan preview goresan tanda tangan digital tamu.

--------------------------------------------------------------------------------
4. TIPS KEAMANAN & PENGATURAN PASSWORD
--------------------------------------------------------------------------------
Untuk mengganti kata sandi admin / petugas, Anda dapat menjalankannya melalui
terminal Laravel (Artisan Tinker):

1. Buka terminal di folder project (c:\laragon\www\pelayanan)
2. Jalankan perintah:
   php artisan tinker
3. Masukkan kode berikut untuk mengubah password:
   $user = App\Models\User::where('email', 'admin@disdik.jambikota.go.id')->first();
   $user->password = Hash::make('PasswordBaruAnda');
   $user->save();
   exit

================================================================================
Dinas Pendidikan Kota Jambi - Bidang Pelayanan & Pengelolaan Data Pengunjung
================================================================================
