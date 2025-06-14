<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'tanggal',
        'nama_transaksi',
        'jumlah',
        'kategori_id',
        'nota',
    ];

    public function scopeFilter(Builder $transaksiList, Request $request)
    {
        // Pencarian nama transaksi
        if ($request->filled('search')) {
            $transaksiList->where('nama_transaksi', 'like', '%' . $request->search . '%');
        }

        // Filter jenis dan kategori
        if ($request->filled('jenis_transaksi')) {
            // Filter berdasarkan relasi kategori -> jenis
            $transaksiList->whereHas('kategori', function ($q) use ($request) {
                $q->where('jenis', $request->jenis_transaksi);

                // Kalau kategori_id juga diisi, filter juga di sini
                if ($request->filled('kategori')) {
                    $q->where('id', $request->kategori);
                }
            });
        } else if ($request->filled('kategori')) {
            // Kalau hanya kategori_id tanpa jenis
            $transaksiList->where('kategori_id', $request->kategori);
        }
        // Filter waktu
        if ($request->filter_waktu === 'tanggal' && $request->tanggal_awal && $request->tanggal_akhir) {
            $transaksiList->whereBetween('tanggal', [$request->tanggal_awal, $request->tanggal_akhir]);

        } elseif (
            $request->filter_waktu === 'bulan' &&
            $request->bulan_awal && $request->bulan_akhir &&
            $request->tahun
        ) {
            $tanggalAwal = Carbon::create($request->tahun, $request->bulan_awal, 1)->startOfMonth();
            $tanggalAkhir = Carbon::create($request->tahun, $request->bulan_akhir, 1)->endOfMonth();
            $transaksiList->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);

        } elseif ($request->filter_waktu === 'tahun' && $request->tahun) {
            $transaksiList->whereYear('tanggal', $request->tahun);
        }
        // Filter harga
        if ($request->filled('jumlah_min') && $request->filled('jumlah_max')) {
            $transaksiList->whereBetween('jumlah', [$request->jumlah_min, $request->jumlah_max]);
        }
        return $transaksiList;
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
