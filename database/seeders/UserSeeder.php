<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin/Petugas User
        User::create([
            'name' => 'Admin Wisata',
            'email' => 'admin@wisata.com',
            'hp' => '081234567890',
            'role' => 'petugas_user',
            'status' => 'active',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Petugas 1',
            'email' => 'petugas1@wisata.com',
            'hp' => '081234567891',
            'role' => 'petugas_user',
            'status' => 'active',
            'password' => Hash::make('password123'),
        ]);

        // Customer Users
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'hp' => '081234567892',
            'role' => 'customer',
            'status' => 'active',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@example.com',
            'hp' => '081234567893',
            'role' => 'customer',
            'status' => 'active',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Ahmad Ridho',
            'email' => 'ahmad@example.com',
            'hp' => '081234567894',
            'role' => 'customer',
            'status' => 'active',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Dewi Lestari',
            'email' => 'dewi@example.com',
            'hp' => '081234567895',
            'role' => 'customer',
            'status' => 'active',
            'password' => Hash::make('password123'),
        ]);

        $this->command->info('✅ User seeding completed!');
    }
}
