<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tamu_pelayanans', function (Blueprint $table) {
            $table->id();
            $table->integer('nomor_urut')->nullable(); // Nomor urut di buku register
            $table->string('kode_kunjungan', 30)->unique(); // Kode unik seperti DISDIK-20261029-001
            $table->date('tanggal'); // Tanggal kunjungan
            $table->string('hari', 20); // Hari (Senin, Selasa, dll)
            $table->time('jam_masuk'); // Jam masuk
            $table->time('jam_keluar')->nullable(); // Jam keluar/selesai
            
            // Data Tamu
            $table->string('nama'); // Nama Lengkap Tamu
            $table->string('instansi'); // Asal Instansi / Sekolah (contoh: SDN 046, SMPN 15)
            $table->string('kategori_instansi', 50)->default('SD'); // TK/PAUD, SD, SMP, PKBM, SMA/SMK, Dinas/Instansi, Umum
            $table->string('jabatan', 100)->nullable(); // Guru, Kepala Sekolah, Operator Sekolah, TU, dll
            $table->string('no_hp', 30); // Nomor HP / WhatsApp
            
            // Tujuan & Keperluan
            $table->string('tujuan_bidang', 100); // GTK, Pembinaan SD, Pembinaan SMP, PAUD-PNF, Sekretariat Keuangan/Umum, Kadis
            $table->string('pejabat_staf')->nullable(); // Pejabat/Staf yang dituju (misal: Ibu Sarwita, Pak Luthfi)
            $table->text('keperluan'); // Keperluan: SKUMPTK, E-Kin, Surat Cuti, Naik Pangkat, Dapodik, dll
            
            // Verifikasi & Dokumentasi
            $table->longText('tanda_tangan')->nullable(); // Tanda tangan digital base64 canvas
            $table->string('foto')->nullable(); // Foto tamu jika ada
            $table->enum('status', ['menunggu', 'sedang_dilayani', 'selesai', 'dibatalkan'])->default('selesai');
            $table->text('keterangan_tindak_lanjut')->nullable(); // Catatan pelayanan / disposisi
            
            // Meta
            $table->boolean('is_mandiri')->default(false); // Diinput sendiri oleh tamu via Kiosk/HP
            $table->foreignId('petugas_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tamu_pelayanans');
    }
};
