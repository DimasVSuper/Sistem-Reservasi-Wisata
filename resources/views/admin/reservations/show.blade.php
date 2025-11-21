@extends('layouts.admin')

@section('title', 'Detail Reservasi')
@section('page-title', 'Detail Reservasi')

@section('content')
<div class="table-container">
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-3">Data Customer</h5>
                    <div class="mb-3">
                        <label class="text-muted">Nama</label>
                        <p class="fw-bold">{{ $reservation->customer_name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Email</label>
                        <p>{{ $reservation->customer_email }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Nomor Telepon</label>
                        <p>{{ $reservation->customer_phone }}</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <h5 class="mb-3">Data Reservasi</h5>
                    <div class="mb-3">
                        <label class="text-muted">Destinasi</label>
                        <p class="fw-bold">{{ $reservation->destination->name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Tanggal Reservasi</label>
                        <p>{{ $reservation->reservation_date->format('d M Y') }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Jumlah Orang</label>
                        <p>{{ $reservation->quantity }} orang</p>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="text-muted">Harga Per Orang</label>
                        <p>Rp {{ number_format($reservation->destination->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Total Harga</label>
                        <p class="h5 text-success fw-bold">Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="text-muted">Status</label>
                        <p>
                            @if($reservation->status === 'pending')
                                <span class="badge bg-warning">⏳ Pending</span>
                            @elseif($reservation->status === 'confirmed')
                                <span class="badge bg-success">✓ Terkonfirmasi</span>
                            @else
                                <span class="badge bg-danger">✗ Dibatalkan</span>
                            @endif
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Tanggal Dibuat</label>
                        <p>{{ $reservation->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>

            @if($reservation->notes)
                <hr>
                <div class="mb-3">
                    <label class="text-muted">Catatan</label>
                    <p>{{ $reservation->notes }}</p>
                </div>
            @endif
        </div>

        <div class="col-md-4">
            <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; border-left: 4px solid #3498db;">
                <h6 class="mb-3"><i class="bi bi-lightning"></i> <strong>Quick Actions</strong></h6>

                @if($reservation->status !== 'confirmed')
                    <form action="{{ route('admin.reservations.changeStatus', $reservation) }}" method="POST" class="mb-2">
                        @csrf
                        <input type="hidden" name="status" value="confirmed">
                        <button type="submit" class="btn btn-sm btn-success w-100 mb-2">
                            <i class="bi bi-check"></i> Konfirmasi
                        </button>
                    </form>
                @endif

                @if($reservation->status !== 'cancelled')
                    <button type="button" class="btn btn-sm btn-danger w-100" data-bs-toggle="modal" data-bs-target="#cancelModal">
                        <i class="bi bi-x-circle"></i> Batalkan
                    </button>
                @endif

                <hr style="margin: 15px 0;">

                <a href="{{ route('admin.reservations.statusHistory', $reservation) }}" class="btn btn-sm btn-secondary w-100">
                    <i class="bi bi-clock-history"></i> Lihat Riwayat
                </a>
            </div>
        </div>
    </div>

    <hr>

    <a href="{{ route('admin.reservations.edit', $reservation) }}" class="btn btn-warning">
        <i class="bi bi-pencil"></i> Edit
    </a>
    <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<!-- Modal Cancel -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Batalkan Reservasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.reservations.changeStatus', $reservation) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="status" value="cancelled">
                    <div class="mb-3">
                        <label class="form-label"><strong>Alasan Pembatalan</strong></label>
                        <textarea name="reason" class="form-control" rows="3" placeholder="Jelaskan alasan pembatalan..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Batalkan Reservasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
