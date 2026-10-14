<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontDeskController;
use App\Http\Controllers\HousekeepingController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - HotelOps (Sistem Manajemen Operasional Hotel)
|--------------------------------------------------------------------------
*/

// Halaman Awal & Autentikasi
Route::get('/', function () {
    if (auth()->check()) {
        return match (auth()->user()->peran) {
            'Manajer' => redirect()->route('manajer.kamar.index'),
            'Resepsionis' => redirect()->route('resepsionis.dashboard'),
            'Petugas Kebersihan' => redirect()->route('kebersihan.index'),
            default => redirect()->route('login'),
        };
    }
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/demo-login/{peran}', [AuthController::class, 'demoLogin'])->name('demo.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================================
// AREA RESEPSIONIS (Meja Depan & Kasir)
// ==========================================
Route::middleware(['auth', 'role:Resepsionis,Manajer'])->prefix('resepsionis')->name('resepsionis.')->group(function () {
    Route::get('/', [FrontDeskController::class, 'dashboard'])->name('dashboard');
    
    // Kelola Data Tamu
    Route::get('/tamu', [FrontDeskController::class, 'tamuIndex'])->name('tamu.index');
    Route::post('/tamu', [FrontDeskController::class, 'tamuStore'])->name('tamu.store');
    
    // Pemesanan & Reservasi
    Route::get('/pemesanan', [FrontDeskController::class, 'pemesananIndex'])->name('pemesanan.index');
    Route::post('/pemesanan', [FrontDeskController::class, 'pemesananStore'])->name('pemesanan.store');
    Route::post('/pemesanan/{pemesanan}/check-in', [FrontDeskController::class, 'checkIn'])->name('pemesanan.checkin');
    Route::post('/pemesanan/{pemesanan}/check-out', [FrontDeskController::class, 'checkOut'])->name('pemesanan.checkout');
    Route::post('/pemesanan/{pemesanan}/batal', [FrontDeskController::class, 'batalkan'])->name('pemesanan.batal');
    Route::get('/pemesanan/{pemesanan}/invoice', [FrontDeskController::class, 'invoice'])->name('invoice');
});

// ==========================================
// AREA PETUGAS KEBERSIHAN (Housekeeping)
// ==========================================
Route::middleware(['auth', 'role:Petugas Kebersihan,Manajer'])->prefix('kebersihan')->name('kebersihan.')->group(function () {
    Route::get('/', [HousekeepingController::class, 'index'])->name('index');
    Route::post('/{kamar}/bersih', [HousekeepingController::class, 'tandaiBersih'])->name('kamar.bersih');
    Route::post('/{kamar}/kotor', [HousekeepingController::class, 'tandaiKotor'])->name('kamar.kotor');
});

// ==========================================
// AREA MANAJER (Master Data & Laporan)
// ==========================================
Route::middleware(['auth', 'role:Manajer'])->group(function () {
    // Master Kamar
    Route::prefix('manajer')->name('manajer.')->group(function () {
        Route::get('/kamar', [ManagerController::class, 'kamarIndex'])->name('kamar.index');
        Route::post('/kamar', [ManagerController::class, 'kamarStore'])->name('kamar.store');
        Route::put('/kamar/{kamar}', [ManagerController::class, 'kamarUpdate'])->name('kamar.update');
        Route::delete('/kamar/{kamar}', [ManagerController::class, 'kamarDestroy'])->name('kamar.destroy');

        // Master Akun Staf
        Route::get('/users', [ManagerController::class, 'userIndex'])->name('users.index');
        Route::post('/users', [ManagerController::class, 'userStore'])->name('users.store');
        Route::post('/users/{user}/toggle', [ManagerController::class, 'userToggleAktif'])->name('users.toggle');
    });

    // Laporan & Rekapitulasi Eksekutif
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/okupansi', [ReportController::class, 'okupansi'])->name('okupansi');
        Route::get('/pendapatan', [ReportController::class, 'pendapatan'])->name('pendapatan');
        Route::get('/riwayat-tamu', [ReportController::class, 'riwayatTamu'])->name('riwayat_tamu');
    });
});
