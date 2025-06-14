<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategori')->insert([
            ['name' => 'Gaji', 'jenis' => 'pemasukan'],
            ['name' => 'Bonus', 'jenis' => 'pemasukan'],
            ['name' => 'Belanja', 'jenis' => 'pengeluaran'],
            ['name' => 'Transportasi', 'jenis' => 'pengeluaran'],
        ]);

    }
}
