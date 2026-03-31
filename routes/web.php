<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\AreaParkirController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LogAktivitasController;
use Illuminate\Support\Facades\Route;

// ==========================================
// 1. ROUTE AUTENTIKASI (LOGIN & LOGOUT)
// ==========================================
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ==========================================
// 2. ROUTE KHUSUS ADMIN
// ==========================================
Route::middleware(['auth', 'cekrole:admin'])->group(function () {
    
    // Arahkan ke DashboardController yang baru kita buat
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // CRUD Data Master
    Route::resource('data-user', UserController::class);
    Route::resource('data-tarif', TarifController::class);
    Route::resource('data-area', AreaParkirController::class);
    Route::resource('data-kendaraan', KendaraanController::class);
    Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('log.index');
});


// ==========================================
// 3. ROUTE KHUSUS PETUGAS
// ==========================================
Route::middleware(['auth', 'cekrole:petugas'])->group(function () {
    
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('petugas.dashboard');
    Route::get('/transaksi/index', [TransaksiController::class, 'index'])->name('transaksi.index');
    
    Route::post('/transaksi/masuk', [TransaksiController::class, 'store'])->name('transaksi.masuk');
    
    Route::get('/transaksi/keluar', [TransaksiController::class, 'checkoutIndex'])->name('transaksi.keluar');
    Route::put('/transaksi/keluar/{id}', [TransaksiController::class, 'processCheckout'])->name('transaksi.proses_keluar');
    
    Route::get('/transaksi/cetak/{id}', [TransaksiController::class, 'cetakStruk'])->name('transaksi.cetak');
});


// ==========================================
// 4. ROUTE KHUSUS OWNER
// ==========================================
Route::middleware(['auth', 'cekrole:owner'])->group(function () {
    
    // Jika Owner iseng buka '/owner', otomatis dilempar ke laporan
    Route::get('/owner', function() {
        return redirect()->route('laporan.index');
    });

    Route::get('/laporan', [TransaksiController::class, 'laporan'])->name('laporan.index');
    Route::get('/laporan/cetak', [TransaksiController::class, 'cetakLaporan'])->name('laporan.cetak');
});