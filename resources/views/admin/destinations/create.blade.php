@extends('layouts.admin')

@section('title', 'Tambah Destinasi')
@section('page-title', 'Tambah Destinasi Baru')

@section('content')

<!-- ===== FORM CONTAINER ===== -->
<div class="form-container">
    <form 
        action="{{ route('admin.destinations.store') }}" 
        method="POST">
        @csrf

        <!-- ===== ROW 1: NAME & LOCATION ===== -->
        <div class="row">
            <!-- Name Field -->
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="name">
                        Nama Destinasi <span class="text-danger">*</span>
                    </label>
                    <input 
                        type="text" 
                        class="form-control @error('name') is-invalid @enderror" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Location Field -->
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="location">
                        Lokasi <span class="text-danger">*</span>
                    </label>
                    <input 
                        type="text" 
                        class="form-control @error('location') is-invalid @enderror" 
                        id="location" 
                        name="location" 
                        value="{{ old('location') }}" 
                        required>
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- ===== ROW 2: PRICE & RATING ===== -->
        <div class="row">
            <!-- Price Field -->
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="price">
                        Harga (Rp) <span class="text-danger">*</span>
                    </label>
                    <input 
                        type="number" 
                        class="form-control @error('price') is-invalid @enderror" 
                        id="price" 
                        name="price" 
                        value="{{ old('price') }}" 
                        step="0.01" 
                        required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Rating Field -->
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="rating">
                        Rating (0-5)
                    </label>
                    <input 
                        type="number" 
                        class="form-control @error('rating') is-invalid @enderror" 
                        id="rating" 
                        name="rating" 
                        value="{{ old('rating', 0) }}" 
                        step="0.01" 
                        min="0" 
                        max="5">
                    @error('rating')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- ===== IMAGE URL FIELD ===== -->
        <div class="form-group mb-3">
            <label for="image_url">
                URL Gambar
            </label>
            <input 
                type="url" 
                class="form-control @error('image_url') is-invalid @enderror" 
                id="image_url" 
                name="image_url" 
                value="{{ old('image_url') }}">
            @error('image_url')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- ===== DESCRIPTION FIELD ===== -->
        <div class="form-group mb-3">
            <label for="description">
                Deskripsi <span class="text-danger">*</span>
            </label>
            <textarea 
                class="form-control @error('description') is-invalid @enderror" 
                id="description" 
                name="description" 
                rows="5" 
                required>{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- ===== ACTION BUTTONS ===== -->
        <div class="form-group">
            <button 
                type="submit" 
                class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Simpan
            </button>
            <a 
                href="{{ route('admin.destinations.index') }}" 
                class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
        </div>
    </form>
</div>

@endsection
