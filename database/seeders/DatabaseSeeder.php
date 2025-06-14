<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            JabatanSeeder::class,
            DivisiSeeder::class,
            PegawaiSeeder::class,
            KeluargaSeeder::class,
            AnakSeeder::class,
            KategoriSeeder::class,
            TransaksiSeeder::class,
        ]);
    }
}
