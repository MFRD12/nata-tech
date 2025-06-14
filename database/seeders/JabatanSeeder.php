<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jabatan::firstOrCreate(['name' => 'Direktur']);
        Jabatan::firstOrCreate(['name' => 'Pegawai']);
        Jabatan::firstOrCreate(['name' => 'Manajer']);
        Jabatan::firstOrCreate(['name' => 'Marketing']);
        Jabatan::firstOrCreate(['name' => 'IT Support']);
    }
}
