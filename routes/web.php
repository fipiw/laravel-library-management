<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/buku/{buku}/barcode', [BukuController::class, 'barcode'])->name('buku.barcode');
    Route::resource('buku', BukuController::class)
    ->parameters(['buku' => 'buku']);

    Route::get('/anggota/{anggota}/kartu', [AnggotaController::class, 'cetakKartu'])->name('anggota.kartu');

    Route::resource('anggota', AnggotaController::class)
    ->parameters(['anggota' => 'anggota']);

    Route::post('/peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])
        ->name('peminjaman.kembalikan');
    Route::resource('peminjaman', PeminjamanController::class)
        ->except(['edit', 'update']);

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');
    Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.export-excel');
    Route::get('/laporan/buku/export-excel', [LaporanController::class, 'exportBukuExcel'])->name('laporan.buku.export-excel');
    Route::get('/laporan/anggota/export-excel', [LaporanController::class, 'exportAnggotaExcel'])->name('laporan.anggota.export-excel');
});
