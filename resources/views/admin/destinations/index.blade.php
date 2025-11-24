@extends('layouts.admin')

@section('title', 'Daftar Destinasi')
@section('page-title', 'Daftar Destinasi')

@section('content')

<!-- ===== HEADER SECTION ===== -->
<div class="mb-4">
    <div class="row align-items-end gap-3">
        <div class="col-md-2">
            <a 
                href="{{ route('admin.destinations.create') }}" 
                class="btn btn-primary w-100">
                <i class="bi bi-plus-circle"></i> Tambah Destinasi
            </a>
        </div>
    </div>
</div>

<!-- ===== FILTER & SEARCH SECTION ===== -->
<div class="table-container mb-4">
    <form 
        method="GET" 
        action="{{ route('admin.destinations.index') }}" 
        class="row g-3">
        
        <!-- Search Field -->
        <div class="col-md-3">
            <label class="form-label">
                <i class="bi bi-search"></i> Cari Nama/Lokasi
            </label>
            <input 
                type="text" 
                name="search" 
                class="form-control" 
                placeholder="Candi Borobudur..." 
                value="{{ request('search') }}">
        </div>

        <!-- Minimum Price -->
        <div class="col-md-2">
            <label class="form-label">
                <i class="bi bi-tag"></i> Harga Min
            </label>
            <input 
                type="number" 
                name="price_min" 
                class="form-control" 
                placeholder="0" 
                value="{{ request('price_min') }}">
        </div>

        <!-- Maximum Price -->
        <div class="col-md-2">
            <label class="form-label">
                <i class="bi bi-tag"></i> Harga Max
            </label>
            <input 
                type="number" 
                name="price_max" 
                class="form-control" 
                placeholder="1000000" 
                value="{{ request('price_max') }}">
        </div>

        <!-- Rating Filter -->
        <div class="col-md-2">
            <label class="form-label">
                <i class="bi bi-star"></i> Rating Min
            </label>
            <select name="rating" class="form-select">
                <option value="">-- Semua --</option>
                <option 
                    value="4" 
                    @if(request('rating') == 4) selected @endif>
                    ⭐ 4 ke atas
                </option>
                <option 
                    value="4.5" 
                    @if(request('rating') == 4.5) selected @endif>
                    ⭐ 4.5 ke atas
                </option>
                <option 
                    value="5" 
                    @if(request('rating') == 5) selected @endif>
                    ⭐ 5 (Sempurna)
                </option>
            </select>
        </div>

        <!-- Sort By -->
        <div class="col-md-2">
            <label class="form-label">
                <i class="bi bi-arrow-down-up"></i> Urutkan
            </label>
            <select name="sort_by" class="form-select">
                <option 
                    value="name" 
                    @if(request('sort_by') == 'name') selected @endif>
                    Nama
                </option>
                <option 
                    value="price" 
                    @if(request('sort_by') == 'price') selected @endif>
                    Harga
                </option>
                <option 
                    value="rating" 
                    @if(request('sort_by') == 'rating') selected @endif>
                    Rating
                </option>
                <option 
                    value="total_visitors" 
                    @if(request('sort_by') == 'total_visitors') selected @endif>
                    Pengunjung
                </option>
                <option 
                    value="created_at" 
                    @if(request('sort_by') == 'created_at') selected @endif>
                    Terbaru
                </option>
            </select>
        </div>

        <!-- Sort Order -->
        <div class="col-md-1">
            <label class="form-label">&nbsp;</label>
            <select name="sort_order" class="form-select">
                <option 
                    value="asc" 
                    @if(request('sort_order') == 'asc') selected @endif>
                    ↑ Naik
                </option>
                <option 
                    value="desc" 
                    @if(request('sort_order') == 'desc') selected @endif>
                    ↓ Turun
                </option>
            </select>
        </div>

        <!-- Action Buttons & Summary -->
        <div class="col-12">
            <button 
                type="submit" 
                class="btn btn-success me-2">
                <i class="bi bi-search"></i> Filter & Cari
            </button>
            <a 
                href="{{ route('admin.destinations.index') }}" 
                class="btn btn-secondary">
                <i class="bi bi-arrow-clockwise"></i> Reset
            </a>
            <span class="text-muted ms-3">
                Menampilkan <strong>{{ $destinations->count() }}</strong> dari 
                <strong>{{ $destinations->total() }}</strong> destinasi
            </span>
        </div>
    </form>
</div>

<!-- ===== DATA TABLE SECTION ===== -->
<div class="table-container">
    @if($destinations->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                
                <!-- Table Header -->
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 10%;">Gambar</th>
                        <th style="width: 20%;">Nama</th>
                        <th style="width: 15%;">Lokasi</th>
                        <th style="width: 12%;">Harga</th>
                        <th style="width: 8%;">Rating</th>
                        <th style="width: 10%;">Pengunjung</th>
                        <th style="width: 20%;">Aksi</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody>
                    @forelse($destinations as $index => $dest)
                        <tr>
                            <!-- No Column -->
                            <td>
                                {{ ($destinations->currentPage() - 1) * $destinations->perPage() + $loop->iteration }}
                            </td>

                            <!-- Image Column -->
                            <td>
                                <img 
                                    src="{{ $dest->image_url }}" 
                                    alt="{{ $dest->name }}" 
                                    style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                            </td>

                            <!-- Destination Info -->
                            <td>{{ $dest->name }}</td>
                            <td>{{ $dest->location }}</td>
                            <td>Rp {{ number_format($dest->price, 0, ',', '.') }}</td>

                            <!-- Rating Badge -->
                            <td>
                                <span class="badge bg-warning">
                                    <i class="bi bi-star-fill"></i> {{ $dest->rating ?? 0 }}
                                </span>
                            </td>

                            <!-- Visitors Count -->
                            <td>{{ $dest->total_visitors }}</td>

                            <!-- Action Buttons -->
                            <td>
                                <a 
                                    href="{{ route('admin.destinations.show', $dest) }}" 
                                    class="btn btn-sm btn-info btn-action"
                                    title="Lihat Detail">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                                
                                <a 
                                    href="{{ route('admin.destinations.edit', $dest) }}" 
                                    class="btn btn-sm btn-warning btn-action"
                                    title="Edit Destinasi">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                
                                <form 
                                    action="{{ route('admin.destinations.destroy', $dest) }}" 
                                    method="POST" 
                                    class="d-inline" 
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit" 
                                        class="btn btn-sm btn-danger btn-action"
                                        title="Hapus Destinasi">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i 
                                    class="bi bi-inbox" 
                                    style="font-size: 2rem; color: #bdc3c7;">
                                </i>
                                <p class="text-muted mt-2">Tidak ada destinasi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Section -->
        <nav class="mt-4">
            {{ $destinations->links('pagination::bootstrap-5') }}
        </nav>

    @else
        <!-- Empty State Section -->
        <div class="text-center py-5">
            <i 
                class="bi bi-inbox" 
                style="font-size: 3rem; color: #bdc3c7;">
            </i>
            <p class="text-muted mt-3">
                Belum ada destinasi. 
                <a href="{{ route('admin.destinations.create') }}">
                    Tambah sekarang
                </a>
            </p>
        </div>
    @endif
</div>

@endsection
