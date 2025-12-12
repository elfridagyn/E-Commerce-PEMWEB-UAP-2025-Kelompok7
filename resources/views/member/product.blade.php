@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<style>
    /* Glass style untuk kartu produk */
    .glass-box {
        background: rgba(255, 255, 255, 0.35);
        backdrop-filter: blur(14px);
        border-radius: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        border: 1px solid rgba(255,255,255,0.3);
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .glass-box:hover {
        transform: scale(1.05);
        box-shadow: 0 15px 35px rgba(0,0,0,0.25);
    }

    .thumb-main {
        border-radius: 25px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        border: 1px solid #f3b8c8;
    }

    .btn-buy {
        background: #c96a7f;
        color: white;
        padding: 12px;
        font-weight: 600;
        width: 100%;
        text-align: center;
        border-radius: 20px;
        transition: .2s;
    }

    .btn-buy:hover {
        background: #a44c61;
    }

    .category-btn {
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
        padding: 0.5rem 1rem;
        transition: 0.2s;
    }

    .category-btn.active {
        background: #c96a7f;
        color: white;
    }

    .category-btn.inactive {
        background: #f3d4de;
        color: #6b2b38;
    }

    .rating-star {
        width: 14px;
        height: 14px;
    }

    h1, h3, p, span {
        color: #6b2b38;
    }
</style>

<div class="bg-gradient-to-b from-purple-50 to-white min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold">My Store</h1>
                <p class="text-sm mt-1">
                    Temukan produk favoritmu dengan pengalaman belanja yang lebih menyenangkan✨
                </p>
            </div>

            {{-- Search --}}
            <form method="GET" action="{{ url()->current() }}" class="flex gap-2 w-full md:w-auto">
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari produk..."
                    class="px-4 py-2 rounded-xl border border-[#f3d4de] focus:outline-none focus:ring-2 focus:ring-[#c96a7f] text-sm w-full md:w-72"
                >
                <button class="px-5 py-2 rounded-xl bg-[#c96a7f] text-white text-sm font-semibold hover:bg-[#a44c61] transition">
                    Cari
                </button>
            </form>
        </div>

        {{-- Filter Kategori --}}
        <div class="mb-7 flex flex-wrap gap-2">
            <a href="{{ url()->current() }}"
               class="category-btn {{ request('category') ? 'inactive' : 'active' }}">
                Semua
            </a>
            @foreach ($categories as $category)
                <a href="?category={{ $category->id }}"
                   class="category-btn {{ request('category') == $category->id ? 'active' : 'inactive' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        {{-- GRID PRODUK --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($products as $product)
                <div class="glass-box p-4 flex flex-col justify-between">
                      
                {{-- Thumbnail --}}
    <div class="relative">
        <img src="{{ $product->thumbnail_url ?? 'https://via.placeholder.com/400x300?text=Product' }}"
             alt="{{ $product->name }}"
             class="w-full h-52 object-cover thumb-main">

        <span class="absolute top-3 left-3 bg-white/80 text-[10px] font-semibold px-2 py-1 rounded-full shadow">
            {{ $product->category->name ?? 'Tanpa Kategori' }}
        </span>

        @if($product->discount)
            <span class="absolute top-3 right-3 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-full shadow">
                -{{ $product->discount }}%
            </span>
        @endif
    </div>

    {{-- Detail --}}
    <div class="mt-3 flex flex-col justify-between flex-1">
        <h3 class="text-sm font-semibold line-clamp-2">{{ $product->name }}</h3>
        <p class="text-xs mt-1">{{ $product->store->name ?? 'Toko' }}</p>

        {{-- Rating --}}
        <div class="flex items-center mt-2 space-x-1">
            @for ($i = 0; $i < 5; $i++)
                <svg class="rating-star {{ $i < $product->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.95a1 1 0 00.95.69h4.15c.969 0 1.371 1.24.588 1.81l-3.36 2.44a1 1 0 00-.364 1.118l1.286 3.95c.3.921-.755 1.688-1.54 1.118l-3.36-2.44a1 1 0 00-1.175 0l-3.36 2.44c-.784.57-1.838-.197-1.539-1.118l1.285-3.95a1 1 0 00-.364-1.118L2.975 9.377c-.783-.57-.38-1.81.588-1.81h4.15a1 1 0 00.95-.69l1.286-3.95z"/>
                </svg>
            @endfor
            <span class="text-xs text-gray-400 ml-1">({{ $product->reviews_count }})</span>
        </div>

        <p class="font-extrabold text-lg mt-2">
            Rp {{ number_format($product->price, 0, ',', '.') }}
        </p>

        <a href="{{ route('member.product.show', $product->slug) }}" class="btn-detail">
    Lihat Detail
</a>
                    </div>
                </div>
            @empty
                <p class="text-sm col-span-full text-center py-10">
                    Belum ada produk tersedia.
                </p>
            @endforelse
        </div>

    </div>
</div>
@endsection
