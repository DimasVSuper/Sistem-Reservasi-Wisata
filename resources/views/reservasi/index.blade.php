<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Reservasi - Sistem Reservasi Wisata</title>
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
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        .page-header h2 {
            color: #333;
        }
        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            transition: transform 0.2s;
            display: inline-block;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .success-msg {
            background: #d4edda;
            color: #155724;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }
        .error-msg {
            background: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }
        .table-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: #f8f9fa;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #ddd;
        }
        td {
            padding: 1rem;
            border-bottom: 1px solid #eee;
        }
        tr:hover {
            background: #f9f9f9;
        }
        .status-badge {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
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
        .btn-small {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            margin-right: 0.5rem;
        }
        .btn-info {
            background: #17a2b8;
        }
        .btn-danger {
            background: #dc3545;
        }
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #666;
        }
        .empty-state h3 {
            margin-bottom: 1rem;
            color: #333;
        }
        nav-breadcrumb {
            margin-bottom: 1.5rem;
        }
        .breadcrumb {
            display: flex;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: #666;
        }
        .breadcrumb a {
            color: #667eea;
            text-decoration: none;
        }
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            background: #333;
            color: white;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            max-width: 400px;
            animation: slideIn 0.3s ease-out;
        }
        .toast-success {
            background: #28a745;
        }
        .toast-error {
            background: #dc3545;
        }
        .toast-close {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0;
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
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 999;
        }
        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            text-align: center;
        }
        .modal-content h3 {
            color: #333;
            margin-bottom: 1rem;
        }
        .modal-content p {
            color: #666;
            margin-bottom: 2rem;
        }
        .modal-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }
        .btn-confirm-yes {
            background: #28a745;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: transform 0.2s;
        }
        .btn-confirm-yes:hover {
            transform: translateY(-2px);
        }
        .btn-confirm-no {
            background: #6c757d;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: transform 0.2s;
        }
        .btn-confirm-no:hover {
            transform: translateY(-2px);
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
        <div class="breadcrumb" style="margin-bottom: 1.5rem;">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span>/</span>
            <span>Reservasi Saya</span>
        </div>

        @if (session('success'))
            <div class="success-msg">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="error-msg">
                {{ session('error') }}
            </div>
        @endif

        <div class="page-header">
            <h2>📋 Reservasi Saya</h2>
            <a href="{{ route('reservasi.create') }}" class="btn">+ Buat Reservasi</a>
        </div>

        @if ($reservasis->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Destinasi Wisata</th>
                            <th>Tanggal</th>
                            <th>Jumlah Orang</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservasis as $index => $reservasi)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $reservasi->wisata->nama }}</td>
                                <td>{{ $reservasi->tanggal_reservasi->format('d/m/Y') }}</td>
                                <td>{{ $reservasi->jumlah_orang }} orang</td>
                                <td>Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    <span class="status-badge status-{{ $reservasi->status }}">
                                        {{ ucfirst($reservasi->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('reservasi.show', $reservasi) }}" class="btn btn-small btn-info">Lihat</a>
                                    @if ($reservasi->status === 'pending')
                                        <button type="button" onclick="ajaxCancel({{ $reservasi->id }})" class="btn btn-small btn-danger">Batalkan</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="table-container">
                <div class="empty-state">
                    <h3>Belum Ada Reservasi</h3>
                    <p>Anda belum memiliki reservasi. <a href="{{ route('reservasi.create') }}" style="color: #667eea;">Buat reservasi sekarang!</a></p>
                </div>
            </div>
        @endif
    </div>

    <script>
        // Toast Notification
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.innerHTML = `<span>${message}</span><button class="toast-close">&times;</button>`;
            document.body.appendChild(toast);
            
            toast.querySelector('.toast-close').addEventListener('click', () => {
                toast.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => toast.remove(), 300);
            });
            
            setTimeout(() => {
                toast.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => toast.remove(), 300);
            }, 4000);
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

        // AJAX Cancel Reservation
        function ajaxCancel(reservasiId) {
            showConfirmDialog('Batalkan Reservasi', 'Apakah Anda yakin ingin membatalkan reservasi ini?', () => {
                fetch(`/reservasi/${reservasiId}/cancel`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('Reservasi berhasil dibatalkan!', 'success');
                        setTimeout(() => location.reload(), 800);
                    } else {
                        showToast(data.message || 'Gagal membatalkan reservasi!', 'error');
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
