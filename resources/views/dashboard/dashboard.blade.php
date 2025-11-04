<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Reservasi Wisata</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .logout-btn {
            background: white;
            color: #667eea;
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
        .welcome-card {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        .welcome-card h2 {
            color: #333;
            margin-bottom: 1rem;
        }
        .welcome-card p {
            color: #666;
            line-height: 1.6;
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        .card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .card h3 {
            color: #333;
            margin-bottom: 0.5rem;
        }
        .card-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .card p {
            color: #666;
            font-size: 0.9rem;
        }
        .success-msg {
            background: #d4edda;
            color: #155724;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="brand">Sistem Reservasi Wisata</div>
            <div class="user-info">
                <span>Selamat datang, <strong>{{ auth()->user()->name }}</strong></span>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </header>

    <div class="container">
        @if (session('success'))
            <div class="success-msg">
                {{ session('success') }}
            </div>
        @endif

        <div class="welcome-card">
            <h2>Selamat Datang di Dashboard</h2>
            <p>
                Anda telah berhasil login ke Sistem Reservasi Wisata. 
                Di sini Anda dapat mengelola reservasi, melihat riwayat booking, dan memperbarui profil Anda.
            </p>
        </div>

        <div class="dashboard-grid">
            <div class="card">
                <div class="card-icon">📅</div>
                <h3>Reservasi Baru</h3>
                <p>Buat reservasi wisata ke destinasi favorit Anda</p>
                <a href="{{ route('reservasi.create') }}" style="color: #667eea; text-decoration: none; margin-top: 1rem; display: inline-block; font-weight: 600;">Mulai Reservasi →</a>
            </div>

            <div class="card">
                <div class="card-icon">📋</div>
                <h3>Riwayat Booking</h3>
                <p>Lihat semua riwayat reservasi Anda</p>
                <a href="{{ route('reservasi.index') }}" style="color: #667eea; text-decoration: none; margin-top: 1rem; display: inline-block; font-weight: 600;">Lihat Reservasi →</a>
            </div>

            <div class="card">
                <div class="card-icon">👤</div>
                <h3>Profil Saya</h3>
                <p>Update informasi pribadi dan kontak Anda</p>
            </div>

            <div class="card">
                <div class="card-icon">❓</div>
                <h3>Bantuan</h3>
                <p>Hubungi tim support kami untuk bantuan</p>
            </div>
        </div>
    </div>
</body>
</html>
