<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Destinasi - Admin</title>
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
            max-width: 800px;
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
            color: #ff6b6b;
            text-decoration: none;
        }
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        h1 {
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
            border-color: #ff6b6b;
            box-shadow: 0 0 5px rgba(255, 107, 107, 0.3);
        }
        textarea {
            resize: vertical;
            min-height: 100px;
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
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
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
            <a href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
            <span>/</span>
            <a href="{{ route('admin.destinasi.index') }}">Kelola Destinasi</a>
            <span>/</span>
            <span>Edit Destinasi</span>
        </div>

        <h1>✏️ Edit Destinasi Wisata</h1>

        @if ($errors->any())
            <div class="alert">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="form-container">
            <form action="{{ route('admin.destinasi.update', $destinasi) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nama">Nama Destinasi</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $destinasi->nama) }}" required>
                    @error('nama')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" required>{{ old('deskripsi', $destinasi->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi', $destinasi->lokasi) }}" required>
                        @error('lokasi')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="harga">Harga per Orang (Rp)</label>
                        <input type="number" name="harga" id="harga" value="{{ old('harga', $destinasi->harga) }}" min="1000" step="1000" required>
                        @error('harga')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="kapasitas">Kapasitas (Jumlah Orang)</label>
                        <input type="number" name="kapasitas" id="kapasitas" value="{{ old('kapasitas', $destinasi->kapasitas) }}" min="1" required>
                        @error('kapasitas')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" required>
                            <option value="tersedia" @if(old('status', $destinasi->status) === 'tersedia') selected @endif>Tersedia</option>
                            <option value="penuh" @if(old('status', $destinasi->status) === 'penuh') selected @endif>Penuh</option>
                        </select>
                        @error('status')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.destinasi.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
