@extends('layouts.admin')

@section('title', 'Riwayat Status - ' . $reservation->customer_name)
@section('page-title', 'Riwayat Perubahan Status')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.reservations.show', $reservation) }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="table-container">
    <div class="row mb-4">
        <div class="col-md-8">
            <div style="background: #f8f9fa; padding: 20px; border-radius: 10px;">
                <h6 class="mb-2"><strong>Reservasi:</strong> {{ $reservation->customer_name }}</h6>
                <p class="mb-1"><strong>Email:</strong> {{ $reservation->customer_email }}</p>
                <p class="mb-1"><strong>Destinasi:</strong> {{ $reservation->destination->name }}</p>
                <p class="mb-1"><strong>Tanggal:</strong> {{ $reservation->reservation_date->format('d M Y') }}</p>
                <p class="mb-0">
                    <strong>Status Saat Ini:</strong>
                    @if($reservation->status === 'pending')
                        <span class="badge bg-warning">⏳ Pending</span>
                    @elseif($reservation->status === 'confirmed')
                        <span class="badge bg-success">✓ Terkonfirmasi</span>
                    @elseif($reservation->status === 'completed')
                        <span class="badge bg-primary">✓ Selesai</span>
                    @else
                        <span class="badge bg-danger">✗ Dibatalkan</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    @if($histories->count() > 0)
        <div class="timeline">
            @foreach($histories as $index => $history)
                <div class="timeline-item" style="margin-bottom: 30px; padding-left: 40px; position: relative;">
                    <!-- Timeline dot -->
                    <div style="position: absolute; left: 0; top: 5px; width: 20px; height: 20px; background: #3498db; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 0 2px #3498db;"></div>

                    <!-- Timeline line -->
                    @if(!$loop->last)
                        <div style="position: absolute; left: 8px; top: 25px; width: 2px; height: 50px; background: #ecf0f1;"></div>
                    @endif

                    <!-- Content -->
                    <div style="background: white; border: 1px solid #ecf0f1; border-radius: 8px; padding: 15px;">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-2">
                                    @if($history->old_status)
                                        <span class="badge bg-light text-dark" style="font-size: 12px;">{{ strtoupper($history->old_status) }}</span>
                                    @else
                                        <span class="badge bg-secondary" style="font-size: 12px;">AWAL</span>
                                    @endif
                                    
                                    <i class="bi bi-arrow-right" style="color: #95a5a6; margin: 0 10px;"></i>
                                    
                                    <span class="badge bg-primary" style="font-size: 12px;">{{ strtoupper($history->new_status) }}</span>
                                </h6>
                            </div>
                            <div class="col-md-6 text-end">
                                <small class="text-muted">
                                    <i class="bi bi-calendar"></i> {{ $history->created_at->format('d M Y H:i') }}
                                </small>
                            </div>
                        </div>

                        <hr style="margin: 10px 0;">

                        <div class="row" style="font-size: 14px;">
                            <div class="col-md-6">
                                <p class="mb-1">
                                    <strong>Diubah oleh:</strong> {{ $history->changed_by ?? 'System' }}
                                </p>
                            </div>
                            @if($history->reason)
                                <div class="col-md-6">
                                    <p class="mb-1">
                                        <strong>Alasan:</strong> {{ $history->reason }}
                                    </p>
                                </div>
                            @endif
                        </div>

                        @if($history->notes)
                            <div style="background: #f8f9fa; padding: 10px; border-radius: 5px; margin-top: 10px; border-left: 3px solid #3498db;">
                                <strong>Catatan:</strong> {{ $history->notes }}
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-inbox" style="font-size: 3rem; color: #bdc3c7;"></i>
            <p class="text-muted mt-3">Belum ada perubahan status untuk reservasi ini</p>
        </div>
    @endif
</div>

<style>
    .timeline {
        position: relative;
    }

    .timeline-item:hover {
        background: #f8f9fa;
        border-radius: 8px;
        padding-left: 40px;
        margin-left: -20px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }
</style>

@endsection
