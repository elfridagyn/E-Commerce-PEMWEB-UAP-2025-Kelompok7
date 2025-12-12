{{-- resources/views/member/home.blade.php --}}
@extends('layouts.app')

@section('title', 'Beranda')

@push('styles')
{{-- WAJIB: Memuat Font Awesome untuk semua ikon --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

<style>
/* --- GLOBAL --- */
body {
    font-family: 'Poppins', sans-serif;
    /* Background Gradient */
    background: linear-gradient(135deg, #f5b8c8, #e58fa2, #d56e82);
    margin: 0;
    padding: 40px 0;
}

/* --- NAVBAR --- */
.top-navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding: 0 40px;
    position: relative;
    z-index: 100;
}

/* Container untuk semua aksi kanan (Ikon Pesanan & Dropdown) */
.nav-right-actions {
    display: flex; /* Untuk menyejajarkan ikon pesanan/topup dan dropdown */
    align-items: center;
    gap: 20px; /* Jarak antara ikon aksi dan dropdown toggle */
}

/* Gaya untuk Tombol Ikon Aksi (Pesanan & Topup) */
/* Mengubah .order-icon-btn menjadi .action-icon-btn agar bisa dipakai untuk topup juga */
.action-icon-btn { 
    /* Gaya Glassmorphism Ringan untuk Tombol Ikon */
    background: rgba(255, 255, 255, 0.35);
    width: 45px;
    height: 45px;
    border-radius: 50%; /* Membuat tombol menjadi lingkaran */
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
    box-shadow: 0px 4px 12px rgba(0,0,0,0.15);
    color: #6b2b38; /* Warna ikon */
    font-size: 1.2rem;
    text-decoration: none;
    transition: background 0.3s ease, box-shadow 0.3s ease;
}

.action-icon-btn:hover {
    background: rgba(255, 255, 255, 0.5); /* Sedikit lebih solid saat hover */
    box-shadow: 0px 4px 15px rgba(0,0,0,0.25);
}

/* --- HAPUS/GANTI .order-icon-btn jika tidak lagi dipakai --- */
/* Jika Anda ingin mempertahankan nama class lama untuk kompatibilitas, tambahkan ini: */
.order-icon-btn { /* Menggunakan action-icon-btn sebagai dasar */
    /* Menjaga kompatibilitas dengan elemen lama */
    /* Karena sudah didefinisikan di atas, ini tidak terlalu dibutuhkan, 
       tapi jika ada kode yang bergantung pada nama lama, gunakan alias */
    /* Mengganti semua penggunaan order-icon-btn di HTML dengan action-icon-btn */
}


/* Tambahkan Gaya untuk Logo Toko Gambar */
.logo-image {
    height: 80px; /* Atur tinggi logo */
    width: auto;
    object-fit: contain;
    padding: 0px 0px; /* Padding agar logo tidak terlalu mepet */
    border-radius: 8px;
}

/* CONTAINER untuk informasi pengguna dan dropdown */
.nav-right-container {
    position: relative; /* Menampung dropdown */
}

.user-info {
    display: flex;
    align-items: center;
    gap: 10px;
    /* Gaya Glassmorphism pada tombol toggle */
    background: rgba(255, 255, 255, 0.35);
    padding: 10px 18px;
    border-radius: 30px;
    cursor: pointer;
    backdrop-filter: blur(10px);
    box-shadow: 0px 4px 12px rgba(0,0,0,0.15);
    color: #6b2b38;
    font-weight: 600;
}

.avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
}

/* IKON PANAH TOGGLE (Rotasi saat aktif) */
.user-info .toggle-icon {
    transition: transform 0.3s ease;
}

.user-info.active .toggle-icon {
    transform: rotate(180deg);
}

/* DROPDOWN MENU */
.dropdown-menu {
    position: absolute;
    top: 55px;
    right: 0;
    /* Gaya Glassmorphism pada menu */
    background: rgba(255, 255, 255, 0.75);
    backdrop-filter: blur(12px);
    width: 220px;
    border-radius: 14px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.20);
    display: none; /* Default tersembunyi */
    flex-direction: column;
    overflow: hidden;
    z-index: 1000;
    border: 1px solid rgba(255, 255, 255, 0.5);
}

.dropdown-menu.show {
    display: flex; /* Ditampilkan saat class 'show' aktif */
}

.dropdown-menu a, .dropdown-menu button {
    /* Gaya untuk meratakan ikon dan panah kanan */
    display: flex; 
    align-items: center;
    justify-content: space-between; 
    padding: 12px 18px;
    background: none;
    border: none;
    text-align: left;
    font-size: 15px;
    color: #632c38;
    cursor: pointer;
    width: 100%;
    text-decoration: none;
    transition: background 0.2s;
}

