<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            WisataSeeder::class,
            ReservasiSeeder::class,
        ]);

        $this->command->info('✅ All seeders executed successfully!');
        $this->command->line('');
        $this->command->info('📝 Test Accounts:');
        $this->command->line('  Admin: admin@wisata.com / password123');
        $this->command->line('  Petugas: petugas1@wisata.com / password123');
        $this->command->line('  Customer: budi@example.com / password123');
        $this->command->line('  Customer: siti@example.com / password123');
        $this->command->line('');
    }
}

