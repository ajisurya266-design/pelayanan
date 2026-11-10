<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TamuPelayanan extends Model
{
    use HasFactory;

    protected $table = 'tamu_pelayanans';

    protected $fillable = [
        'nomor_urut',
        'kode_kunjungan',
        'tanggal',
        'hari',
        'jam_masuk',
        'jam_keluar',
        'nama',
        'instansi',
        'kategori_instansi',
        'jabatan',
        'no_hp',
        'tujuan_bidang',
        'pejabat_staf',
        'keperluan',
        'tanda_tangan',
        'foto',
        'status',
        'keterangan_tindak_lanjut',
        'is_mandiri',
        'petugas_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_mandiri' => 'boolean',
    ];

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    /**
     * Scope query untuk hari ini
     */
    public function scopeHariIni($query)
    {
        return $query->whereDate('tanggal', Carbon::today());
    }

    /**
     * Scope query untuk bulan ini
     */
    public function scopeBulanIni($query)
    {
        return $query->whereYear('tanggal', Carbon::now()->year)
                     ->whereMonth('tanggal', Carbon::now()->month);
    }

    /**
     * Generate Kode Kunjungan Otomatis
     */
    public static function generateKodeKunjungan(): string
    {
        $todayStr = date('Ymd');
        $prefix = "DISDIK-" . $todayStr . "-";
        
        $lastRecord = self::where('kode_kunjungan', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->kode_kunjungan, -3));
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        return $prefix . $newNumber;
    }

    /**
     * Generate Nomor Urut Berikutnya
     */
    public static function getNextNomorUrut(): int
    {
        $max = self::max('nomor_urut');
        return $max ? $max + 1 : 1;
    }

    /**
     * Format no hp ke format standar WA jika diperlukan
     */
    public function getWhatsappLinkAttribute(): string
    {
        $cleanPhone = preg_replace('/[^0-9]/', '', $this->no_hp);
        if (str_starts_with($cleanPhone, '0')) {
            $cleanPhone = '62' . substr($cleanPhone, 1);
        }
        return "https://wa.me/{$cleanPhone}";
    }
}
