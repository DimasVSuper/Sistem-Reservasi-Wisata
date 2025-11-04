<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Destinasi - Admin</title>
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
            max-width: 1200px;
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
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        .page-header h1 {
            color: #333;
        }
        .btn {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
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
        .btn-small {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            margin-right: 0.5rem;
        }
        .btn-edit {
            background: #4c72b0;
        }
        .btn-delete {
            background: #dc3545;
        }
        .success-msg {
            background: #d4edda;
            color: #155724;
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
        .status-tersedia {
            background: #d4edda;
            color: #155724;
        }
        .status-penuh {
            background: #f8d7da;
            color: #721c24;
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
        /* Toast Notifications */
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
        .toast-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: inherit;
            padding: 0;
            margin-left: 0.5rem;
            opacity: 0.7;
        }
        @keyframes slideIn {
            from { transform: translateX(400px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        /* Confirm Modal */
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
        .modal-content p {
            color: #666;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }
        .modal-buttons {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }
        .btn-confirm-yes,
        .btn-confirm-no {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
        }
        .btn-confirm-yes {
            background: #dc3545;
            color: white;
        }
        .btn-confirm-no {
            background: #6c757d;
            color: white;
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
            <span>Kelola Destinasi</span>
        </div>

        @if (session('success'))
            <div class="success-msg">
                {{ session('success') }}
            </div>
        @endif

        <div class="page-header">
            <h1>🏖️ Kelola Destinasi Wisata</h1>
            <a href="{{ route('admin.destinasi.create') }}" class="btn">+ Tambah Destinasi</a>
        </div>

        @if ($destinasis->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Destinasi</th>
                            <th>Lokasi</th>
                            <th>Harga</th>
                            <th>Kapasitas</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($destinasis as $index => $destinasi)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $destinasi->nama }}</strong></td>
                                <td>{{ $destinasi->lokasi }}</td>
                                <td>Rp {{ number_format($destinasi->harga, 0, ',', '.') }}</td>
                                <td>{{ $destinasi->kapasitas }} orang</td>
                                <td>
                                    <span class="status-badge status-{{ $destinasi->status }}">
                                        {{ ucfirst($destinasi->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.destinasi.edit', $destinasi) }}" class="btn btn-small btn-edit">Edit</a>
                                    <button type="button" class="btn btn-small btn-delete" onclick="ajaxDelete({{ $destinasi->id }})">Hapus</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="table-container">
                <div class="empty-state">
                    <h3>Belum Ada Destinasi</h3>
                    <p>Tidak ada destinasi wisata yang terdaftar. <a href="{{ route('admin.destinasi.create') }}" style="color: #ff6b6b;">Tambah destinasi sekarang!</a></p>
                </div>
            </div>
        @endif
    </div>

    <script>
        // Toast Notification
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.innerHTML = `
                <span>${message}</span>
                <button class="toast-close">&times;</button>
            `;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => toast.remove(), 300);
            }, 4000);
            
            toast.querySelector('.toast-close').addEventListener('click', () => {
                toast.style.animation = 'slideOut 0.3s ease-out';
                setTimeout(() => toast.remove(), 300);
            });
        }

        // Confirm Modal
        function showConfirmDialog(title, message, onConfirm, onCancel) {
            const modal = document.createElement('div');
            modal.className = 'modal-overlay';
            modal.innerHTML = `
                <div class="modal-content">
                    <h3>${title}</h3>
                    <p>${message}</p>
                    <div class="modal-buttons">
                        <button class="btn-confirm-yes">Ya, Hapus</button>
                        <button class="btn-confirm-no">Batal</button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            
            const yesBtn = modal.querySelector('.btn-confirm-yes');
            const noBtn = modal.querySelector('.btn-confirm-no');
            
            yesBtn.addEventListener('click', () => {
                modal.remove();
                onConfirm();
            });
            
            noBtn.addEventListener('click', () => {
                modal.remove();
                if (onCancel) onCancel();
            });
        }

        // AJAX Delete
        function ajaxDelete(destinasiId) {
            showConfirmDialog(
                'Hapus Destinasi',
                'Apakah Anda yakin ingin menghapus destinasi ini? Tindakan ini tidak dapat dibatalkan.',
                () => {
                    fetch(`/admin/destinasi/${destinasiId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast('Destinasi berhasil dihapus!', 'success');
                            setTimeout(() => location.reload(), 800);
                        } else {
                            showToast(data.message || 'Gagal menghapus!', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('Terjadi kesalahan!', 'error');
                    });
                }
            );
        }
    </script>
</body>
</html>
