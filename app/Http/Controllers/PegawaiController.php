<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $pegawaiList = Pegawai::with('user', 'jabatan');

        //Memfilter agar role HRD tidak bisa melihat data role super admin
        if (session('active_role') === 'hrd') {
            $nipsSuperAdmin = User::role('super admin')->pluck('nip');
            $pegawaiList->whereNotIn('nip_pegawai', $nipsSuperAdmin);
        }

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

        // Fungsi filter status
        if ($request->filled('jabatan')) {
            $jabatan = $request->jabatan;
            if ($jabatan === 'kosong') {
                $pegawaiList->where(function ($filter) {
                    $filter->whereNull('jabatan_id')
                        ->orWhere('jabatan_id', '-');
                });
            } else {
                $pegawaiList->where('jabatan_id', $jabatan);
            }
        }

        // Fungsi filter status
        if ($request->filled('divisi')) {
            $divisis = $request->divisi;
            if ($divisis === 'kosong') {
                $pegawaiList->where(function ($filter) {
                    $filter->whereNull('divisi_id')
                        ->orWhere('divisi_id', '-');
                });
            } else {
                $pegawaiList->where('divisi_id', $divisis);
            }
        }

        // Pagination
        $perPage = $request->input('perPage', 10);
        $pegawais = $pegawaiList
            ->orderByRaw("status = 'aktif' DESC")
            ->orderBy('nama', 'asc')
            ->paginate($perPage)
            ->withQueryString();
        $jabatans = Jabatan::all();
        $divisi = Divisi::all();

        return view('cms.admin.kepegawaian.dataPegawai', compact('pegawais', 'jabatans', 'divisi'));
    }

    public function create()
    {
        $usedNips = Pegawai::pluck('nip_pegawai')->toArray();
        $availableNips = User::whereNotIn('nip', $usedNips)->pluck('nip');
        $jabatans = Jabatan::all();
        $divisi = Divisi::all();

        return view('cms.admin.kepegawaian.aksi.tambahPegawai', compact('availableNips', 'jabatans', 'divisi'));
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
            'jabatan_id' => 'nullable|exists:jabatans,id',
            'divisi_id' => 'nullable|exists:divisi,id',
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
            'jabatan_id' => $request->jabatan_id,
            'divisi_id' => $request->divisi_id,
            'status' => $request->status,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('view-pegawai')->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pegawai = Pegawai::find($id);
        $jabatans = Jabatan::all();
        $divisi = Divisi::all();

        // Cek apakah role aktif adalah HRD dan target pegawai memiliki role super admin
        if (session('active_role') === 'hrd' && $pegawai->user?->hasRole('super admin')) {
            return redirect()->back();
        }

        if (!$pegawai) {
            return redirect()->route('view-pegawai')->with('error_user', 'Data pegawai tidak ditemukan.');
        }

        return view('cms.admin.kepegawaian.aksi.editPegawai', compact('pegawai', 'jabatans', 'divisi'));
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
            'jabatan_id' => 'nullable|exists:jabatans,id',
            'divisi_id' => 'nullable|exists:divisi,id',
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
            'jabatan_id' => $request->jabatan_id,
            'divisi_id' => $request->divisi_id,
            'status' => $request->status,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('view-pegawai')->with('success', 'Data pegawai berhasil diperbarui.');
    }
}
