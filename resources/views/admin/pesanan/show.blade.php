<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Admin</title>
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
        .section {
            background: #f9f9ff;
            padding: 1.5rem;
            border-radius: 4px;
            border-left: 4px solid #ff6b6b;
            margin: 2rem 0;
        }
        .section h3 {
            color: #333;
            margin-bottom: 1rem;
        }
        .section p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 0.5rem;
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
            color: #ff6b6b;
        }
        .btn-group {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: transform 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            transform: translateY(-2px);
        }
        .btn-confirm {
            background: #28a745;
            color: white;
        }
        .btn-confirm:hover {
            transform: translateY(-2px);
        }
        .btn-cancel {
            background: #dc3545;
            color: white;
        }
        .btn-cancel:hover {
            transform: translateY(-2px);
        }
        .success-msg {
            background: #d4edda;
            color: #155724;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }
        /* Toast & Modal */
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: white;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 1rem;
            z-index: 9999;
            animation: slideIn 0.3s ease-out;
        }
        .toast-success {
            border-left: 4px solid #28a745;
            background: #d4edda;
            color: #155724;
        }
        .toast-error {
            border-left: 4px solid #dc3545;
            background: #f8d7da;
            color: #721c24;
        }
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
        }
        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 90%;
        }
        .modal-content h3 {
            color: #333;
            margin-bottom: 1rem;
        }
        .modal-buttons {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }
        .btn-confirm-yes, .btn-confirm-no {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
        }
        .btn-confirm-yes {
            background: #28a745;
            color: white;
        }
        .btn-confirm-no {
            background: #6c757d;
            color: white;
        }
        @keyframes slideIn {
            from { transform: translateX(400px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
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
            <a href="{{ route('admin.pesanan.index') }}">Pesanan</a>
            <span>/</span>
            <span>Detail Pesanan</span>
        </div>

        @if (session('success'))
            <div class="success-msg">
                {{ session('success') }}
            </div>
        @endif

        <h1>📋 Detail Pesanan</h1>

        <div class="detail-container">
            <div class="detail-row">
                <div class="detail-item">
                    <div class="detail-label">Nomor Pesanan</div>
                    <div class="detail-value">#{{ str_pad($pesanan->id, 6, '0', STR_PAD_LEFT) }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">
                        <span class="status-badge status-{{ $pesanan->status }}">
                            {{ ucfirst($pesanan->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="section">
                <h3>👤 Informasi Customer</h3>
                <p><strong>Nama:</strong> {{ $pesanan->user->name }}</p>
                <p><strong>Email:</strong> {{ $pesanan->user->email }}</p>
                <p><strong>No. HP:</strong> {{ $pesanan->user->hp }}</p>
            </div>

            <div class="section">
                <h3>🏖️ Destinasi Wisata</h3>
                <p><strong>Nama:</strong> {{ $pesanan->wisata->nama }}</p>
                <p><strong>Lokasi:</strong> {{ $pesanan->wisata->lokasi }}</p>
                <p><strong>Deskripsi:</strong> {{ $pesanan->wisata->deskripsi }}</p>
            </div>

            <div class="detail-row">
                <div class="detail-item">
                    <div class="detail-label">Tanggal Reservasi</div>
                    <div class="detail-value">{{ $pesanan->tanggal_reservasi->format('d F Y') }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Tanggal Pemesanan</div>
                    <div class="detail-value">{{ $pesanan->created_at->format('d F Y H:i') }}</div>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-item">
                    <div class="detail-label">Jumlah Orang</div>
                    <div class="detail-value">{{ $pesanan->jumlah_orang }} orang</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Harga per Orang</div>
                    <div class="detail-value">Rp {{ number_format($pesanan->wisata->harga, 0, ',', '.') }}</div>
                </div>
            </div>

            @if ($pesanan->catatan)
                <div class="detail-item">
                    <div class="detail-label">Catatan Pesanan</div>
                    <div class="detail-value">{{ $pesanan->catatan }}</div>
                </div>
            @endif

            <div class="summary-section">
                <div class="summary-row">
                    <span>Harga per Orang:</span>
                    <span>Rp {{ number_format($pesanan->wisata->harga, 0, ',', '.') }}</span>
                </div>
                <div class="summary-row">
                    <span>Jumlah Orang:</span>
                    <span>{{ $pesanan->jumlah_orang }} orang</span>
                </div>
                <div class="summary-row total">
                    <span>Total Harga:</span>
                    <span>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="btn-group">
                <a href="{{ route('admin.pesanan.index') }}" class="btn btn-secondary">← Kembali</a>
                
                @if ($pesanan->status === 'pending')
                    <button type="button" onclick="ajaxUpdateStatus({{ $pesanan->id }}, 'dikonfirmasi')" class="btn btn-confirm">✓ Konfirmasi Pesanan</button>
                    <button type="button" onclick="ajaxUpdateStatus({{ $pesanan->id }}, 'dibatalkan')" class="btn btn-cancel">✗ Batalkan Pesanan</button>
                @endif
            </div>
        </div>
    </div>

    <script>
        const pesananId = {{ $pesanan->id }};

        // Toast Notification
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.innerHTML = `<span>${message}</span>`;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Confirm Dialog
        function showConfirmDialog(title, message, onConfirm) {
            const modal = document.createElement('div');
            modal.className = 'modal-overlay';
            modal.innerHTML = `
                <div class="modal-content">
                    <h3>${title}</h3>
                    <p>${message}</p>
                    <div class="modal-buttons">
                        <button class="btn-confirm-yes">Ya, Lanjutkan</button>
                        <button class="btn-confirm-no">Batal</button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            
            modal.querySelector('.btn-confirm-yes').addEventListener('click', () => {
                modal.remove();
                onConfirm();
            });
            
            modal.querySelector('.btn-confirm-no').addEventListener('click', () => {
                modal.remove();
            });
        }

        // AJAX Update Status
        function ajaxUpdateStatus(pesananId, newStatus) {
            const statusText = newStatus === 'dikonfirmasi' ? 'Konfirmasi' : 'Batalkan';
            const message = newStatus === 'dikonfirmasi' 
                ? 'Apakah Anda yakin ingin mengkonfirmasi pesanan ini?' 
                : 'Apakah Anda yakin ingin membatalkan pesanan ini?';

            showConfirmDialog(`${statusText} Pesanan`, message, () => {
                fetch(`/admin/pesanan/${pesananId}/status/${newStatus}`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast(`Pesanan berhasil di${statusText.toLowerCase()}!`, 'success');
                        setTimeout(() => location.reload(), 800);
                    } else {
                        showToast(data.message || 'Gagal!', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Terjadi kesalahan!', 'error');
                });
            });
        }
    </script>
</body>
</html>
