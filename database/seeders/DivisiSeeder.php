<?php

namespace Database\Seeders;

use App\Models\Divisi;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Divisi::firstOrCreate(['name' => 'Cloud Computing']);
        Divisi::firstOrCreate(['name' => 'Cyber Security']);
        Divisi::firstOrCreate(['name' => 'Technical Support']);
        Divisi::firstOrCreate(['name' => 'Networking']);
        Divisi::firstOrCreate(['name' => 'Software Development']);
    }
}