.dropdown-menu a:hover, .dropdown-menu button:hover {
    background: rgba(230, 170, 185, 0.4);
}

.dropdown-menu .menu-item-content {
    display: flex;
    align-items: center;
    gap: 8px; /* Jarak antara ikon dan teks menu */
}

.dropdown-menu .separator {
    height: 1px;
    background: rgba(107, 43, 56, 0.2); 
    margin: 4px 0;
}

/* --- GLASS CONTAINER (Wrapper Konten Utama) --- */
.glass-container {
    background: rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(16px);
    border-radius: 30px;
    padding: 40px;
    max-width: 1200px;
    margin: 40px auto;
    box-shadow: 0px 15px 40px rgba(0, 0, 0, 0.15);
}

/* --- HEADER & SEARCH --- */
.flex.flex-col.md\:flex-row > div:first-child h1 {
    margin-bottom: 14px !important;
}

.flex.flex-col.md\:flex-row > div:first-child p {
    margin-bottom: 18px !important;
    margin-top: 6px !important;
    line-height: 1.6;
}

.search-box {
    align-items: center;
}

.search-box input {
    border-radius: 20px;
    padding: 10px 16px !important;
    font-size: 14px !important;
    height: 36px !important;
    border: 2px solid #b25c6a;
    background: transparent;
    color: #6b2b38;
}

.search-box .btn-search {
    background: #c96a7f;
    color: white;
    padding: 10px 18px !important;
    font-size: 14px !important;
    height: 36px !important;
    display: flex;
    align-items: center;
    border-radius: 25px;
    font-weight: bold;
    cursor: pointer;
    transition: .2s;
}

.search-box .btn-search:hover {
    background: #a44c61;
}

/* --- CATEGORY PILLS --- */
.category-pill {
    padding: 6px 18px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    background: #ffc4d5;
    color: #6b2b38;
    border: 1px solid #d18398;
    display: inline-flex;
    align-items: center;
    text-decoration: none;
}

.category-pill.active {
    background: #c96a7f;
    color: white;
}

/* --- PROFILE CARD (Tombol aksi sudah dipindahkan ke dropdown) --- */
.profile-card {
    background: rgba(255,255,255,0.35);
    backdrop-filter: blur(14px);
    border-radius: 25px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 30px;
    box-shadow: 0px 8px 25px rgba(0,0,0,0.15);
}

.profile-card img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 2px solid #ffc4d5;
    object-fit: cover;
}

.profile-card h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #6b2b38;
    margin: 0;
}

.profile-card p {
    font-size: 0.9rem;
    color: #6b2b38;
    margin: 2px 0 0 0;
}

/* --- PRODUCT CARDS --- */
.product-card {
    background: rgba(255, 255, 255, 0.35);
    backdrop-filter: blur(10px);
    border-radius: 25px;
    overflow: hidden;
    box-shadow: 0px 10px 30px rgba(0,0,0,0.1);
    transition: .3s;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0px 12px 35px rgba(0,0,0,0.18);
}

.product-card img {
    width: 100%;
    height: 11rem;
    object-fit: cover;
}

.price {
    color: #6b2b38;
    font-weight: 900;
}

.btn-detail {
    display: block;
    background: #c96a7f;
    color: white;
    text-align: center;
    padding: 10px 0;
    border-radius: 20px;
    margin-top: 10px;
    font-weight: bold;
    transition: .2s;
    text-decoration: none;
}

.btn-detail:hover {
    background: #a44c61;
}

/* --- PRODUCT GRID --- */
.grid {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 1.5rem;
}

@media(min-width: 640px) { .grid { grid-template-columns: repeat(2, 1fr); } }
@media(min-width: 768px) { .grid { grid-template-columns: repeat(3, 1fr); } }
</style>
@endpush

@section('content')

