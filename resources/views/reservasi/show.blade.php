<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Reservasi - Sistem Reservasi Wisata</title>
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
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        .breadcrumb {
            display: flex;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 1.5rem;
        }
        .breadcrumb a {
            color: #667eea;
            text-decoration: none;
        }
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        h2 {
            color: #333;
            margin-bottom: 1.5rem;
        }
        .detail-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .detail-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        .detail-item {
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #eee;
        }
        .detail-item:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .detail-value {
            color: #333;
            font-size: 1.1rem;
        }
        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        .status-dikonfirmasi {
            background: #d4edda;
            color: #155724;
        }
        .status-dibatalkan {
            background: #f8d7da;
            color: #721c24;
        }
        .wisata-section {
            background: #f9f9ff;
            padding: 1.5rem;
            border-radius: 4px;
            border-left: 4px solid #667eea;
            margin: 2rem 0;
        }
        .wisata-section h3 {
            color: #333;
            margin-bottom: 1rem;
        }
        .wisata-section p {
            color: #666;
            line-height: 1.6;
        }
        .summary-section {
            background: #f0f0f0;
            padding: 1.5rem;
            border-radius: 4px;
            margin-top: 2rem;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }
        .summary-row.total {
            border-top: 2px solid #ddd;
            padding-top: 1rem;
            font-weight: 600;
            color: #667eea;
        }
        .btn-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        .btn {
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: transform 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
        }
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        .btn-danger:hover {
            transform: translateY(-2px);
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            transform: translateY(-2px);
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
                <span>{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <a href="{{ route('reservasi.index') }}">Reservasi Saya</a>
            <span>/</span>
            <span>Detail Reservasi</span>
        </div>

        @if (session('success'))
            <div class="success-msg">
                {{ session('success') }}
            </div>
        @endif

        <h2>📊 Detail Reservasi</h2>

        <div class="detail-container">
            <div class="detail-row">
                <div class="detail-item">
                    <div class="detail-label">Nomor Reservasi</div>
                    <div class="detail-value">#{{ str_pad($reservasi->id, 6, '0', STR_PAD_LEFT) }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">
                        <span class="status-badge status-{{ $reservasi->status }}">
                            {{ ucfirst($reservasi->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-item">
                    <div class="detail-label">Tanggal Reservasi</div>
                    <div class="detail-value">{{ $reservasi->tanggal_reservasi->format('d F Y') }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Tanggal Booking</div>
                    <div class="detail-value">{{ $reservasi->created_at->format('d F Y H:i') }}</div>
                </div>
            </div>

            <div class="wisata-section">
                <h3>🏖️ Destinasi Wisata</h3>
                <p><strong>{{ $reservasi->wisata->nama }}</strong></p>
                <p>{{ $reservasi->wisata->deskripsi }}</p>
                <p style="margin-top: 0.5rem;">
                    <strong>📍 Lokasi:</strong> {{ $reservasi->wisata->lokasi }}<br>
                    <strong>💰 Harga per Orang:</strong> Rp {{ number_format($reservasi->wisata->harga, 0, ',', '.') }}
                </p>
            </div>

            <div class="detail-row">
                <div class="detail-item">
                    <div class="detail-label">Jumlah Orang</div>
                    <div class="detail-value">{{ $reservasi->jumlah_orang }} orang</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Nama Pemesan</div>
                    <div class="detail-value">{{ auth()->user()->name }}</div>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-item">
                    <div class="detail-label">Email</div>
                    <div class="detail-value">{{ auth()->user()->email }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Nomor HP</div>
                    <div class="detail-value">{{ auth()->user()->hp }}</div>
                </div>
            </div>

            @if ($reservasi->catatan)
                <div class="detail-item">
                    <div class="detail-label">Catatan</div>
                    <div class="detail-value">{{ $reservasi->catatan }}</div>
                </div>
            @endif

            <div class="summary-section">
                <div class="summary-row">
                    <span>Harga per Orang:</span>
                    <span>Rp {{ number_format($reservasi->wisata->harga, 0, ',', '.') }}</span>
                </div>
                <div class="summary-row">
                    <span>Jumlah Orang:</span>
                    <span>{{ $reservasi->jumlah_orang }} orang</span>
                </div>
                <div class="summary-row total">
                    <span>Total Harga:</span>
                    <span>Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="btn-group">
                <a href="{{ route('reservasi.index') }}" class="btn btn-secondary">← Kembali</a>
                @if ($reservasi->status === 'pending')
                    <form action="{{ route('reservasi.cancel', $reservasi) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin membatalkan reservasi ini?')">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-danger">Batalkan Reservasi</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
