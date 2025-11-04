<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Reservasi - Sistem Reservasi Wisata</title>
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
        .form-container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
            font-weight: 500;
        }
        input, select, textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.3s;
            font-family: inherit;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
        }
        textarea {
            resize: vertical;
            min-height: 80px;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        .form-row .form-group {
            margin-bottom: 0;
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
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            transform: translateY(-2px);
        }
        .error {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }
        .alert {
            background: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }
        .wisata-card {
            border: 1px solid #ddd;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 0.5rem;
            cursor: pointer;
            transition: all 0.3s;
        }
        .wisata-card:hover {
            border-color: #667eea;
            background: #f9f9ff;
        }
        .wisata-card input[type="radio"] {
            width: auto;
            margin-right: 1rem;
        }
        .wisata-info {
            display: inline-block;
        }
        .wisata-name {
            font-weight: 600;
            color: #333;
        }
        .wisata-details {
            font-size: 0.9rem;
            color: #666;
            margin-top: 0.25rem;
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
            <span>Buat Reservasi</span>
        </div>

        <h2>📝 Buat Reservasi Baru</h2>

        @if ($errors->any())
            <div class="alert">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="form-container">
            <form action="{{ route('reservasi.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Pilih Destinasi Wisata</label>
                    @foreach ($wisatas as $wisata)
                        <label class="wisata-card">
                            <input type="radio" name="wisata_id" value="{{ $wisata->id }}" required 
                                @if (old('wisata_id') == $wisata->id) checked @endif>
                            <div class="wisata-info">
                                <div class="wisata-name">{{ $wisata->nama }}</div>
                                <div class="wisata-details">
                                    📍 {{ $wisata->lokasi }} • 💰 Rp {{ number_format($wisata->harga, 0, ',', '.') }}/orang
                                </div>
                                <div class="wisata-details">{{ substr($wisata->deskripsi, 0, 100) }}...</div>
                            </div>
                        </label>
                    @endforeach
                    @error('wisata_id')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="tanggal_reservasi">Tanggal Reservasi</label>
                        <input type="date" name="tanggal_reservasi" id="tanggal_reservasi" 
                            value="{{ old('tanggal_reservasi') }}" required>
                        @error('tanggal_reservasi')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="jumlah_orang">Jumlah Orang</label>
                        <input type="number" name="jumlah_orang" id="jumlah_orang" 
                            value="{{ old('jumlah_orang') }}" min="1" required>
                        @error('jumlah_orang')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="catatan">Catatan (Opsional)</label>
                    <textarea name="catatan" id="catatan" placeholder="Tambahkan catatan khusus untuk reservasi Anda...">{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Buat Reservasi</button>
                    <a href="{{ route('reservasi.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Set minimum date ke besok
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);
        
        const dateInput = document.getElementById('tanggal_reservasi');
        dateInput.min = tomorrow.toISOString().split('T')[0];
    </script>
</body>
</html>
