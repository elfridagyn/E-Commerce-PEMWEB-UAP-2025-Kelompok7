@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Toko</h2>

    <form action="{{ route('store.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Nama Toko:</label>
        <input type="text" name="name" required>

        <label>Logo Toko:</label>
        <input type="file" name="logo">

        <label>Deskripsi / Tentang Toko:</label>
        <textarea name="about" required></textarea>

        <button type="submit">Daftarkan Toko</button>
    </form>
</div>
@endsection
