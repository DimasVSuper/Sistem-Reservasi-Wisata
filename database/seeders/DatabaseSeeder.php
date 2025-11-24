<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * This master seeder orchestrates all database seeding in proper order:
     * 1. Users (admin credentials)
     * 2. Destinations (10 tourist attractions)
     * 3. Reservations (200 reservation records)
     *
     * @return void
     */
    public function run(): void
    {
        // ===== SEED EXECUTION ORDER =====
        // Order matters: Users first, then Destinations, then Reservations
        // (Reservations have FK to Destinations)
        $this->call([
            UserSeeder::class,           // Admin user credentials
            DestinationSeeder::class,    // 10 Indonesian destinations
            ReservationSeeder::class,    // 200 reservation records
        ]);
    }
}

