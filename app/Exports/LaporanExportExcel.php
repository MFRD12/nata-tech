<?php
namespace App\Exports;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Database\Eloquent\Builder;

class LaporanExportExcel implements FromView
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function view(): View
    {
        $fakeRequest = new Request($this->filters);

        $transaksis = Transaksi::with('kategori')->filter($fakeRequest)->get();

        $totalPemasukan = $transaksis->where('kategori.jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = $transaksis->where('kategori.jenis', 'pengeluaran')->sum('jumlah');
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        return view('cms.admin.keuangan.exports.laporan_transaksi_excel', [
            'transaksis' => $transaksis,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'saldoAkhir' => $saldoAkhir,
            'filters' => $this->filters,
        ]);
    }
}
