<?php

namespace App\Http\Controllers;

use App\Models\TamuPelayanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;

        // Statistik Utama
        $totalHariIni = TamuPelayanan::whereDate('tanggal', $today)->count();
        $totalBulanIni = TamuPelayanan::whereYear('tanggal', $thisYear)
            ->whereMonth('tanggal', $thisMonth)
            ->count();
        $totalMandiri = TamuPelayanan::where('is_mandiri', true)->count();
        $totalKeseluruhan = TamuPelayanan::count();

        // Tamu Hari Ini (Latest first)
        $tamuHariIni = TamuPelayanan::whereDate('tanggal', $today)
            ->orderBy('id', 'desc')
            ->get();

        // 10 Tamu Terbaru
        $tamuTerbaru = TamuPelayanan::orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->limit(8)
            ->get();

        // Data Grafik: Tren Kunjungan 7 Hari Terakhir
        $chartDates = [];
        $chartCounts = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dateStr = $date->format('Y-m-d');
            $label = $date->translatedFormat('D, d M');
            $chartDates[] = $label;
            $chartCounts[] = TamuPelayanan::whereDate('tanggal', $dateStr)->count();
        }

        // Data Grafik: Distribusi Kategori Instansi (SD, SMP, TK, PKBM, dll)
        $kategoriData = TamuPelayanan::select('kategori_instansi', DB::raw('count(*) as total'))
            ->groupBy('kategori_instansi')
            ->orderByDesc('total')
            ->get();

        // Data Grafik: Distribusi Bidang Tujuan
        $bidangData = TamuPelayanan::select('tujuan_bidang', DB::raw('count(*) as total'))
            ->groupBy('tujuan_bidang')
            ->orderByDesc('total')
            ->get();

        return view('dashboard.index', compact(
            'totalHariIni',
            'totalBulanIni',
            'totalMandiri',
            'totalKeseluruhan',
            'tamuHariIni',
            'tamuTerbaru',
            'chartDates',
            'chartCounts',
            'kategoriData',
            'bidangData'
        ));
    }
}
