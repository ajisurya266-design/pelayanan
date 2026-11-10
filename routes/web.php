<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TamuPelayananController;
use App\Http\Controllers\KioskController;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Pelayanan Ruang Tamu Dinas Pendidikan Kota Jambi
|--------------------------------------------------------------------------
*/

// Halaman Utama: Arahkan ke Dashboard jika login, atau ke Kiosk Tamu jika belum
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('kiosk.index');
});

// Autentikasi Petugas & Admin
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Mode Kiosk & Tamu Mandiri (Bisa diakses publik / scan QR di meja front desk)
Route::prefix('buku-tamu')->name('kiosk.')->group(function () {
    Route::get('/', [KioskController::class, 'index'])->name('index');
    Route::get('/isi', [KioskController::class, 'form'])->name('form');
    Route::post('/isi', [KioskController::class, 'store'])->name('store');
    Route::get('/sukses/{id}', [KioskController::class, 'sukses'])->middleware('signed')->name('sukses');
});
Route::get('/qr-meja-pelayanan', [KioskController::class, 'qrMeja'])->name('kiosk.qr_meja');

// Area Internal Petugas Pelayanan & Admin (Memerlukan Login)
Route::middleware(['auth', 'role:admin,petugas'])->group(function () {
    // Dashboard Statistik
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Buku Tamu Pelayanan
    Route::resource('tamu', TamuPelayananController::class);
    Route::patch('/tamu/{id}/status', [TamuPelayananController::class, 'updateStatus'])->name('tamu.updateStatus');

    // Laporan & Export
    Route::get('/laporan/cetak', [TamuPelayananController::class, 'cetakLaporan'])->name('tamu.cetakLaporan');
    Route::get('/laporan/export-excel', [TamuPelayananController::class, 'exportExcel'])->name('tamu.exportExcel');
});
