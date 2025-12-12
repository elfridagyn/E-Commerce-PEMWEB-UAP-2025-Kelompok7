{{-- resources/views/admin/kategori/create.blade.php --}}

@extends('layouts.base') {{-- Mengambil layout dasar --}}

@section('title', 'Tambah Kategori Produk')

@section('content')
    
    <a href="{{ route('admin.categories.index') }}" class="back-to-dashboard mb-4">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Daftar Kategori</span>
    </a>
    
    <div class="title-box">
        <i class="fas fa-plus-circle"></i>
        <h2>Tambah Kategori Baru</h2>
        <p>Masukkan nama kategori produk yang ingin Anda tambahkan.</p>
    </div>

    <div class="table-box">
        {{-- Form untuk mengirim data ke CategoryController@store --}}
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf 

            <div class="mb-3">
                <label for="category_name" class="form-label" style="font-weight: 600; color: #6b2b38;">Nama Kategori</label>
                {{-- Style inline ditambahkan agar sesuai dengan tampilan input Anda --}}
                <input type="text" class="form-control" 
                       style="padding: 10px; border-radius: 8px; border: 1px solid #ccc; width: 100%; box-sizing: border-box;"
                       id="category_name" name="category_name" 
                       value="{{ old('category_name') }}" required>
                
                {{-- Menampilkan error validasi dari Laravel --}}
                @error('category_name')
                    <div style="color: #dc3545; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary" style="background-color: #5cb85c;">
                    <i class="fas fa-save"></i> Simpan Kategori
                </button>
            </div>
        </form>
    </div>

@endsection