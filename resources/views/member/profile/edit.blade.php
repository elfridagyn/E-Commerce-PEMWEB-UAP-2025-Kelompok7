@extends('layouts.app')

@section('title', 'Edit Profile')

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
    scrollbar-gutter: stable; /* Konsisten dengan gaya Toko */
}

body {
    font-family: 'Poppins', sans-serif;
    /* BACKGROUND KONSISTEN */
    background: linear-gradient(135deg, #f3b8c8, #e38fa2, #d86e82);
    min-height: 100vh;
}

/* NAVBAR */
.top-navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding: 20px 40px;
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

/* CONTAINER */
.container {
    width: min(1100px, calc(100% - 80px));
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
    /* BORDER KIRI KONSISTEN */
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

/* FORM */
label {
    display: block;
    margin-top: 15px;
    font-weight: 600;
    color: #6b2b38;
}

input,
textarea,
input[type="file"] {
    width: 100%;
    padding: 12px;
    margin-top: 6px;
    border-radius: 10px;
    border: none;
    box-sizing: border-box;
}

textarea { resize: vertical; }

.btn-primary {
    /* BUTTON PRIMARY KONSISTEN */
    margin-top: 25px;
    background: #6b2b38;
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

.profile-photo {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    /* BORDER WARNA KONSISTEN */
    border: 2px solid #d27d8f;
}

/* FLEX UTILITY - Diperlukan untuk layout foto profil */
.flex {
    display: flex;
}

.items-center {
    align-items: center;
}

.gap-4 {
    gap: 16px; /* 4 * 4px = 16px, asumsi utility class Tailwind/Bootstrap default */
}

.mt-2 {
    margin-top: 8px; /* 2 * 4px = 8px, asumsi utility class Tailwind/Bootstrap default */
}
</style>

{{-- NAVBAR --}}
<div class="top-navbar">
    <a href="{{ route('member.dashboard') }}" class="back-to-dashboard">
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
        <i class="fas fa-user-edit"></i>
        <h2>Edit Profil</h2>
        <p>Perbarui informasi akunmu di sini</p>
    </div>

    <div class="card-box">
        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('member.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label>Foto Profil</label>
<div class="flex items-center gap-4 mt-2">
    <img src="{{ $user->profil_picture
        ? asset('storage/profile/' . $user->profil_picture)
        : 'https://ui-avatars.com/api/?name=' . $user->name }}"
        class="profile-photo">

    <input type="file" name="photo">
</div>

            <label>Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}">
            @error('name') <div class="error-text">{{ $message }}</div> @enderror

            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}">
            @error('email') <div class="error-text">{{ $message }}</div> @enderror

            <button class="btn-primary" type="submit">Simpan Perubahan</button>
        </form>
    </div>

</div>

@endsection