{{-- NAVBAR UTAMA DENGAN DROPDOWN --}}
<div class="top-navbar">
    
    {{-- LOGO TOKO --}}
    <a href="{{ route('member.store') }}">
        <img src="{{ asset('storage/assets/logooo.png') }}" alt="GyZal Logo" class="logo-image">
    </a>
    
    {{-- Container untuk semua aksi kanan (Ikon Topup, Pesanan & Dropdown) --}}
    <div class="nav-right-actions">

        {{-- BARU: Ikon Top-up (Mengarahkan ke member.topup) --}}
        <a href="{{ route('member.topup') }}" class="action-icon-btn" title="Isi Saldo">
            <i class="fas fa-wallet"></i> 
        </a>

        {{-- Ikon Pesanan/Riwayat (Mengarahkan ke history.blade) --}}
        <a href="{{ route('member.history') }}" class="action-icon-btn" title="Riwayat Pesanan">
            <i class="fas fa-shopping-bag"></i> 
        </a>

        <div class="nav-right-container">
            {{-- Tombol Toggle User Info --}}
            <div class="user-info" id="user-info-toggle">
                <img src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . Auth::user()->name }}" class="avatar">
                <span>{{ Auth::user()->name }}</span>
                <i class="fas fa-caret-down text-sm ml-1 toggle-icon"></i> 
            </div>

            {{-- DROPDOWN MENU --}}
            <div class="dropdown-menu" id="dropdown-menu">
                {{-- Edit Profil --}}
                <a href="{{ route('member.profile.edit') }}">
                    <span class="menu-item-content">
                        <i class="fas fa-user-edit"></i> Edit Profil
                    </span>
                    <i class="fas fa-angle-right"></i> 
                </a>
                
                {{-- BARU: Link Top-up di Dropdown (Opsional, tapi bagus untuk konsistensi) --}}
                <a href="{{ route('member.topup') }}">
                    <span class="menu-item-content">
                        <i class="fas fa-wallet"></i> Isi Saldo
                    </span>
                    <i class="fas fa-angle-right"></i> 
                </a>

                {{-- Seller Options --}}
                @if (!Auth::user()->store) 
                    <a href="{{ route('seller.store.register') }}">
                        <span class="menu-item-content">
                            <i class="fas fa-store-slash"></i> Daftar Jadi Seller
                        </span>
                        <i class="fas fa-angle-right"></i> 
                    </a>
                @else
                    <a href="{{ route('seller.dashboard') }}">
                        <span class="menu-item-content">
                            <i class="fas fa-tachometer-alt"></i> Dashboard Seller
                        </span>
                        <i class="fas fa-angle-right"></i> 
                    </a>
                @endif
                
                <div class="separator"></div>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">
                        <span class="menu-item-content">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </span class="menu-item-content">
                        <i class="fas fa-angle-right"></i> 
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- END NAVBAR --}}


<div class="glass-container">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between mb-10 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-[#6b2b38]">Selamat Datang di GyZal!</h1>
            <p class="text-1x1 text-[#6b2b38] mt-1">
                Temukan produk favoritmu dengan pengalaman belanja yang lebih menyenangkan ✨
            </p>
        </div>

        {{-- Search --}}
        <form method="GET" action="{{ url()->current() }}" class="flex gap-2 search-box w-full md:w-auto">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk...">
            <button class="btn-search" type="submit">Cari</button>
        </form>
    </div>

    {{-- Filter Kategori --}}
    <div class="flex flex-wrap gap-3 mb-7">
        <a href="{{ route('member.store') }}" class="category-pill {{ request('category') ? '' : 'active' }}">Semua</a>
        @foreach ($categories as $category)
            <a href="{{ route('member.store', ['category' => $category->id]) }}" class="category-pill {{ request('category') == $category->id ? 'active' : '' }}">
                {{ $category->name }}
            </a>
        @endforeach
    </div>

    {{-- Produk --}}
    <div class="grid">
        @forelse ($products ?? collect() as $product)
            <div class="product-card">
                <img src="{{ $product->thumbnail_url ?? 'https://via.placeholder.com/400x300?text=Product' }}" alt="{{ $product->name }}">
                <div class="p-5 flex-1 flex flex-col">
                    <div>
                        <h3 class="font-semibold text-[#6b2b38] text-sm line-clamp-2">{{ $product->name }}</h3>
                        <p class="text-xs text-[#6b2b38] mt-1">{{ $product->store->name ?? 'Toko' }}</p>
                        <p class="price mt-2 text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="mt-auto">
                        <a href="{{ route('member.product.show', $product->slug) }}" class="btn-detail">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center w-full text-[#6b2b38] py-10">Belum ada produk tersedia.</p>
        @endforelse
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleButton = document.getElementById('user-info-toggle');
        const dropdownMenu = document.getElementById('dropdown-menu');
        const actionIconButtons = document.querySelectorAll('.action-icon-btn');

        // Menggunakan class baru .action-icon-btn untuk semua tombol ikon di navbar
        // Ganti class .order-icon-btn lama dengan .action-icon-btn di CSS dan HTML.

        // Toggle dropdown saat tombol user-info diklik
        toggleButton.addEventListener('click', function (event) {
            // Toggle class 'show' untuk menampilkan/menyembunyikan menu
            dropdownMenu.classList.toggle('show');
            // Toggle class 'active' untuk memutar panah (panah kebawah menjadi keatas)
            toggleButton.classList.toggle('active');

            event.stopPropagation();
        });

        // Sembunyikan dropdown saat klik di luar menu
        window.addEventListener('click', function (event) {
            if (!toggleButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.remove('show');
                toggleButton.classList.remove('active'); // Pastikan panah kembali ke bawah
            }
        });
    });
</script>
@endpush