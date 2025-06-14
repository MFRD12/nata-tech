<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Pegawai::create([
            'nip_pegawai' => '1987091520230101',
            'nama' => 'Ahmad Surya',
            'foto' => null,
            'tempat_lahir' => 'Medan',
            'tgl_lahir' => '1987-09-15',
            'gender' => 'laki-laki',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Mawar No.10, Medan',
            'tgl_masuk' => '2023-02-01',
            'jabatan_id' => 1,
            'divisi_id' => 1,
            'status' => 'aktif',
        ]);
    }
}
