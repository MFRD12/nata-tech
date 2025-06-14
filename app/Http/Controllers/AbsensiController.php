<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::where('nip_pegawai', Auth::user()->nip)->first();

        // Cek apakah data pegawai tersedia
        if (!$pegawai) {
            return redirect()->back()->with('error', 'Silakan lengkapi data pegawai terlebih dahulu.');
        }

        $today = Carbon::now()->setTimezone('Asia/Jakarta')->toDateString();

        $absen = Absensi::where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', $today)
            ->first();

        $now = Carbon::now()->setTimezone('Asia/Jakarta');
        $startTime = Carbon::createFromTime(6, 0, 0, 'Asia/Jakarta');
        $endTime = Carbon::createFromTime(23, 0, 0, 'Asia/Jakarta');

        $isAbsensiOpen = $now->between($startTime, $endTime);

        return view('cms.pegawai.absenPegawai', compact('pegawai', 'absen', 'isAbsensiOpen'));
    }

    public function absenMasuk()
    {
        $pegawai = Pegawai::where('nip_pegawai', Auth::user()->nip)->firstOrFail();
        $today = Carbon::now()->setTimezone('Asia/Jakarta')->toDateString();
        $now = Carbon::now()->setTimezone('Asia/Jakarta');

        $existing = Absensi::where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', $today)
            ->first();

        if (!$existing) {
            Absensi::create([
                'pegawai_id' => $pegawai->id,
                'tanggal' => $today,
                'jam_masuk' => Carbon::now()->setTimezone('Asia/Jakarta')->format('H:i:s'),
                'status' => $now->gt(Carbon::createFromTime(7, 0, 0, 'Asia/Jakarta')) ? 'terlambat masuk' : 'hadir',
            ]);
        }

        return redirect()->back()->with('success', 'Absen masuk berhasil');
    }

    public function absenPulang()
    {
        $pegawai = Pegawai::where('nip_pegawai', Auth::user()->nip)->firstOrFail();
        $today = Carbon::now()->setTimezone('Asia/Jakarta')->toDateString();
        $now = Carbon::now()->setTimezone('Asia/Jakarta');

        $absen = Absensi::where('pegawai_id', $pegawai->id)
            ->whereDate('tanggal', $today)
            ->first();

        if ($absen && !$absen->jam_pulang) {
            $jamMasuk = Carbon::createFromFormat('H:i:s', $absen->jam_masuk, 'Asia/Jakarta');
            $jamPulang = $now;

            // Tentukan status berdasarkan kondisi jam
            if ($jamMasuk->lte(Carbon::createFromTime(7, 0, 0, 'Asia/Jakarta')) && $jamPulang->gte(Carbon::createFromTime(16, 0, 0, 'Asia/Jakarta'))) {
                $status = 'hadir';

            } elseif ($jamMasuk->gt(Carbon::createFromTime(7, 0, 0, 'Asia/Jakarta')) && $jamPulang->lt(Carbon::createFromTime(16, 0, 0, 'Asia/Jakarta'))) {
                $status = 'terlambat masuk';

            } elseif ($jamMasuk->gt(Carbon::createFromTime(7, 0, 0, 'Asia/Jakarta')) && $jamPulang->gte(Carbon::createFromTime(16, 0, 0, 'Asia/Jakarta'))) {
                $status = 'terlambat masuk';

            } elseif ($jamMasuk->lte(Carbon::createFromTime(7, 0, 0, 'Asia/Jakarta')) && $jamPulang->lt(Carbon::createFromTime(16, 0, 0, 'Asia/Jakarta'))) {
                $status = 'pulang awal';
            } else {
                $status = $absen->status;
            }

            $absen->update([
                'jam_pulang' => $jamPulang->format('H:i:s'),
                'status' => $status,
            ]);
        }

        return redirect()->back()->with('success', 'Absen pulang berhasil');
    }

    public function riwayat(Request $request)
    {
        $pegawai = Pegawai::where('nip_pegawai', Auth::user()->nip)->firstOrFail();
        $bulan = $request->input('bulan', Carbon::now()->setTimezone('Asia/Jakarta')->format('m'));
        $tahun = $request->input('tahun', Carbon::now()->setTimezone('Asia/Jakarta')->format('Y'));

        $riwayat = Absensi::where('pegawai_id', $pegawai->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'asc')
            ->get();

        // Ambil daftar tahun yang tersedia di absensi pegawai
        $tahunList = Absensi::where('pegawai_id', $pegawai->id)
            ->selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('cms.pegawai.riwayatAbsen', compact('pegawai', 'riwayat', 'bulan', 'tahun', 'tahunList'));
    }


    //function pada halaman admin rekap absensi
    public function rekapIndex(Request $request)
    {
        $pegawaiList = Pegawai::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $pegawaiList->where(function ($cari) use ($search) {
                $cari->where('nip_pegawai', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('perPage', 10);
        $pegawais = $pegawaiList
            ->orderBy('nama', 'asc')
            ->paginate($perPage)
            ->withQueryString();

        return view('cms.admin.kepegawaian.rekapAbsen', compact('pegawais'));
    }

    // Detail absensi pegawai tertentu
    public function rekapDetail(Request $request, $id)
    {
        $pegawai = Pegawai::find($id);

        if (!$pegawai) {
            return redirect()->route('view-rekap-absensi')->with('error_user', 'Data tidak ditemukan.');
        }

        $absensiQuery = Absensi::where('pegawai_id', $pegawai->id);

        if ($request->filled('status')) {
            $absensiQuery->where('status', $request->status);
        }

        if ($request->filled('bulan') && $request->filled('tahun')) {
            $absensiQuery->whereMonth('tanggal', $request->bulan)
                ->whereYear('tanggal', $request->tahun);
        }

        $tahunList = Absensi::where('pegawai_id', $pegawai->id)
            ->selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        $riwayat = $absensiQuery->orderBy('tanggal', 'desc')->get();

        return view('cms.admin.kepegawaian.aksi.detailAbsen', compact('pegawai', 'riwayat', 'tahunList'));
    }

    // Mengubah status absensi dan keterangan
    public function updateAbsensi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:hadir,izin,sakit,alpha,terlambat masuk,pulang awal',
            'keterangan' => 'nullable|string',
        ]);

        $absensi = Absensi::findOrFail($id);
        $absensi->update([
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Data absensi berhasil diperbarui');
    }
}

