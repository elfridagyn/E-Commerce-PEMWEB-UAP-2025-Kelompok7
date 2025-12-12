@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Edit Kategori: {{ $category->category_name }}</h2>

        {{-- Kembali ke daftar --}}
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary mb-3">
            &larr; Kembali ke Daftar Kategori
        </a>

        {{-- Form untuk mengirim data ke CategoryController@update --}}
        {{-- Menggunakan method POST, tapi disisipkan @method('PUT') --}}
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT') 

            <div class="mb-3">
                <label for="category_name" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control @error('category_name') is-invalid @enderror" 
                       id="category_name" name="category_name" 
                       value="{{ old('category_name', $category->category_name) }}" required>
                
                @error('category_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Contoh Tambahan: Mengubah Status --}}
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" 
                       value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Kategori Aktif (Dapat Dilihat Pembeli)</label>
            </div>


            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        </form>
    </div>
@endsection