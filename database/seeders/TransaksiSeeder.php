<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Kategori;
use App\Models\Transaksi;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $kategoris = Kategori::all();

         Transaksi::create([
            'tanggal' => Carbon::now()->subDays(1),
            'nama_transaksi' => 'Penjualan Barang',
            'jumlah' => 1500000,
            'kategori_id' => $kategoris->random()->id,
            'nota' => null,
        ]);
    }
}
