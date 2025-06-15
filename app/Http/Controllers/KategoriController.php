<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $kategoriList = Kategori::query();

        if (request()->filled('search')) {
            $search = request()->search;
            $kategoriList->where('name', 'like', "%{$search}%");
        }

        if (request()->filled('filter_jenis')) {
            $kategoriList->where('jenis', request()->filter_jenis);
        }

        $kategoris = $kategoriList->orderBy('jenis', 'asc')->orderBy('name', 'asc')->get();

        return view('cms.admin.keuangan.kategori', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'form_context' => 'required|string|in:add_kategori',
            'name' => 'required|string|max:255|unique:kategori,name',
            'jenis' => 'required|string|in:pengeluaran,pemasukan',
        ], [
            'name.unique' => 'Nama kategori sudah ada.',
            'jenis.required' => 'Jenis kategori harus diisi.',
        ]);

        Kategori::create([
            'name' => $request->name,
            'jenis' => $request->jenis,
        ]);

        return redirect()->route('view-kategori', [
            'search' => $request->search,
            'filter_jenis' => $request->filter_jenis,
        ])->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        $request->validate([
            'form_context' => 'required|string|in:update_kategori_' . $id,
            'name' => 'required|string|max:255|unique:kategori,name,' . $id,
            'jenis' => 'required|string|in:pengeluaran,pemasukan',
        ], [
            'name.unique' => 'Nama kategori sudah ada.',
            'jenis.required' => 'Jenis kategori harus diisi.',
        ]);

        $kategori->update([
            'name' => $request->name,
            'jenis' => $request->jenis,
        ]);

        return redirect()->route('view-kategori', [
            'search' => $request->search,
            'filter_jenis' => $request->filter_jenis,
        ])->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        // Cek apakah kategori masih digunakan
        $jumlahTransaksi = Transaksi::where('kategori_id', $kategori->id)->count();

        if ($jumlahTransaksi > 0) {
            return redirect()->route('view-kategori')->with('error_hapus', 'Kategori tidak dapat dihapus karena masih digunakan pada data transaksi.');
        }

        $kategori->delete();

        return redirect()->route('view-kategori')->with('success', 'Kategori berhasil dihapus.');
    }
}
