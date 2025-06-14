<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilePegawaiController extends Controller
{
    public function index()
    {
        $nip = Auth::user()->nip; // Ambil nip dari user yang login
        $pegawai = Pegawai::where('nip_pegawai', $nip)->first();

        if (!$pegawai) {
            return view('cms.pegawai.aksi.tambahProfile', compact('pegawai'));
        }

        return view('cms.pegawai.profile', compact('pegawai'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'nip_pegawai' => 'required|exists:users,nip|unique:pegawai,nip_pegawai',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'gender' => 'required|in:laki-laki,perempuan',
            'no_hp' => 'required|string|max:13',
            'alamat' => 'required|string|max:500',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('foto_pegawai', 'public');
        }

        // Set default field yang tidak diisi oleh pegawai:
        $validated['status'] = 'aktif';
        $validated['jabatan_id'] = null; 
        $validated['divisi'] = null;
        $validated['tgl_masuk'] = null; // atau sesuaikan defaultnya

        Pegawai::create($validated);

        return redirect()->route('view-profile')->with('success', 'Profile Data pegawai berhasil ditambahkan.');
    }

    public function edit()
    {

        $pegawai = Pegawai::where('nip_pegawai', Auth::user()->nip)->firstOrFail();

        return view('cms.pegawai.aksi.editProfile', compact('pegawai'));
    }

    public function update(Request $request)
    {
        $pegawai = Pegawai::where('nip_pegawai', Auth::user()->nip)->firstOrFail();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'gender' => 'required|in:laki-laki,perempuan',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $fotoPath = $pegawai->foto;
        if ($request->hasFile('foto')) {
            if ($pegawai->foto) {
                Storage::disk('public')->delete($pegawai->foto);
            }
            $fotoPath = $request->file('foto')->store('foto_pegawai', 'public');
            $validated['foto'] = $fotoPath;
        }

        $pegawai->update($validated);

        return redirect()->route('view-profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
