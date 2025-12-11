@extends('layouts.seller')

@section('title', 'Profil Toko')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<style>
/* GLOBAL */
html, body {
    width: 100%;
    margin: 0;
    padding: 0;
    overflow-x: hidden;
    scrollbar-gutter: stable; /* agar centering tidak terganggu scrollbar */
}

body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #f3b8c8, #e38fa2, #d86e82);
    min-height: 100vh;
}

/* NAVBAR */
.top-navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding: 20px 40px; /* SAMA dengan container padding */
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
}

.avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
}

/* CONTAINER — perbaikan utama */
.container {
    width: min(1100px, calc(100% - 80px)); /* simetris kiri-kanan */
    padding: 0 40px;
    margin: 0 auto;
    box-sizing: border-box;
}

/* TITLE BOX */
.title-box {
    background: rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(12px);
    padding: 35px;
    border-radius: 18px;
    box-shadow: 0px 10px 25px rgba(0,0,0,0.15);
    text-align: center;
    margin-bottom: 35px;
    border-left: 8px solid #c96a7f;
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

/* CARD */
.card-box {
    background: rgba(255,255,255,0.4);
    backdrop-filter: blur(10px);
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0px 10px 25px rgba(0,0,0,0.15);
}

/* LOGO */
.logo-box {
    text-align: center;
    margin-bottom: 25px;
}

.logo-box img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #c96a7f;
}

/* STATUS */
.status-badge {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 18px;
    border-radius: 30px;
    font-weight: 600;
}

.status-pending { background: #f1c40f; color: #6b4d00; }
.status-approved { background: #2ecc71; color: #145a32; }
.status-rejected { background: #e74c3c; color: white; }

/* FORM */
label {
    display: block;
    margin-top: 15px;
    font-weight: 600;
    color: #6b2b38;
}

input,
textarea {
    width: 100%;
    padding: 12px;
    margin-top: 6px;
    border-radius: 10px;
    border: none;
    box-sizing: border-box;
}

textarea { resize: vertical; }

.btn-primary {
    margin-top: 25px;
    background: #6b2b38;
    color: white;
    padding: 12px 26px;
    border-radius: 30px;
    border: none;
    font-weight: 600;
    cursor: pointer;
    
}

.btn-danger {
    margin-top: 15px;
    background: #8b1e2e;
    color: white;
    padding: 12px 26px;
    border-radius: 30px;
    border: none;
    font-weight: 600;
    cursor: pointer;
}

.alert-success {
    background: rgba(46,204,113,0.25);
    color: #145a32;
    padding: 14px;
    border-radius: 10px;
    margin-bottom: 20px;
}

.error-text {
    color: #6b2b38;
    font-size: 0.85rem;
    margin-top: 3px;
}

</style>

{{-- NAVBAR --}}
<div class="top-navbar">

    <a href="{{ route('seller.profile.show') }}" class="back-to-dashboard">
        <i class="fas fa-arrow-left"></i> Show Profile
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
        <h2>Profile Toko</h2>
        <p>Kelola identitas dan informasi tokomu</p>
    </div>

    <div class="card-box">

        <div class="logo-box">
            <img src="{{ $store->logo ? asset('storage/' . $store->logo) : 'https://via.placeholder.com/120?text=LOGO' }}">
            <div class="status-badge status-{{ $store->status }}">
                {{ ucfirst($store->status) }}
            </div>
        </div>

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('seller.profile.update') }}" enctype="multipart/form-data">
            @csrf

            <label>Nama Toko</label>
            <input type="text" name="name" value="{{ old('name', $store->name) }}">
            @error('name') <div class="error-text">{{ $message }}</div> @enderror

            <label>Logo</label>
            <input type="file" name="logo">
            @error('logo') <div class="error-text">{{ $message }}</div> @enderror

            <label>Deskripsi</label>
            <textarea name="about">{{ old('about', $store->about) }}</textarea>

            <label>No Telepon</label>
            <input type="text" name="phone" value="{{ old('phone', $store->phone) }}">

            <label>Kota</label>
            <input type="text" name="city" value="{{ old('city', $store->city) }}">

            <label>Alamat</label>
            <textarea name="address">{{ old('address', $store->address) }}</textarea>

            <label>Kode Pos</label>
            <input type="text" name="postal_code" value="{{ old('postal_code', $store->postal_code) }}">

            <hr style="margin:40px 0; border:1px solid rgba(107,43,56,0.25);">

            <h3 style="color:#6b2b38; margin-bottom:10px;">
                <i class="fas fa-university"></i> Informasi Rekening Bank
            </h3>

            <label>Nama Bank</label>
            <input type="text" name="bank_name" value="{{ old('bank_name', $store->bank_name) }}">

            <label>Nomor Rekening</label>
            <input type="text" name="bank_account_number" value="{{ old('bank_account_number', $store->bank_account_number) }}">

            <label>Nama Pemilik Rekening</label>
            <input type="text" name="bank_account_name" value="{{ old('bank_account_name', $store->bank_account_name) }}">

            <button class="btn-primary">Simpan Perubahan</button>
        </form>

        <form method="POST" action="{{ route('seller.profile.delete') }}"
            onsubmit="return confirm('Yakin ingin menghapus toko?')">
            @csrf
            @method('DELETE')
            <button class="btn-danger">Hapus Toko</button>
        </form>

    </div>
</div>

@endsection
