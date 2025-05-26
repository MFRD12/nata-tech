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
            'nip_pegawai' => '1234567890123456',
            'nama' => 'Budi Santoso',
            'tempat_lahir' => 'Jakarta',
            'tgl_lahir' => '1990-01-01',
            'gender' => 'laki-laki',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Merdeka No. 1',
            'tgl_masuk' => '2020-01-01',
            'jabatan' => 'Manager',
            'divisi' => 'Keuangan',
            'status' => 'aktif',
            'foto' => $this->generateRandomAvatarUrl()
        ]);
    }

     private function generateRandomAvatarUrl()
    {
        // URL avatar acak dari pravatar.cc, ID 1-70 menghasilkan gambar orang berbeda
        $randomId = rand(1, 70);
        return "https://i.pravatar.cc/150?img={$randomId}";
    }
}
