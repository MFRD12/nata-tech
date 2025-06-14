<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ProfilePegawaiController;
use App\Http\Controllers\ProfileKeluargaController;

Route::get('/', function () {
    return view('compro.home');
});

Route::get('/about', function () {
    return view('compro.about');
});

Route::get('/product', function () {
    return view('compro.product');
});

Route::get('/insight', function () {
    return view('compro.insight');
});

Route::get('/contact', function () {
    return view('compro.contact');
});



//Route Pilih-role
Route::prefix('role')->middleware('auth')->group(function () {
    Route::get('/pilih', [RoleController::class, 'index'])->name('view-pilih-role');
    Route::post('/set', [RoleController::class, 'setActiveRole'])->name('set-active-role');
    Route::post('/reset', [RoleController::class, 'resetActiveRole'])->name('reset-active-role');
});


// Group Route Admin (Super admin, HRD, Keuangan)
Route::prefix('admin')->middleware(['auth'])->group(function () {

    Route::middleware(['check_active_role:super admin,hrd,keuangan'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    Route::middleware(['check_active_role:super admin'])->group(function () {
        // DATA MASTER
        // Route Jabatan
        Route::get('/kelola-jabatan', [JabatanController::class, 'index'])->name('view-jabatan');
        Route::post('/tambah-jabatan', [JabatanController::class, 'store'])->name('tambah-jabatan');
        Route::post('/update-jabatan/{id}', [JabatanController::class, 'update'])->name('update-jabatan');
        Route::delete('/delete-jabatan/{id}', [JabatanController::class, 'destroy'])->name('hapus-jabatan');

        //Route Divisi
        Route::get('/kelola-divisi', [DivisiController::class, 'index'])->name('view-divisi');
        Route::post('/tambah-divisi', [DivisiController::class, 'store'])->name('tambah-divisi');
        Route::post('/update-divisi/{id}', [DivisiController::class, 'update'])->name('update-divisi');
        Route::delete('/delete-divisi/{id}', [DivisiController::class, 'destroy'])->name('hapus-divisi');

        // PENGATURAN
        // Route Pengaturan Akun
        Route::get('/akun', [AkunController::class, 'index'])->name('view-akun');
        Route::post('/tambah-akun', [AkunController::class, 'store'])->name('tambah-akun');
        Route::post('/update-akun/{id}', [AkunController::class, 'update'])->name('update-akun');
    });

    Route::middleware(['check_active_role:super admin,hrd'])->group(function () {
        // KEPEGAWAIAN
        // Route Data Pegaawai
        Route::get('/pegawai', [PegawaiController::class, 'index'])->name('view-pegawai');
        Route::get('/tambah-pegawai', [PegawaiController::class, 'create'])->name('tambah-view-pegawai');
        Route::post('/tambah-pegawai', [PegawaiController::class, 'store'])->name('tambah-pegawai');
        Route::get('/edit-pegawai/{id}', [PegawaiController::class, 'edit'])->name('edit-view-pegawai');
        Route::post('/update-pegawai/{id}', [PegawaiController::class, 'update'])->name('update-pegawai');

        // Route Data Keluarga
        // Route::get('/keluarga', [KeluargaController::class, 'index'])->name('view-keluarga');
        // Route::get('/detail-Keluarga/{id}', [KeluargaController::class, 'viewDetail'])->name('detail-view-keluarga');
        // Route::get('/tambah-keluarga', [KeluargaController::class, 'create'])->name('tambah-view-keluarga');
        // Route::post('/tambah-keluarga', [KeluargaController::class, 'store'])->name('tambah-keluarga');
        // Route::get('/edit-keluarga/{id}', [KeluargaController::class, 'edit'])->name('edit-view-keluarga');
        // Route::post('/update-keluarga/{id}', [KeluargaController::class, 'update'])->name('update-keluarga');

        // Route Rekap Absensi
        Route::get('/rekap-absensi', [AbsensiController::class, 'rekapIndex'])->name('view-rekap-absensi');
        Route::get('/detail-absensi/{id}', [AbsensiController::class, 'rekapDetail'])->name('view-rekap-detail');
        Route::post('/detail-absensi/{id}', [AbsensiController::class, 'updateAbsensi'])->name('update-rekap-detail');
    });


    Route::middleware(['check_active_role:super admin,keuangan'])->group(function () {
        // KEUANGAN
        // Route Kelola Kategori
        Route::get('/kelola-kategori', [KategoriController::class, 'index'])->name('view-kategori');
        Route::post('/tambah-kategori', [KategoriController::class, 'store'])->name('tambah-kategori');
        Route::post('/update-kategori/{id}', [KategoriController::class, 'update'])->name('update-kategori');
        Route::delete('/delete-kategori/{id}', [KategoriController::class, 'destroy'])->name('hapus-kategori');

        // Route Data Transaksi
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('view-transaksi');
        Route::post('/tambah-transaksi', [TransaksiController::class, 'store'])->name('tambah-transaksi');
        Route::post('/update-transaksi/{id}', [TransaksiController::class, 'update'])->name('update-transaksi');
        Route::delete('/delete-transaksi/{id}', [TransaksiController::class, 'destroy'])->name('hapus-transaksi');

        // Route Laporan Keuangan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('view-laporan');
        Route::get('/laporan-transaksi/export', [LaporanController::class, 'exportExcel'])->name('export-excel');
        Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('export-pdf');
    });
});

// Group Route Pegawai
Route::prefix('pegawai')->middleware(['auth', 'check_active_role:pegawai'])->group(function () {
    //Route Profile Pegawai
    Route::get('/profile', [ProfilePegawaiController::class, 'index'])->name('view-profile');
    Route::post('/profile-tambah', [ProfilePegawaiController::class, 'store'])->name('tambah-profile');
    Route::get('/profile-edit', [ProfilePegawaiController::class, 'edit'])->name('view-edit-profile');
    Route::post('/profile-edit', [ProfilePegawaiController::class, 'update'])->name('update-profile');

    // //Route Profile Keluarga Pegawai
    // Route::get('/profile-keluarga', [ProfileKeluargaController::class, 'index'])->name('view-profile-keluarga');
    // Route::post('/profile-keluarga-tambah', [ProfileKeluargaController::class, 'store'])->name('tambah-profile-keluarga');
    // Route::get('/profile-keluarga-edit', [ProfileKeluargaController::class, 'edit'])->name('view-edit-profile-keluarga');
    // Route::post('/profile-keluarga-edit', [ProfileKeluargaController::class, 'update'])->name('update-profile-keluarga');

    //Route Absen Pegawai
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('view-absen-pegawai');
    Route::get('/riwayat-absensi', [AbsensiController::class, 'riwayat'])->name('view-riwayat-absen');
    Route::post('/absensi/masuk', [AbsensiController::class, 'absenMasuk'])->name('absen-masuk');
    Route::post('/absensi/pulang', [AbsensiController::class, 'absenPulang'])->name('absen-pulang');
});


// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
