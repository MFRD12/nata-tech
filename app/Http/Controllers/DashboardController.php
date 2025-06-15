<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Absensi;
use App\Models\Pegawai;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
        $month = Carbon::now()->month;
        $year_bar = $request->filter_tahun_bar ?? Carbon::now()->year;
        $year_line = $request->filter_tahun_line ?? Carbon::now()->year;

        $transaksiTerbaru = Transaksi::with('kategori')
            ->latest('tanggal')
            ->take(5)
            ->get();

        $statistikPegawai = $this->statistikPegawai();
        $keuanganHariIni = $this->keuanganHariIni($today);
        $statistikAbsensi = $this->statistikAbsensi($month, $year_bar);
        $statistikDivisi = $this->statistikPegawaiDivisi();
        $tahunTersedia = $this->dataTahunTransaksiTersedia();
        $grafikKeuangan = $this->chartTransaksi($year_bar);
        $saldoChart = $this->saldoPerBulan($year_line);

        return view('cms.dashboard', [
            ...$statistikPegawai,
            ...$keuanganHariIni,
            ...$statistikAbsensi,
            ...$statistikDivisi,
            ...$grafikKeuangan,
            ...$saldoChart,
            'year_bar' => $year_bar,
            'year_line' => $year_line,
            'tahunTersedia' => $tahunTersedia,
            'transaksiTerbaru' => $transaksiTerbaru
        ]);
    }

    private function statistikPegawai()
    {
        return [
            'totalPegawai' => Pegawai::count(),
            'pegawaiAktif' => Pegawai::where('status', 'aktif')->count(),
            'pegawaiTidakAktif' => Pegawai::where('status', '!=', 'aktif')->count(),
        ];
    }

    private function keuanganHariIni($today)
    {
        $totalPemasukanHariIni = Transaksi::whereDate('tanggal', $today)
            ->whereHas('kategori', fn($q) => $q->where('jenis', 'pemasukan'))
            ->sum('jumlah');

        $totalPengeluaranHariIni = Transaksi::whereDate('tanggal', $today)
            ->whereHas('kategori', fn($q) => $q->where('jenis', 'pengeluaran'))
            ->sum('jumlah');

        return [
            'totalPemasukanHariIni' => $totalPemasukanHariIni,
            'totalPengeluaranHariIni' => $totalPengeluaranHariIni,
            'saldoHariIni' => $totalPemasukanHariIni - $totalPengeluaranHariIni,
        ];
    }

    private function statistikAbsensi($month, $year)
    {
        $absensi = Absensi::whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get()
            ->groupBy('status')
            ->map(function ($items) {
                return $items->count();
            });

        return [
            'dataAbsensiPie' => $absensi
        ];
    }

    private function statistikPegawaiDivisi()
    {
        $data = Divisi::withCount('pegawai')->get();

        return [
            'divisiLabels' => $data->pluck('name'),
            'divisiCounts' => $data->pluck('pegawai_count'),
        ];
    }

    private function dataTahunTransaksiTersedia()
    {
        return Transaksi::selectRaw('YEAR(tanggal) as tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');
    }

    private function chartTransaksi($year)
    {
        Carbon::setLocale('id');
        $bulanLabels = [];
        $pemasukan = [];
        $pengeluaran = [];

        for ($i = 1; $i <= 12; $i++) {
            $bulanLabels[] = Carbon::createFromDate($year, $i, 1)->translatedFormat('F');

            $pemasukan[] = Transaksi::whereMonth('tanggal', $i)
                ->whereYear('tanggal', $year)
                ->whereHas('kategori', fn($q) => $q->where('jenis', 'pemasukan'))
                ->sum('jumlah');

            $pengeluaran[] = Transaksi::whereMonth('tanggal', $i)
                ->whereYear('tanggal', $year)
                ->whereHas('kategori', fn($q) => $q->where('jenis', 'pengeluaran'))
                ->sum('jumlah');
        }

        return [
            'bulanLabels' => $bulanLabels,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
        ];
    }

    private function saldoPerBulan($year)
    {
        $saldoPerBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $pemasukan = Transaksi::whereYear('tanggal', $year)
                ->whereMonth('tanggal', $i)
                ->whereHas('kategori', fn($q) => $q->where('jenis', 'pemasukan'))
                ->sum('jumlah');

            $pengeluaran = Transaksi::whereYear('tanggal', $year)
                ->whereMonth('tanggal', $i)
                ->whereHas('kategori', fn($q) => $q->where('jenis', 'pengeluaran'))
                ->sum('jumlah');

            $saldoPerBulan[] = $pemasukan - $pengeluaran;
        }

        return [
            'saldoBulanLabels' => collect(range(1, 12))->map(fn($m) => \Carbon\Carbon::create()->month($m)->translatedFormat('F')),
            'saldoBulanValues' => $saldoPerBulan,
        ];
    }

}

