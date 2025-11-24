<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Seed 200 reservation records using ReservationFactory.
     * 
     * Generates realistic test data with:
     * - 80+ authentic Indonesian names & emails
     * - Indonesian phone numbers (081-089 format)
     * - Random status distribution
     * - Realistic pricing based on destinations
     * 
     * Data Distribution (200 total):
     * - 140 random mixed statuses (70%)
     * - 35 pending reservations (17.5%)
     * - 20 confirmed reservations (10%)
     * - 5 cancelled reservations (2.5%)
     *
     * @return void
     */
    public function run(): void
    {
        // ===== GENERATE RANDOM RESERVATIONS =====
        // 140 reservations with random status mix
        // Uses ReservationFactory to generate authentic Indonesian data
        Reservation::factory(140)->create();

        // ===== GENERATE STATUS-SPECIFIC RESERVATIONS =====
        // 35 pending reservations (awaiting confirmation)
        Reservation::factory(35)->pending()->create();

        // 20 confirmed reservations (approved)
        Reservation::factory(20)->confirmed()->create();

        // 5 cancelled reservations (rejected/cancelled)
        Reservation::factory(5)->cancelled()->create();

        // ===== TOTAL RESERVATIONS CREATED: 200 =====
    }
}
