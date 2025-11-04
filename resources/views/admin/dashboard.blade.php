<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Sistem Reservasi Wisata</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
        }
        header {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            color: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .badge {
            background: rgba(255, 255, 255, 0.3);
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            margin-left: 0.5rem;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .logout-btn {
            background: white;
            color: #ee5a6f;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: transform 0.2s;
        }
        .logout-btn:hover {
            transform: translateY(-2px);
        }
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        h1 {
            color: #333;
            margin-bottom: 2rem;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #ff6b6b;
        }
        .stat-card.blue {
            border-left-color: #4c72b0;
        }
        .stat-card.green {
            border-left-color: #55a868;
        }
        .stat-card.orange {
            border-left-color: #f39c12;
        }
        .stat-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        .stat-label {
            font-size: 0.9rem;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-top: 0.5rem;
        }
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
        }
        .menu-card {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            text-decoration: none;
            color: #333;
            transition: all 0.3s;
            border: 2px solid transparent;
        }
        .menu-card:hover {
            border-color: #ff6b6b;
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(255, 107, 107, 0.2);
        }
        .menu-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .menu-title {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }
        .menu-desc {
            font-size: 0.9rem;
            color: #666;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="brand">
                Sistem Reservasi Wisata
                <span class="badge">Admin</span>
            </div>
            <div class="user-info">
                <span>{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </header>

    <div class="container">
        <h1>👨‍💼 Dashboard Admin</h1>

        <div class="stats-grid">
            <div class="stat-card blue">
                <div class="stat-icon">🏖️</div>
                <div class="stat-label">Total Destinasi</div>
                <div class="stat-value">{{ $totalDestinasi }}</div>
            </div>

            <div class="stat-card green">
                <div class="stat-icon">📋</div>
                <div class="stat-label">Total Pesanan</div>
                <div class="stat-value">{{ $totalPesanan }}</div>
            </div>

            <div class="stat-card orange">
                <div class="stat-icon">⏳</div>
                <div class="stat-label">Pending</div>
                <div class="stat-value">{{ $totalPending }}</div>
            </div>

            <div class="stat-card" style="border-left-color: #9b59b6;">
                <div class="stat-icon">💰</div>
                <div class="stat-label">Total Revenue</div>
                <div class="stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            </div>
        </div>

        <h2 style="margin-bottom: 1.5rem; color: #333;">Menu Manajemen</h2>
        <div class="menu-grid">
            <a href="{{ route('admin.destinasi.index') }}" class="menu-card">
                <div class="menu-icon">🏝️</div>
                <div class="menu-title">Kelola Destinasi</div>
                <div class="menu-desc">Tambah, edit, hapus destinasi wisata</div>
            </a>

            <a href="{{ route('admin.pesanan.index') }}" class="menu-card">
                <div class="menu-icon">📦</div>
                <div class="menu-title">Lihat Pesanan</div>
                <div class="menu-desc">Kelola semua pesanan customer</div>
            </a>

            <a href="{{ route('dashboard') }}" class="menu-card">
                <div class="menu-icon">👤</div>
                <div class="menu-title">Profil Saya</div>
                <div class="menu-desc">Kelola profil dan pengaturan</div>
            </a>

            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="menu-card" style="color: #dc3545;">
                <div class="menu-icon">🚪</div>
                <div class="menu-title">Logout</div>
                <div class="menu-desc">Keluar dari sistem</div>
            </a>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</body>
</html>
