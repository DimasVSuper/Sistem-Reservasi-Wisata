<?php

namespace Database\Seeders;

use App\Models\Wisata;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WisataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinasi = [
            [
                'nama' => 'Pantai Kuta Bali',
                'deskripsi' => 'Pantai pasir putih yang indah dengan ombak sempurna untuk surfing. Menikmati sunset yang memukau bersama orang tersayang.',
                'lokasi' => 'Kuta, Denpasar, Bali',
                'harga' => 150000,
                'kapasitas' => 50,
                'status' => 'tersedia',
            ],
            [
                'nama' => 'Gunung Bromo',
                'deskripsi' => 'Pemandangan sunrise yang spektakuler dari puncak gunung. Fenomena alam yang langka dengan lautan pasir yang luas.',
                'lokasi' => 'Probolinggo, Jawa Timur',
                'harga' => 200000,
                'kapasitas' => 30,
                'status' => 'tersedia',
            ],
            [
                'nama' => 'Air Terjun Tegenungan',
                'deskripsi' => 'Air terjun besar dengan kolam renang alami yang menyegarkan. Sempurna untuk berenang dan fotografi alam.',
                'lokasi' => 'Bangli, Bali',
                'harga' => 100000,
                'kapasitas' => 100,
                'status' => 'tersedia',
            ],
            [
                'nama' => 'Danau Toba',
                'deskripsi' => 'Danau terbesar di Asia Tenggara dengan pemandangan alam yang menakjubkan. Pulau Samosir di tengah danau adalah daya tarik utama.',
                'lokasi' => 'Medan, Sumatera Utara',
                'harga' => 175000,
                'kapasitas' => 40,
                'status' => 'penuh',
            ],
            [
                'nama' => 'Pulau Komodo',
                'deskripsi' => 'Rumah bagi komodo, reptil raksasa yang langka. Pemandangan landscape yang eksotis dan petualangan yang tak terlupakan.',
                'lokasi' => 'Labuan Bajo, Nusa Tenggara Timur',
                'harga' => 250000,
                'kapasitas' => 25,
                'status' => 'tersedia',
            ],
            [
                'nama' => 'Taman Nasional Ujung Kulon',
                'deskripsi' => 'Hutan tropis yang masih asri dengan keanekaragaman hayati yang luar biasa. Tempat hidup badak Jawa yang terancam punah.',
                'lokasi' => 'Sukabumi, Jawa Barat',
                'harga' => 125000,
                'kapasitas' => 60,
                'status' => 'tersedia',
            ],
            [
                'nama' => 'Borobudur Temple',
                'deskripsi' => 'Candi Budha terbesar di dunia dengan arsitektur yang memukau. Pengalaman spiritual yang mendalam di tengah keindahan alam.',
                'lokasi' => 'Magelang, Jawa Tengah',
                'harga' => 180000,
                'kapasitas' => 80,
                'status' => 'tersedia',
            ],
            [
                'nama' => 'Raja Ampat',
                'deskripsi' => 'Kepulauan dengan kekayaan terumbu karang terbesar di dunia. Surga untuk penyelam dan pecinta alam bawah laut.',
                'lokasi' => 'Sorong, Papua Barat',
                'harga' => 300000,
                'kapasitas' => 20,
                'status' => 'tersedia',
            ],
            [
                'nama' => 'Kawah Ijen',
                'deskripsi' => 'Fenomena Blue Fire yang jarang terjadi di dunia. Danau dengan air bersulfur yang berwarna biru cemerlang di malam hari.',
                'lokasi' => 'Banyuwangi, Jawa Timur',
                'harga' => 160000,
                'kapasitas' => 35,
                'status' => 'tersedia',
            ],
            [
                'nama' => 'Tanjung Puting',
                'deskripsi' => 'Taman nasional dengan populasi orangutan terbesar. Petualangan sungai yang mengasyikkan menjelajahi hutan belantara.',
                'lokasi' => 'Kotawaringin Timur, Kalimantan Tengah',
                'harga' => 220000,
                'kapasitas' => 28,
                'status' => 'tersedia',
            ],
        ];

        foreach ($destinasi as $wisata) {
            Wisata::create($wisata);
        }

        $this->command->info('✅ Wisata seeding completed! Total: ' . count($destinasi) . ' destinasi');
    }
}
