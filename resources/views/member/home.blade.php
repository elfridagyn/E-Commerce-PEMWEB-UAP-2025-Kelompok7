{{-- resources/views/member/home.blade.php --}}
@extends('layouts.app')

@section('title', 'Beranda')

@push('styles')
<style>
    /* Visual style (glass + pastel pink) */
    body {
        font-family: 'Poppins', sans-serif;
    }

    .glass-container {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(16px);
        border-radius: 30px;
        padding: 40px;
        max-width: 1200px;
        margin: 40px auto;
        box-shadow: 0px 15px 40px rgba(0, 0, 0, 0.15);
    }

    .search-box input {
        border-radius: 20px;
        padding: 10px 15px;
        border: 2px solid #b25c6a;
        background: transparent;
        color: #6b2b38;
    }

    .btn-search {
        background: #c96a7f;
        color: white;
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: bold;
    }

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
    }

    .category-pill.active {
        background: #c96a7f;
        color: white;
    }

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

    /* small helpers */
    .product-card img {
        width: 100%;
        height: 11rem; /* match h-44 */
        object-fit: cover;
    }
</style>
@endpush

@section('content')
<div class="bg-gradient-to-b from-pink-50 to-white min-h-screen py-10">
    <div class="glass-container">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between mb-10 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-[#6b2b38]">My Store</h1>
                <p class="text-sm text-[#6b2b38] mt-1">
                    Temukan produk favoritmu dengan pengalaman belanja yang lebih menyenangkan ✨
                </p>
            </div>

            {{-- Search --}}
            <form method="GET" action="{{ url()->current() }}" class="flex gap-2 search-box w-full md:w-auto">
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari produk..."
                    class="min-w-0"
                >
                <button class="btn-search" type="submit">Cari</button>
            </form>
        </div>

        {{-- Filter Kategori --}}
        <div class="flex flex-wrap gap-2 mb-6">
            <a href="{{ url()->current() }}" class="category-pill {{ request('category') ? '' : 'active' }}">
                Semua
            </a>

            @foreach ($categories ?? [] as $category)
                <a href="?category={{ $category->id }}"
                   class="category-pill {{ request('category') == $category->id ? 'active' : '' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        {{-- Produk --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @forelse ($products ?? collect() as $product)
                <div class="product-card">
                    <img src="{{ $product->thumbnail_url ?? 'https://via.placeholder.com/400x300?text=Product' }}"
                         alt="{{ $product->name }}">

                    <div class="p-5 flex-1 flex flex-col">
                        <div>
                            <h3 class="font-semibold text-[#6b2b38] text-sm line-clamp-2">{{ $product->name }}</h3>
                            <p class="text-xs text-[#6b2b38] mt-1">{{ $product->store->name ?? 'Toko' }}</p>

                            <p class="price mt-2 text-lg">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                        </div>

                        {{-- tombol di bagian bawah card --}}
                        <div class="mt-auto">
                            <a href="{{ route('member.product.show', $product->slug) }}" class="btn-detail">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center w-full text-[#6b2b38] py-10">
                    Belum ada produk tersedia.
                </p>
            @endforelse
        </div>

    </div>
</div>
@endsection
