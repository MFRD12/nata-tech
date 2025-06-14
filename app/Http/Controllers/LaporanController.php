<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExportExcel;
use App\Models\Kategori;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $transaksis = collect(); // Kosongkan data default
        $totalPemasukan = 0;
        $totalPengeluaran = 0;

        // Menampilkan tahun yang tersedia di data
        $tahunList = Transaksi::selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Menampilkan kategori berdasarkan jenis transaksi yang dipilih
        $jenisList = Kategori::distinct('jenis')->pluck('jenis');
        $kategoriOptions = Kategori::where('jenis', $request->jenis_transaksi)->get();

        // Cek apakah user sudah mulai melakukan filter
        $sudahFilter = $request->filled('search') ||
            $request->filled('jenis_transaksi') ||
            $request->filled('kategori') ||
            $request->filled('tahun') ||
            $request->filled('tanggal_awal') ||
            $request->filled('tanggal_akhir') ||
            $request->filled('bulan_awal') ||
            $request->filled('bulan_akhir') ||
            $request->filled('jumlah_min') ||
            $request->filled('jumlah_max');

        if ($sudahFilter) {
            $transaksiList = Transaksi::with('kategori')->filter($request)->orderBy('tanggal', 'asc');
            $transaksis = $transaksiList->get();

            // Hitung total pemasukan dan pengeluaran berdasarkan jenis kategori
            foreach ($transaksis as $transaksi) {
                if ($transaksi->kategori->jenis === 'pemasukan') {
                    $totalPemasukan += $transaksi->jumlah;
                } elseif ($transaksi->kategori->jenis === 'pengeluaran') {
                    $totalPengeluaran += $transaksi->jumlah;
                }
            }
        }

        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        return view('cms.admin.keuangan.laporanTransaksi', compact(
            'transaksis',
            'kategoriOptions',
            'tahunList',
            'jenisList',
            'totalPemasukan',
            'totalPengeluaran',
            'saldoAkhir',
            'sudahFilter'
        ));
    }

    public function exportExcel(Request $request)
    {
        $cachePath = storage_path('framework/cache/laravel-excel');
        if (File::exists($cachePath)) {
            File::cleanDirectory($cachePath);
        }

        $filters = $request->only([
            'jenis_transaksi',
            'kategori',
            'tanggal_awal',
            'tanggal_akhir',
            'bulan_awal',
            'bulan_akhir',
            'tahun',
            'jumlah_min',
            'jumlah_max',
            'search'
        ]);

        return Excel::download(new LaporanExportExcel($filters),  'laporan_transaksi_' . time() . '.xlsx');
    }

    public function exportPdf(Request $request)
{
    $filters = $request->only([
        'jenis_transaksi',
        'kategori',
        'tanggal_awal',
        'tanggal_akhir',
        'bulan_awal',
        'bulan_akhir',
        'tahun',
        'jumlah_min',
        'jumlah_max',
        'search'
    ]);

    $transaksis = Transaksi::with('kategori')->filter($request)->get();

    $totalPemasukan = $transaksis->where('kategori.jenis', 'pemasukan')->sum('jumlah');
    $totalPengeluaran = $transaksis->where('kategori.jenis', 'pengeluaran')->sum('jumlah');
    $saldoAkhir = $totalPemasukan - $totalPengeluaran;

    $pdf = Pdf::loadView('cms.admin.keuangan.exports.laporan_transaksi_pdf', [
        'transaksis' => $transaksis,
        'totalPemasukan' => $totalPemasukan,
        'totalPengeluaran' => $totalPengeluaran,
        'saldoAkhir' => $saldoAkhir,
        'filters' => $filters,
    ]);

    return $pdf->download('laporan_transaksi_' . time() . '.pdf');
}
}
