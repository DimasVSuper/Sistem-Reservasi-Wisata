<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Reservasi Wisata - Kelompok 4</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }

        /* Header & Navigation */
        header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2rem;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo span {
            font-size: 1.5rem;
        }

        nav {
            flex: 1;
            display: flex;
            justify-content: center;
            gap: 2rem;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.3s;
        }

        nav a:hover {
            opacity: 0.8;
        }

        .auth-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.6rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
        }

        .btn-login {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid white;
        }

        .btn-login:hover {
            background: white;
            color: #667eea;
            transform: translateY(-2px);
        }

        .btn-register {
            background: white;
            color: #667eea;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4rem 2rem;
            text-align: center;
        }

        .hero-content {
            max-width: 1200px;
            margin: 0 auto;
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.95;
        }

        .hero-group {
            font-size: 1rem;
            opacity: 0.9;
            margin-top: 1rem;
        }

        /* Search Section */
        .search-section {
            max-width: 1200px;
            margin: -3rem auto 3rem;
            padding: 0 2rem;
            position: relative;
            z-index: 10;
        }

        .search-box {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 1rem;
        }

        .search-box input {
            flex: 1;
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .search-box input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 8px rgba(102, 126, 234, 0.2);
        }

        .search-box button {
            padding: 0.75rem 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: transform 0.3s;
        }

        .search-box button:hover {
            transform: translateY(-2px);
        }

        /* Main Content */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .section-title {
            font-size: 2rem;
            color: #333;
            margin: 3rem 0 2rem;
            text-align: center;
            position: relative;
        }

        .section-title::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0.5rem auto 0;
            border-radius: 2px;
        }

        /* Destinations Grid */
        .destinations-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .destination-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            cursor: pointer;
        }

        .destination-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .destination-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: white;
            font-weight: bold;
        }

        .destination-content {
            padding: 1.5rem;
        }

        .destination-content h3 {
            color: #333;
            margin-bottom: 0.5rem;
            font-size: 1.3rem;
        }

        .destination-location {
            color: #999;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .destination-description {
            color: #666;
            font-size: 0.95rem;
            margin-bottom: 1rem;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .destination-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }

        .destination-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #667eea;
        }

        .destination-capacity {
            color: #999;
            font-size: 0.9rem;
        }

        .btn-small {
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-small:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
        }

        .status-badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            background: #d4edda;
            color: #155724;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-badge.penuh {
            background: #f8d7da;
            color: #721c24;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #999;
        }

        .empty-state h3 {
            color: #666;
            margin-bottom: 1rem;
        }

        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 8px;
            margin: 3rem 0;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            text-align: center;
        }

        .stat-item h4 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .stat-item p {
            opacity: 0.9;
        }

        /* Footer */
        footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 2rem;
            margin-top: 3rem;
        }

        /* Loading Spinner */
        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Toast Notification */
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            background: #333;
            color: white;
            border-radius: 5px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            animation: slideIn 0.3s ease-out;
        }

        .toast-success {
            background: #28a745;
        }

        .toast-info {
            background: #17a2b8;
        }

        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }

            nav {
                flex-direction: column;
                gap: 0.5rem;
                text-align: center;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .destinations-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }

            .search-box {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-content">
            <div class="logo">
                <span>🏖️</span>
                <div>
                    <div>Wisata Indonesia</div>
                    <div style="font-size: 0.8rem; opacity: 0.9;">Kelompok 4</div>
                </div>
            </div>
            <nav>
                <a href="#destinasi">Destinasi</a>
                <a href="#tentang">Tentang Kami</a>
                <a href="#kontak">Kontak</a>
            </nav>
            <div class="auth-buttons">
                @if(auth()->check())
                    <a href="{{ route('dashboard') }}" class="btn btn-login">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-register">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-login">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-register">Register</a>
                @endif
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>🌴 Sistem Reservasi Wisata 🌴</h1>
            <p>Temukan dan pesan destinasi wisata impian Anda dengan mudah</p>
            <div class="hero-group">
                <strong>Kelompok 4</strong> - Sistem Informasi Manajemen Reservasi Wisata
            </div>
        </div>
    </section>

    <!-- Search Section -->
    <div class="search-section">
        <div class="search-box">
            <input type="text" id="searchDestinasi" placeholder="Cari destinasi wisata...">
            <button onclick="searchDestinasi()">🔍 Cari</button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <!-- Stats -->
        <div class="stats-section" id="statsSection"></div>

        <!-- Destinations Section -->
        <section id="destinasi">
            <h2 class="section-title">✨ Destinasi Wisata Tersedia</h2>
            <div class="destinations-grid" id="destinasiGrid">
                <div style="grid-column: 1/-1; text-align: center; padding: 3rem;">
                    <div class="spinner"></div>
                    <p style="margin-top: 1rem; color: #999;">Loading destinasi...</p>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="tentang" style="margin: 3rem 0; text-align: center;">
            <h2 class="section-title">ℹ️ Tentang Sistem Kami</h2>
            <p style="font-size: 1.1rem; color: #666; max-width: 700px; margin: 0 auto;">
                Sistem Reservasi Wisata adalah platform digital yang memudahkan pelanggan untuk menemukan dan memesan destinasi wisata pilihan. 
                Dengan antarmuka yang user-friendly dan fitur lengkap, kami siap memberikan pengalaman reservasi terbaik untuk Anda.
            </p>
        </section>
    </div>

    <!-- Footer -->
    <footer id="kontak">
        <p><strong>Sistem Reservasi Wisata - Kelompok 4</strong></p>
        <p>📧 Email: info@wisata.com | 📱 Phone: +62 812-3456-7890</p>
        <p>&copy; 2025 All Rights Reserved</p>
    </footer>

    <script>
        // Load destinasi saat halaman dibuka
        document.addEventListener('DOMContentLoaded', () => {
            loadDestinasi();
            loadStats();
        });

        // Load all destinations
        function loadDestinasi(searchQuery = '') {
            fetch('/api/destinasi' + (searchQuery ? '?search=' + searchQuery : ''))
                .then(response => response.json())
                .then(data => {
                    renderDestinasi(data.data || []);
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('destinasiGrid').innerHTML = `
                        <div style="grid-column: 1/-1; text-align: center;">
                            <div class="empty-state">
                                <h3>Gagal memuat destinasi</h3>
                                <p>Silahkan refresh halaman</p>
                            </div>
                        </div>
                    `;
                });
        }

        // Render destinasi cards
        function renderDestinasi(destinasi) {
            const grid = document.getElementById('destinasiGrid');
            
            if (destinasi.length === 0) {
                grid.innerHTML = `
                    <div style="grid-column: 1/-1;">
                        <div class="empty-state">
                            <h3>Destinasi tidak ditemukan</h3>
                            <p>Coba cari dengan kata kunci lain</p>
                        </div>
                    </div>
                `;
                return;
            }

            grid.innerHTML = destinasi.map(d => `
                <div class="destination-card">
                    <div class="destination-image">
                        ${getEmoji(d.nama)}
                    </div>
                    <div class="destination-content">
                        <h3>${d.nama}</h3>
                        <div class="destination-location">
                            📍 ${d.lokasi}
                        </div>
                        <div class="destination-description">
                            ${d.deskripsi}
                        </div>
                        <div class="destination-footer">
                            <div>
                                <div class="destination-price">Rp ${new Intl.NumberFormat('id-ID').format(d.harga)}</div>
                                <div class="destination-capacity">Kapasitas: ${d.kapasitas} orang</div>
                            </div>
                            <span class="status-badge ${d.status}">
                                ${d.status === 'tersedia' ? '✓ Tersedia' : '⊗ Penuh'}
                            </span>
                        </div>
                        ${auth().check() ? `
                            <button onclick="window.location.href='/reservasi/create'" class="btn-small" style="width: 100%; margin-top: 1rem;">
                                Pesan Sekarang
                            </button>
                        ` : `
                            <button onclick="showLoginPrompt()" class="btn-small" style="width: 100%; margin-top: 1rem;">
                                Pesan Sekarang
                            </button>
                        `}
                    </div>
                </div>
            `).join('');
        }

        // Get emoji for destination
        function getEmoji(nama) {
            const emojiMap = {
                'gunung': '⛰️', 'pantai': '🏖️', 'laut': '🌊', 'air terjun': '💧',
                'danau': '🏞️', 'hutan': '🌲', 'bukit': '🏔️', 'pulau': '🏝️'
            };
            for (let key in emojiMap) {
                if (nama.toLowerCase().includes(key)) {
                    return emojiMap[key];
                }
            }
            return '🎯';
        }

        // Search destinasi
        function searchDestinasi() {
            const query = document.getElementById('searchDestinasi').value;
            if (query.trim()) {
                loadDestinasi(query);
            }
        }

        // Search on Enter key
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('searchDestinasi').addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    searchDestinasi();
                }
            });
        });

        // Load statistics
        function loadStats() {
            fetch('/api/stats')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('statsSection').innerHTML = `
                        <div class="stat-item">
                            <h4>${data.totalDestinasi || 0}</h4>
                            <p>Destinasi Wisata</p>
                        </div>
                        <div class="stat-item">
                            <h4>${data.totalReservasi || 0}</h4>
                            <p>Total Reservasi</p>
                        </div>
                        <div class="stat-item">
                            <h4>${data.totalCustomer || 0}</h4>
                            <p>Pelanggan Aktif</p>
                        </div>
                    `;
                })
                .catch(error => console.error('Error loading stats:', error));
        }

        // Show login prompt
        function showLoginPrompt() {
            showToast('Silahkan login terlebih dahulu untuk melakukan reservasi', 'info');
            setTimeout(() => {
                window.location.href = '{{ route("login") }}';
            }, 1500);
        }

        // Show toast notification
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.textContent = message;
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Helper function for auth check
        function auth() {
            return {
                check: () => {{ auth()->check() ? 'true' : 'false' }}
            };
        }
    </script>
</body>
</html>
