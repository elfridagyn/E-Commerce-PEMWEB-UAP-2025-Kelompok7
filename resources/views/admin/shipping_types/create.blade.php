@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Tambah Metode Pengiriman</h2>

    <form action="{{ route('shipping_types.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label class="form-label">Nama Pengiriman</label>
            <input type="text" name="name" class="form-control" required>
            @error('name')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Biaya (Rp)</label>
            <input type="number" name="cost" class="form-control" required>
            @error('cost')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('shipping_types.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
