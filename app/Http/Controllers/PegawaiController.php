<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $pegawaiList = Pegawai::with('user');

        // Fungsi search
        if ($request->filled('search')) {
            $search = $request->search;
            $pegawaiList->where(function ($cari) use ($search) {
                $cari->where('nip_pegawai', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%");
            });
        }

        // Fungsi filter status
        if ($request->filled('status')) {
            $pegawaiList->where('status', $request->status);
        }

        // Pagination
        $pegawais = $pegawaiList->paginate(10)->withQueryString();

        return view('cms.admin.kepegawaian.dataPegawai', compact('pegawais'));
    }

    public function create()
    {
        $usedNips = Pegawai::pluck('nip_pegawai')->toArray();
        $availableNips = User::whereNotIn('nip', $usedNips)->pluck('nip');

        return view('cms.admin.kepegawaian.aksi.tambahPegawai', compact('availableNips'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nip_pegawai' => 'required|unique:pegawai,nip_pegawai',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string|max:100',
            'tgl_lahir' => 'nullable|date',
            'gender' => 'nullable|in:laki-laki,perempuan',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'tgl_masuk' => 'required|date',
            'jabatan' => 'nullable|string|max:100',
            'divisi' => 'nullable|string|max:100',
            'status' => 'required|in:aktif,tidak aktif',
            'foto' => 'nullable|image|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_pegawai', 'public');
        }

        Pegawai::create([
            'nip_pegawai' => $request->nip_pegawai,
            'nama' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'gender' => $request->gender,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'tgl_masuk' => $request->tgl_masuk,
            'jabatan' => $request->jabatan,
            'divisi' => $request->divisi,
            'status' => $request->status,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('view-pegawai')->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pegawai = Pegawai::find($id);

        if (!$pegawai) {
            return redirect()->route('view-pegawai')->with('error', 'Data pegawai tidak ditemukan.');
        }

        return view('cms.admin.kepegawaian.aksi.editPegawai', compact('pegawai'));
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $request->validate([
            'nip_pegawai' => 'required|unique:pegawai,nip_pegawai,' . $pegawai->id,
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tgl_lahir' => 'required|date',
            'gender' => 'required|in:laki-laki,perempuan',
            'no_hp' => 'nullable|string|max:15',
            'alamat' => 'required|string',
            'tgl_masuk' => 'nullable|date',
            'jabatan' => 'nullable|string|max:100',
            'divisi' => 'nullable|string|max:100',
            'status' => 'required|in:aktif,tidak aktif',
            'foto' => 'nullable|image|max:2048',
        ]);

        $fotoPath = $pegawai->foto;
        if ($request->hasFile('foto')) {
            if ($pegawai->foto) {
                Storage::disk('public')->delete($pegawai->foto);
            }
            $fotoPath = $request->file('foto')->store('foto_pegawai', 'public');
        }

        $pegawai->update([
            'nip_pegawai' => $request->nip_pegawai,
            'nama' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'gender' => $request->gender,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'tgl_masuk' => $request->tgl_masuk,
            'jabatan' => $request->jabatan,
            'divisi' => $request->divisi,
            'status' => $request->status,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('view-pegawai')->with('success', 'Data pegawai berhasil diperbarui.');
    }
}
