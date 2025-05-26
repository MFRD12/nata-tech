<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('cms.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/pegawai', function () {
    return view('cms.pegawai.pegawai');
})->name('pegawai');

Route::get('/kategori', function () {
    return view('cms.admin.keuangan.kategori');
})->middleware(['auth', 'verified'])->name('kategori');

Route::get('/pegawai', [PegawaiController::class, 'index'])->name('view-pegawai');
Route::get('/tambah-pegawai', [PegawaiController::class, 'create'])->name('tambah-view-pegawai');
Route::post('/tambah-pegawai', [PegawaiController::class, 'store'])->name('tambah-pegawai');
Route::get('/edit-pegawai/{nip_pegawai}', [PegawaiController::class, 'edit'])->name('edit-view-pegawai');
Route::post('/edit-pegawai/{nip_pegawai}', [PegawaiController::class, 'update'])->name('update-pegawai');


Route::get('/akun', [AkunController::class, 'index'])->name('view-akun');
Route::post('/tambah-akun', [AkunController::class, 'store'])->name('tambah-akun');
Route::post('/edit-akun/{id}', [AkunController::class, 'update'])->name('update-akun');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
