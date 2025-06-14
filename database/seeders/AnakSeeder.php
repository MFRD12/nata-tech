<?php

namespace Database\Seeders;

use App\Models\Anak;
use App\Models\Keluarga;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AnakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $keluarga = Keluarga::first(); // ambil keluarga pertama

        if ($keluarga) {
            Anak::create([
                'keluarga_id' => $keluarga->id,
                'nama' => 'Putri Surya',
                'nik' => '3175098765432103',
                'tempat_lahir' => 'Medan',
                'tgl_lahir' => '2010-06-20',
                'gender' => 'perempuan',
                'status_bekerja' => 'pelajar',
                'status_hidup' => 'hidup',
                'status_anak' => 'kandung',
                'status_tanggungan' => true,
                'status_pernikahan' => 'belum menikah',
            ]);
        }
    }
}
