<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use App\Models\Keluarga;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KeluargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pegawai = Pegawai::where('nip_pegawai', '1987091520230101')->first();

        if ($pegawai) {
            Keluarga::create([
                'pegawai_id' => $pegawai->id,
                'status_pernikahan' => 'menikah',
                'no_kk' => '3175098765432101',
                'nama_pasangan' => 'Siti Rahma',
                'gender' => 'perempuan',
                'nik_pasangan' => '3175098765432102',
                'agama' => 'islam',
                'no_telp_pasangan' => '081234567891',
                'pendidikan_terakhir' => 's1',
                'status_bekerja_pasangan' => 'tidak bekerja',
                'status_pasangan' => 'hidup',
                'nama_ayah' => 'H. Usman',
                'status_bekerja_ayah' => 'tidak bekerja',
                'status_ayah' => 'hidup',
                'no_telp_ayah' => '081234567892',
                'nama_ibu' => 'Hj. Aminah',
                'status_bekerja_ibu' => 'tidak bekerja',
                'no_telp_ibu' => '081234567893',
                'status_ibu' => 'hidup',
                'alamat_ortu' => 'Jl. Kenanga No.5, Medan',
            ]);
        }
    }
}
