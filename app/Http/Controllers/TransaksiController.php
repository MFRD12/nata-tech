<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $transaksiList = Transaksi::with('kategori')->filter($request);

        // Menampilkan tahun yang tersedia di data
        $tahunList = Transaksi::selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Pagination & Page
        $perPage = $request->input('perPage', 10);
        $transaksis = $transaksiList->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();

        // Menampilkan kategori berdasarkan jenis transaksi yang dipilih
        $jenisList = Kategori::distinct('jenis')->pluck('jenis');
        $kategoriOptions = Kategori::where('jenis', $request->jenis_transaksi)->get();

        $kategoriAll = Kategori::all();

        return view('cms.admin.keuangan.dataTransaksi', compact('transaksis', 'kategoriOptions', 'tahunList', 'jenisList', 'kategoriAll'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'form_context' => 'required|string|in:add_transaksi',
            'tanggal' => 'required|date',
            'nama_transaksi' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'kategori_id' => 'required|exists:kategori,id',
            'nota' => 'nullable|image|max:2048'
        ], [
            'tanggal.required' => 'Tanggal transaksi harus diisi.',
            'nama_transaksi.required' => 'Nama transaksi harus diisi.',
            'jumlah.required' => 'Jumlah transaksi harus diisi.',
        ]);

        $notaPath = null;
        if ($request->hasFile('nota')) {
            $notaPath = $request->file('nota')->store('nota_transaksi', 'public');
        }

        Transaksi::create([
            'tanggal' => $request->tanggal,
            'nama_transaksi' => $request->nama_transaksi,
            'jumlah' => $request->jumlah,
            'kategori_id' => $request->kategori_id,
            'nota' => $notaPath,
        ]);

        return redirect()->route('view-transaksi')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $request->validate([
            'form_context' => 'required|string|in:update_transaksi_' . $id,
            'tanggal' => 'required|date',
            'nama_transaksi' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'kategori_id' => 'required|exists:kategori,id',
            'nota' => 'nullable|image|max:2048'
        ], [
            'tanggal.required' => 'Tanggal transaksi harus diisi.',
            'nama_transaksi.required' => 'Nama transaksi harus diisi.',
            'jumlah.required' => 'Jumlah transaksi harus diisi.',
        ]);

        $notaPath = $transaksi->nota;
        if ($request->hasFile('nota')) {
            if ($transaksi->nota) {
                Storage::disk('public')->delete($transaksi->nota);
            }
            $notaPath = $request->file('nota')->store('nota_transaksi', 'public');
        }

        $transaksi->update([
            'tanggal' => $request->tanggal,
            'nama_transaksi' => $request->nama_transaksi,
            'jumlah' => $request->jumlah,
            'kategori_id' => $request->kategori_id,
            'nota' => $notaPath,
        ]);
        return redirect()->route('view-transaksi', [
            'search' => $request->search,
            'page' => $request->page,
            'jenis_transaksi' => $request->jenis_transaksi,
            'kategori' => $request->kategori,
            'filter_waktu' => $request->filter_waktu,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
            'bulan_awal' => $request->bulan_awal,
            'bulan_akhir' => $request->bulan_akhir,
            'tahun' => $request->tahun,
            'jumlah_min' => $request->jumlah_min,
            'jumlah_max' => $request->jumlah_max,
            'perPage' => $request->perPage,
        ])->with('success', 'Transaksi berhasil diperbarui.');
    }
}
