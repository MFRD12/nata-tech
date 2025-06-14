<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Transaksi;
use App\Models\Absensi;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {

        $today = Carbon::today();
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $totalPegawai = Pegawai::count();
        $pegawaiAktif = Pegawai::where('status', 'aktif')->count();
        $pegawaiTidakAktif = Pegawai::where('status', '!=', 'aktif')->count();

        $totalPemasukanHariIni = Transaksi::whereDate('tanggal', $today)
            ->whereHas('kategori', function ($query) {
                $query->where('jenis', 'pemasukan');
            })
            ->sum('jumlah');

        $totalPengeluaranHariIni = Transaksi::whereDate('tanggal', $today)
            ->whereHas('kategori', function ($query) {
                $query->where('jenis', 'pengeluaran');
            })
            ->sum('jumlah');

        $saldoHariIni = $totalPemasukanHariIni - $totalPengeluaranHariIni;

        $absenHadir = Absensi::whereMonth('tanggal', $month)->whereYear('tanggal', $year)->where('status', 'hadir')->count();
        $absenIzin = Absensi::whereMonth('tanggal', $month)->whereYear('tanggal', $year)->where('status', 'izin')->count();
        $absenAlpha = Absensi::whereMonth('tanggal', $month)->whereYear('tanggal', $year)->where('status', 'alpha')->count();

        return view('cms.dashboard', compact(
            'totalPegawai',
            'pegawaiAktif',
            'pegawaiTidakAktif',
            'totalPemasukanHariIni',
            'totalPengeluaranHariIni',
            'saldoHariIni',
            'absenHadir',
            'absenIzin',
            'absenAlpha'
        ));
    }
}
