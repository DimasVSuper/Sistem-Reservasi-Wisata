<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    /**
     * Seed destination database with 10 popular Indonesian attractions.
     * 
     * Creates realistic destination records with:
     * - Authentic Indonesian location names
     * - Realistic pricing (Rp 250K - 800K)
     * - Star ratings (4.4 - 4.9)
     * - Visitor statistics
     * - Unsplash CDN images
     *
     * @return void
     */
    public function run(): void
    {
        // ===== INDONESIAN DESTINATIONS DATABASE =====
        // 10 curated popular attractions across Indonesia
        $destinations = [
            [
                'name' => 'Candi Borobudur',
                'description' => 'Candi Borobudur adalah sebuah kompleks kuil Budha yang terletak di Jawa Tengah, Indonesia. Dibangun pada abad ke-8, candi ini merupakan salah satu situs warisan dunia UNESCO terbesar di dunia.',
                'location' => 'Magelang, Jawa Tengah',
                'price' => 500000,
                'rating' => 4.8,
                'total_visitors' => 15000,
                'image_url' => 'https://images.unsplash.com/photo-p6R0z_jp0go?w=600&h=400&fit=crop',
            ],
            [
                'name' => 'Gunung Bromo',
                'description' => 'Gunung Bromo adalah gunung berapi aktif yang terletak di Jawa Timur. Pemandangan sunrise dari kawah Gunung Bromo sangat menakjubkan dan menjadi destinasi wisata favorit bagi para pendaki.',
                'location' => 'Probolinggo, Jawa Timur',
                'price' => 450000,
                'rating' => 4.7,
                'total_visitors' => 12000,
                'image_url' => 'https://images.unsplash.com/photo-xQnVa6pq5dg?w=600&h=400&fit=crop',
            ],
            [
                'name' => 'Pantai Parangtritis',
                'description' => 'Pantai Parangtritis adalah pantai indah yang terletak di Yogyakarta. Pantai ini terkenal dengan pasir hitamnya dan pemandangan matahari tenggelam yang memukau.',
                'location' => 'Yogyakarta',
                'price' => 300000,
                'rating' => 4.5,
                'total_visitors' => 20000,
                'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=600&h=400&fit=crop',
            ],
            [
                'name' => 'Taman Nasional Komodo',
                'description' => 'Taman Nasional Komodo adalah taman nasional yang terletak di Nusa Tenggara Timur. Taman ini adalah habitat alami dari komodo, biawak terbesar di dunia.',
                'location' => 'Nusa Tenggara Timur',
                'price' => 750000,
                'rating' => 4.9,
                'total_visitors' => 8000,
                'image_url' => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=600&h=400&fit=crop',
            ],
            [
                'name' => 'Danau Toba',
                'description' => 'Danau Toba adalah danau vulkanik terbesar di dunia yang terletak di Sumatra Utara. Keindahan alam di sekitar danau membuat tempat ini menjadi destinasi wisata yang populer.',
                'location' => 'Sumatra Utara',
                'price' => 600000,
                'rating' => 4.6,
                'total_visitors' => 10000,
                'image_url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&h=400&fit=crop',
            ],
            [
                'name' => 'Tanjung Tinggi Beach',
                'description' => 'Pantai Tanjung Tinggi adalah pantai eksotis dengan batu-batu granit besar yang menakjubkan. Pantai ini terletak di Belitung dan menjadi salah satu pantai terindah di Indonesia.',
                'location' => 'Belitung',
                'price' => 350000,
                'rating' => 4.7,
                'total_visitors' => 11000,
                'image_url' => 'https://images.unsplash.com/photo-1505142468610-359e7d316be0?w=600&h=400&fit=crop',
            ],
            [
                'name' => 'Bukit Kawi',
                'description' => 'Bukit Kawi adalah destinasi hiking populer dengan pemandangan alam yang spektakuler. Dari puncak bukit, Anda dapat melihat pegunungan dan lembah yang indah.',
                'location' => 'Malang, Jawa Timur',
                'price' => 250000,
                'rating' => 4.4,
                'total_visitors' => 9000,
                'image_url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&h=400&fit=crop',
            ],
            [
                'name' => 'Pulau Derawan',
                'description' => 'Pulau Derawan adalah pulau cantik di Kalimantan Timur dengan pantai pasir putih dan kehidupan laut yang kaya. Tempat ini sempurna untuk diving dan snorkeling.',
                'location' => 'Kalimantan Timur',
                'price' => 800000,
                'rating' => 4.9,
                'total_visitors' => 5000,
                'image_url' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=600&h=400&fit=crop',
            ],
            [
                'name' => 'Kawah Ijen',
                'description' => 'Kawah Ijen adalah kawah vulkanik yang terkenal dengan fenomena api biru yang langka. Pemandangan matahari terbit di atas kawah sangat menakjubkan.',
                'location' => 'Banyuwangi, Jawa Timur',
                'price' => 520000,
                'rating' => 4.8,
                'total_visitors' => 8500,
                'image_url' => 'https://images.unsplash.com/photo-1447614992633-dca1638810ab?w=600&h=400&fit=crop',
            ],
            [
                'name' => 'Pantai Kuta',
                'description' => 'Pantai Kuta adalah pantai terkenal di Bali dengan ombak yang sempurna untuk surfing. Pantai ini juga terkenal dengan sunset yang indah dan kehidupan malam yang meriah.',
                'location' => 'Bali',
                'price' => 280000,
                'rating' => 4.6,
                'total_visitors' => 25000,
                'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=600&h=400&fit=crop',
            ],
        ];

        // ===== CREATE DESTINATION RECORDS =====
        // Loop through array and create each destination in database
        foreach ($destinations as $destination) {
            Destination::create($destination);
        }
    }
}
