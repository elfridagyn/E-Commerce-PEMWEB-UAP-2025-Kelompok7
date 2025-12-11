@extends('layouts.seller')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<style>
    html,
    body {
        width: 100%;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        scrollbar-gutter: stable;
        /* agar centering tidak terganggu scrollbar */
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f5b8c8, #e58fa2, #d56e82);
        margin: 0;
    }

    .top-navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding: 20px 40px;
    }

    .back-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        background: rgba(255, 255, 255, 0.35);
        backdrop-filter: blur(10px);
        padding: 10px 18px;
        border-radius: 30px;
        color: #6b2b38;
        font-weight: 600;
        transition: 0.3s;
    }

    .back-btn:hover {
        background: rgba(255, 255, 255, 0.5);
        transform: scale(1.04);
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
        background: rgba(255, 255, 255, 0.35);
        padding: 10px 18px;
        border-radius: 30px;
        backdrop-filter: blur(10px);
        position: relative;
    }

    .avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
    }

    .container {
        width: min(1100px, calc(100% - 80px));
        /* simetris kiri-kanan */
        padding: 0 40px;
        margin: 0 auto;
        box-sizing: border-box;
    }

    .title-header {
        font-size: 32px;
        font-weight: 700;
        color: #5b2230;
        margin-bottom: 25px;
        text-align: center;
    }

    .profile-grid {
        width: 100%;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
    }

    .card {
        background: rgba(255, 255, 255, 0.35);
        padding: 30px;
        border-radius: 22px;
        backdrop-filter: blur(12px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .profile-photo {
        width: 150px;
        height: 150px;
        border-radius: 18px;
        object-fit: cover;
        margin-bottom: 20px;
        background: #eee;
    }

    .label {
        font-weight: 600;
        color: #5b2a36;
        font-size: 14px;
        margin-top: 15px;
    }

    h3 {
        margin: 4px 0 14px 0;
        color: #5b2a36;
    }

    p {
        margin: 4px 0 14px 0;
        font-size: 14px;
        color: #3c1f26;
    }

    .btn-custom {
        width: 100%;
        background: linear-gradient(145deg, #d8849aff, #d4687fff);
        color: white;
        border: none;
        padding: 12px;
        border-radius: 14px;
        font-weight: 600;
        margin-top: 20px;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-custom:hover {
        transform: translateY(-2px);
    }

    .btn-danger {
        width: 100%;
        background: #d90429;
        color: #fff;
        border: none;
        padding: 12px;
        border-radius: 14px;
        margin-top: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-danger:hover {
        background: #b40220;
        transform: translateY(-2px);
    }

    .alert-success {
        background: rgba(76, 209, 55, 0.25);
        border-left: 6px solid #34c759;
        padding: 12px;
        border-radius: 12px;
        margin-bottom: 20px;
        color: #2b8a3e;
    }

    @media (max-width: 900px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

{{-- NAVBAR --}}
<div class="top-navbar">
    <a href="{{ route('seller.dashboard') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i> Dashboard
    </a>

    <div class="nav-right">
        <div class="user-info">
            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" class="avatar">
            <span>{{ auth()->user()->name }}</span>
        </div>
    </div>
</div>

<div class="container">

    <h1 class="title-header">Profil Toko</h1>

    @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="profile-grid">

        {{-- CARD PROFIL --}}
        <div class="card">
            <img src="{{ $store->logo ? asset('storage/'.$store->logo) : 'https://via.placeholder.com/150' }}" class="profile-photo">
            <h3>Informasi Toko</h3>

            <p class="label">Nama Toko</p>
            <p>{{ $store->name }}</p>

            <p class="label">Deskripsi</p>
            <p>{{ $store->about }}</p>

            <p class="label">Telepon</p>
            <p>{{ $store->phone }}</p>

            <p class="label">Alamat</p>
            <p>{{ $store->address }}, {{ $store->city }} ({{ $store->postal_code }})</p>
        </div>

        {{-- CARD REKENING --}}
        <div class="card">
            <h3>Informasi Bank</h3>

            <p class="label">Bank</p>
            <p>{{ $store->bank_name }}</p>

            <p class="label">Nomor Rekening</p>
            <p>{{ $store->bank_account_number }}</p>

            <p class="label">Nama Pemilik</p>
            <p>{{ $store->bank_account_name }}</p>

            <a href="{{ route('seller.profile.edit') }}">
                <button class="btn-custom">Edit Profil</button>
            </a>

            <form action="{{ route('seller.profile.delete') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus toko?')">
                @csrf
                @method('DELETE')
                <button class="btn-danger">Hapus Toko</button>
            </form>
        </div>

    </div>
</div>

<script>
    function toggleDropdown() {
        const menu = document.getElementById("dropdownMenu");
        menu.style.display = (menu.style.display === "flex") ? "none" : "flex";
    }

    document.addEventListener("click", function(e) {
        const menu = document.getElementById("dropdownMenu");
        const btn = document.getElementById("userInfoBtn");
        if (!btn.contains(e.target)) {
            menu.style.display = "none";
        }
    });
</script>

@endsection