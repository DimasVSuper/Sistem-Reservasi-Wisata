<?php

namespace Database\Seeders;

use App\Models\Reservasi;
use App\Models\User;
use App\Models\Wisata;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get sample users and wisata
        $customers = User::where('role', 'customer')->get();
        $wisatas = Wisata::all();

        // Create sample reservations
        $reservations = [
            [
                'user_id' => $customers[0]->id ?? 3,
                'wisata_id' => $wisatas[0]->id ?? 1,
                'tanggal_reservasi' => now()->addDays(5),
                'jumlah_orang' => 4,
                'total_harga' => 150000 * 4,
                'status' => 'pending',
                'catatan' => 'Pesan tiket untuk keluarga. Mohon bersiap',
            ],
            [
                'user_id' => $customers[0]->id ?? 3,
                'wisata_id' => $wisatas[1]->id ?? 2,
                'tanggal_reservasi' => now()->addDays(10),
                'jumlah_orang' => 2,
                'total_harga' => 200000 * 2,
                'status' => 'dikonfirmasi',
                'catatan' => 'Sunrise tour bersama istri',
            ],
            [
                'user_id' => $customers[1]->id ?? 4,
                'wisata_id' => $wisatas[2]->id ?? 3,
                'tanggal_reservasi' => now()->addDays(3),
                'jumlah_orang' => 3,
                'total_harga' => 100000 * 3,
                'status' => 'dikonfirmasi',
                'catatan' => 'Rombongan kantor',
            ],
            [
                'user_id' => $customers[1]->id ?? 4,
                'wisata_id' => $wisatas[3]->id ?? 4,
                'tanggal_reservasi' => now()->addDays(7),
                'jumlah_orang' => 5,
                'total_harga' => 175000 * 5,
                'status' => 'dibatalkan',
                'catatan' => 'Dibatalkan karena ada acara mendadak',
            ],
            [
                'user_id' => $customers[2]->id ?? 5,
                'wisata_id' => $wisatas[4]->id ?? 5,
                'tanggal_reservasi' => now()->addDays(15),
                'jumlah_orang' => 2,
                'total_harga' => 250000 * 2,
                'status' => 'pending',
                'catatan' => 'Honeymoon package',
            ],
            [
                'user_id' => $customers[2]->id ?? 5,
                'wisata_id' => $wisatas[6]->id ?? 7,
                'tanggal_reservasi' => now()->addDays(12),
                'jumlah_orang' => 6,
                'total_harga' => 180000 * 6,
                'status' => 'pending',
                'catatan' => 'Keluarga besar, butuh tour guide berbahasa inggris',
            ],
            [
                'user_id' => $customers[3]->id ?? 6,
                'wisata_id' => $wisatas[5]->id ?? 6,
                'tanggal_reservasi' => now()->addDays(8),
                'jumlah_orang' => 1,
                'total_harga' => 125000 * 1,
                'status' => 'dikonfirmasi',
                'catatan' => 'Solo traveler, senang fotografi',
            ],
        ];

        foreach ($reservations as $reservation) {
            Reservasi::create($reservation);
        }

        $this->command->info('✅ Reservasi seeding completed! Total: ' . count($reservations) . ' reservasi');
    }
}
