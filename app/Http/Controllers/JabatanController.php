<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Validator;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::withCount('pegawai')->orderBy('name')->get();
        return view('cms.admin.dataMaster.jabatan', compact('jabatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'form_context' => 'required|string|in:add_jabatan', // Validasi tambahan untuk form_context
            'name' => 'required|string|max:255|unique:jabatans,name',
        ], [
            'name.unique' => 'Nama jabatan sudah ada.',
        ]);

        Jabatan::create([
            'name' => $request->name,
        ]);

        return redirect()->route('view-jabatan')->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $jabatan = Jabatan::findOrFail($id);

        $request->validate([
            'form_context' => 'required|string|in:update_jabatan_' . $id, 
            'name' => 'required|string|max:255|unique:jabatans,name,' . $id,
        ], [
            'name.unique' => 'Nama jabatan sudah ada.',
        ]);

        $jabatan->update([
            'name' => $request->name,
        ]);

        // Redirect ke view-jabatan setelah berhasil update
        return redirect()->route('view-jabatan')->with('success', 'Jabatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        Pegawai::where('jabatan_id', $jabatan->id)->update(['jabatan_id' => null]);

        $jabatan->delete();

        return redirect()->route('view-jabatan')->with('success', 'Jabatan berhasil dihapus.');
    }
}