<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password123'),
            'nip' => '1234567890123456'
        ]);

        $user->assignRole('super admin');
    }
    
}
