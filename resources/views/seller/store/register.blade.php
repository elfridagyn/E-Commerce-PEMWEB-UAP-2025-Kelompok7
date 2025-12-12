@extends('layouts.seller')

@section('title', 'Daftar Toko')

@section('content')

{{-- Import Poppins dan Font Awesome --}}
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<style>
/* --- GLOBAL STYLES --- */
html, body {
    width: 100%;
    margin: 0;
    padding: 0;
    overflow-x: hidden;
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #f3b8c8, #e38fa2, #d86e82);
    min-height: 100vh;
}

/* --- NAVBAR --- */
.top-navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 40px;
    margin-bottom: 30px;
}

.back-to-dashboard {
    display: flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    background: rgba(255,255,255,0.35);
    backdrop-filter: blur(10px);
    padding: 10px 18px;
    border-radius: 30px;
    color: #6b2b38;
    font-weight: 600;
    box-shadow: 0px 4px 12px rgba(0,0,0,0.15);
}

.user-info {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(255,255,255,0.35);
    padding: 10px 18px;
    border-radius: 30px;
    box-shadow: 0px 4px 12px rgba(0,0,0,0.15);
    color: #6b2b38;
}

.avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #d27d8f;
}

/* --- CONTAINER & TITLE --- */
.container {
    width: min(650px, calc(100% - 40px));
    margin: 0 auto;
    padding: 0 20px;
}

.title-box {
    background: rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(18px);
    padding: 30px;
    border-radius: 25px;
    box-shadow: 0 10px 35px rgba(0,0,0,0.15);
    text-align: center;
    margin-bottom: 30px;
}

.title-box i {
    font-size: 3rem;
    color: #6b2b38;
}

.title-box h2 {
    margin-top: 12px;
    font-size: 2rem;
    font-weight: 700;
    color: #6b2b38;
}

/* --- CARD & FORM --- */
.card-box {
    background: rgba(255,255,255,0.35);
    backdrop-filter: blur(18px);
    padding: 30px;
    border-radius: 25px;
    box-shadow: 0 10px 35px rgba(0,0,0,0.15);
}

label {
    display: block;
    margin-top: 15px;
    font-weight: 600;
    color: #6b2b38;
}

input[type="text"],
input[type="file"],
textarea {
    width: 100%;
    padding: 12px 14px;
    margin-top: 6px;
    border-radius: 12px;
    border: none;
    box-sizing: border-box;
    background-color: white;
}

textarea { resize: vertical; }

.btn-primary {
    margin-top: 25px;
    background: #c96a7f;
    color: white;
    padding: 12px 26px;
    border-radius: 25px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    width: 100%;
    transition: .2s;
}

.btn-primary:hover {
    background: #a44c61;
}

.alert-success {
    background: rgba(46,204,113,0.25);
    color: #145a32;
    padding: 14px;
    border-radius: 12px;
    margin-bottom: 20px;
}

.error-text {
    color: #e74c3c;
    font-size: 0.85rem;
    margin-top: 3px;
}
</style>

{{-- NAVBAR --}}
<div class="top-navbar">
    <a href="{{ route('member.home') }}" class="back-to-dashboard">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
    <div class="nav-right">
        <div class="user-info">
            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" class="avatar">
            <span>{{ auth()->user()->name }}</span>
        </div>
    </div>
</div>

<div class="container">

    <div class="title-box">
        <i class="fas fa-store"></i>
        <h2>Daftar Toko</h2>
        <p class="text-[#6b2b38]">Buat tokomu sekarang dan mulai jual produkmu!</p>
    </div>

    <div class="card-box">
        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('seller.store.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label>Nama Toko</label>
            <input type="text" name="store_name" value="{{ old('store_name') }}" required>
            @error('store_name') <div class="error-text">{{ $message }}</div> @enderror

            <label>Logo Toko</label>
            <input type="file" name="logo" class="bg-white">
            @error('logo') <div class="error-text">{{ $message }}</div> @enderror

            <label>Deskripsi / Tentang Toko</label>
            <textarea name="description" required>{{ old('description') }}</textarea>
            @error('description') <div class="error-text">{{ $message }}</div> @enderror

            <label>Telepon</label>
            <input type="text" name="phone" value="{{ old('phone') }}">
            @error('phone') <div class="error-text">{{ $message }}</div> @enderror

            <label>Alamat</label>
            <textarea name="address">{{ old('address') }}</textarea>
            @error('address') <div class="error-text">{{ $message }}</div> @enderror

            <hr style="margin:25px 0; border:1px solid rgba(107,43,56,0.2);">

            <h3 style="color:#6b2b38; margin-bottom:10px;">
                <i class="fas fa-university"></i> Informasi Rekening Bank
            </h3>

            <label>Nama Bank</label>
            <input type="text" name="bank_name" value="{{ old('bank_name') }}">
            @error('bank_name') <div class="error-text">{{ $message }}</div> @enderror

            <label>Nomor Rekening</label>
            <input type="text" name="bank_account_number" value="{{ old('bank_account_number') }}">
            @error('bank_account_number') <div class="error-text">{{ $message }}</div> @enderror

            <label>Nama Pemilik Rekening</label>
            <input type="text" name="bank_account_name" value="{{ old('bank_account_name') }}">
            @error('bank_account_name') <div class="error-text">{{ $message }}</div> @enderror

            <button class="btn-primary" type="submit">Daftarkan Toko</button>
        </form>
    </div>

</div>

@endsection
