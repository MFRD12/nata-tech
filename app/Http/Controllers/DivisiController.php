<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class DivisiController extends Controller
{
    public function index()
    {
        $divisi = Divisi::withCount('pegawai')->orderBy('name')->get();
        return view('cms.admin.dataMaster.divisi', compact('divisi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'form_context' => 'required|string|in:add_divisi', // Validasi tambahan untuk form_context
            'name' => 'required|string|max:255|unique:divisi,name',
        ], [
            'name.unique' => 'Nama divisi sudah ada.',
        ]);

        Divisi::create([
            'name' => $request->name,
        ]);

        return redirect()->route('view-divisi')->with('success', 'Divisi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $divisi = Divisi::findOrFail($id);

        $request->validate([
            'form_context' => 'required|string|in:update_divisi_' . $id, 
            'name' => 'required|string|max:255|unique:jabatans,name,' . $id,
        ], [
            'name.unique' => 'Nama divisi sudah ada.',
        ]);

        $divisi->update([
            'name' => $request->name,
        ]);

        // Redirect ke view-jabatan setelah berhasil update
        return redirect()->route('view-divisi')->with('success', 'Divisi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $divisi = Divisi::findOrFail($id);
        Pegawai::where('divisi_id', $divisi->id)->update(['divisi_id' => null]);

        $divisi->delete();

        return redirect()->route('view-divisi')->with('success', 'Divisi berhasil dihapus.');
    }
}
