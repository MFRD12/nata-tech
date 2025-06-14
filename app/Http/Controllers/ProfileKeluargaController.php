<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\Pegawai;
use App\Models\Keluarga;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProfileKeluargaController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cari pegawai berdasarkan NIP dari user
        $pegawai = Pegawai::where('nip_pegawai', $user->nip)->first();

        // Jika belum memiliki data pegawai, kembalikan ke halaman sebelumnya
        if (!$pegawai) {
            return redirect()->back()->with('error', 'Silakan lengkapi data pegawai terlebih dahulu.');
        }

        // Ambil data keluarga berdasarkan pegawai_id, termasuk anak-anak
        $keluarga = Keluarga::with('anak')->where('pegawai_id', $pegawai->id)->first();

        if (!$keluarga) {
            return view('cms.pegawai.aksi.tambahProfileKeluarga', compact('pegawai'));
        }

        return view('cms.pegawai.profileKeluarga', compact('keluarga'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawai,id',
            'status_pernikahan' => 'nullable|in:belum menikah,menikah',
            'no_kk' => 'nullable|string|max:16',

            // Pasangan
            'nama_pasangan' => 'nullable|string',
            'gender' => 'nullable|in:laki-laki,perempuan',
            'nik_pasangan' => 'nullable|string|max:16',
            'agama' => 'nullable|in:Islam,Katolik,Kristen,Hindu,Buddha,Konghucu',
            'no_telp_pasangan' => 'nullable|string|max:14',
            'pendidikan_terakhir' => 'nullable|in:sd,smp,sma,s1,s2,s3',
            'status_bekerja_pasangan' => 'nullable|in:bekerja,tidak bekerja',
            'status_pasangan' => 'nullable|in:hidup,meninggal',

            // Orang tua
            'nama_ayah' => 'nullable|string',
            'status_bekerja_ayah' => 'nullable|in:bekerja,tidak bekerja',
            'status_ayah' => 'nullable|in:hidup,meninggal',
            'no_telp_ayah' => 'nullable|string|max:14',

            'nama_ibu' => 'nullable|string',
            'status_bekerja_ibu' => 'nullable|in:bekerja,tidak bekerja',
            'status_ibu' => 'nullable|in:hidup,meninggal',
            'no_telp_ibu' => 'nullable|string|max:14',
            'alamat_ortu' => 'nullable|string',

            // Anak-anak (array)
            'anak.*.nama' => 'nullable|string',
            'anak.*.nik' => 'nullable|string|max:16',
            'anak.*.tempat_lahir' => 'nullable|string',
            'anak.*.tgl_lahir' => 'nullable|date',
            'anak.*.gender' => 'nullable|in:laki-laki,perempuan',
            'anak.*.status_bekerja' => 'nullable|in:bekerja,tidak bekerja,pelajar',
            'anak.*.status_hidup' => 'nullable|in:hidup,meninggal',
            'anak.*.status_anak' => 'nullable|in:kandung,tiri,angkat',
            'anak.*.status_tanggungan' => 'nullable|boolean',
            'anak.*.status_pernikahan' => 'nullable|in:belum menikah,menikah',
        ]);

        DB::beginTransaction();
        try {
            $keluarga = Keluarga::create([
                'pegawai_id' => $request->pegawai_id,
                'status_pernikahan' => $request->status_pernikahan,
                'no_kk' => $request->no_kk,
                'nama_pasangan' => $request->nama_pasangan,
                'gender' => $request->gender,
                'nik_pasangan' => $request->nik_pasangan,
                'agama' => $request->agama,
                'no_telp_pasangan' => $request->no_telp_pasangan,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'status_bekerja_pasangan' => $request->status_bekerja_pasangan,
                'status_pasangan' => $request->status_pasangan,

                'nama_ayah' => $request->nama_ayah,
                'status_bekerja_ayah' => $request->status_bekerja_ayah,
                'status_ayah' => $request->status_ayah,
                'no_telp_ayah' => $request->no_telp_ayah,

                'nama_ibu' => $request->nama_ibu,
                'status_bekerja_ibu' => $request->status_bekerja_ibu,
                'status_ibu' => $request->status_ibu,
                'no_telp_ibu' => $request->no_telp_ibu,
                'alamat_ortu' => $request->alamat_ortu,
            ]);

            // Simpan anak-anak
            if ($request->has('anak')) {
                foreach ($request->anak as $dataAnak) {
                    Anak::create([
                        'keluarga_id' => $keluarga->id,
                        'nama' => $dataAnak['nama'],
                        'nik' => $dataAnak['nik'] ?? null,
                        'tempat_lahir' => $dataAnak['tempat_lahir'] ?? null,
                        'tgl_lahir' => $dataAnak['tgl_lahir'] ?? null,
                        'gender' => $dataAnak['gender'] ?? null,
                        'status_bekerja' => $dataAnak['status_bekerja'] ?? null,
                        'status_hidup' => $dataAnak['status_hidup'] ?? null,
                        'status_anak' => $dataAnak['status_anak'] ?? null,
                        'status_tanggungan' => isset($dataAnak['status_tanggungan']) ? (bool) $dataAnak['status_tanggungan'] : true,
                        'status_pernikahan' => $dataAnak['status_pernikahan'] ?? null,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('view-keluarga')->with('success', 'Data keluarga berhasil disimpan.');
        } catch (\Exception) {
            DB::rollBack();
            if ($request->has('anak')) {
                $Message = 'Gagal simpan. Mohon lengkapi data anak atau hapus form anak yang tidak digunakan.';
            }
            return redirect()->back()->with('error', $Message)->withInput();
        }
    }

    public function edit()
    {
        $keluarga = Keluarga::with('anak')->whereRelation('pegawai', 'nip_pegawai', Auth::user()->nip)->firstOrFail();


        return view('cms.pegawai.aksi.editProfileKeluarga', compact('keluarga'));
    }

    public function update(Request $request)
    {
        $keluarga = Keluarga::with('anak')->whereRelation('pegawai', 'nip_pegawai', Auth::user()->nip)->firstOrFail();

        $rules = [
            'status_pernikahan' => 'required|in:belum menikah,menikah',
            'no_kk' => 'nullable|string|max:16',
            // Pasangan
            'nama_pasangan' => 'required_if:status_pernikahan,menikah|nullable|string|max:255',
            'gender' => 'required_if:status_pernikahan,menikah|nullable|in:laki-laki,perempuan',
            'nik_pasangan' => 'required_if:status_pernikahan,menikah|nullable|string|max:16',
            'agama' => 'required_if:status_pernikahan,menikah|nullable|string|max:50',
            'no_telp_pasangan' => 'nullable|string|max:15',
            'pendidikan_terakhir' => 'nullable|string|max:10',
            'status_bekerja_pasangan' => 'required_if:status_pernikahan,menikah|nullable|in:bekerja,tidak bekerja',
            'status_pasangan' => 'required_if:status_pernikahan,menikah|nullable|in:hidup,meninggal',
            // Orang Tua
            'nama_ayah' => 'required|string|max:255',
            'no_telp_ayah' => 'required|string|max:15',
            'status_bekerja_ayah' => 'required|in:bekerja,tidak bekerja',
            'status_ayah' => 'required|in:hidup,meninggal',
            'nama_ibu' => 'required|string|max:255',
            'no_telp_ibu' => 'required|string|max:15',
            'status_bekerja_ibu' => 'required|in:bekerja,tidak bekerja',
            'status_ibu' => 'required|in:hidup,meninggal',
            'alamat_ortu' => 'required|string',
            // Anak
            'anak' => 'nullable|array',
            'anak.*.id' => 'nullable|integer|exists:anak,id',
            'anak.*.nama' => 'nullable|string|max:255',
            'anak.*.nik' => 'nullable|string|max:16',
            'anak.*.tempat_lahir' => 'nullable|string|max:100',
            'anak.*.tgl_lahir' => 'nullable|date',
            'anak.*.gender' => 'nullable|in:laki-laki,perempuan',
            'anak.*.status_bekerja' => 'nullable|in:bekerja,tidak bekerja,pelajar',
            'anak.*.status_hidup' => 'nullable|in:hidup,meninggal',
            'anak.*.status_anak' => 'nullable|in:kandung,tiri,angkat',
            'anak.*.status_pernikahan' => 'nullable|in:belum menikah,menikah',
            'anak.*.status_tanggungan' => 'nullable|boolean',
            'anak.*._delete' => 'nullable|in:1,true',
        ];
        $validatedData = $request->validate($rules);

        DB::beginTransaction();
        try {
            $keluargaAttributes = [
                'status_pernikahan' => $validatedData['status_pernikahan'],
                'no_kk' => $validatedData['no_kk'] ?? null,
                'nama_ayah' => $validatedData['nama_ayah'] ?? null,
                'no_telp_ayah' => $validatedData['no_telp_ayah'] ?? null,
                'status_bekerja_ayah' => $validatedData['status_bekerja_ayah'] ?? null,
                'status_ayah' => $validatedData['status_ayah'] ?? null,
                'nama_ibu' => $validatedData['nama_ibu'] ?? null,
                'no_telp_ibu' => $validatedData['no_telp_ibu'] ?? null,
                'status_bekerja_ibu' => $validatedData['status_bekerja_ibu'] ?? null,
                'status_ibu' => $validatedData['status_ibu'] ?? null,
                'alamat_ortu' => $validatedData['alamat_ortu'] ?? null,
            ];

            // Tambahkan atau null-kan data pasangan berdasarkan status pernikahan
            $pasanganFields = [
                'nama_pasangan',
                'gender',
                'nik_pasangan',
                'agama',
                'no_telp_pasangan',
                'pendidikan_terakhir',
                'status_bekerja_pasangan',
                'status_pasangan'
            ];
            if ($validatedData['status_pernikahan'] === 'menikah') {
                foreach ($pasanganFields as $field) {
                    $keluargaAttributes[$field] = $validatedData[$field] ?? null;
                }
            } else {
                foreach ($pasanganFields as $field) {
                    $keluargaAttributes[$field] = null;
                }
            }
            $keluarga->update($keluargaAttributes);

            // 3. PROSES DATA ANAK (bagian ini tidak ada di PegawaiController dan memerlukan logika terpisah)
            if (isset($validatedData['anak'])) {
                foreach ($validatedData['anak'] as $anakData) {
                    $anakId = $anakData['id'] ?? null;
                    $isDeleting = filter_var($anakData['_delete'] ?? false, FILTER_VALIDATE_BOOLEAN);

                    $anakPayload = Arr::except($anakData, ['id', '_delete', 'is_new']);
                    $anakPayload['status_tanggungan'] = filter_var(
                        $anakData['status_tanggungan'] ?? true,
                        FILTER_VALIDATE_BOOLEAN
                    );

                    if ($isDeleting && $anakId) {
                        Anak::where('id', $anakId)->where('keluarga_id', $keluarga->id)->delete();
                    } elseif ($anakId) { // Update anak yang sudah ada
                        $anakToUpdate = Anak::find($anakId);
                        if ($anakToUpdate && $anakToUpdate->keluarga_id == $keluarga->id) {
                            if (empty($anakData['nama'])) { // Skema anak.nama adalah NOT NULL
                                DB::rollBack();
                                return redirect()->back()->with('error', "Nama anak (ID: {$anakId}) tidak boleh kosong.")->withInput();
                            }
                            $anakToUpdate->update($anakPayload);
                        }
                    } elseif (!$isDeleting && !empty($anakData['nama'])) {
                        $keluarga->anak()->create($anakPayload);
                    }
                }
            }

            DB::commit();
            return redirect()->route('view-profile-keluarga')->with('success', 'Data Profile keluarga berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())->withInput();
        }
    }
}
