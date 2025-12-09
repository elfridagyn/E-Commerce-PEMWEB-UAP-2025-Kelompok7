@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="bg-gradient-to-b from-pink-50 to-white min-h-screen py-10">
    <div class="max-w-6xl mx-auto px-4">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-pink-800">My Store</h1>
                <p class="text-sm text-pink-500 mt-1">
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
                    class="px-3 py-2 rounded-xl border border-pink-200 focus:outline-none focus:ring-2 focus:ring-purple-300 text-sm w-full md:w-56"
                >
                <button
                    class="px-4 py-2 rounded-xl bg-pink-600 text-white text-sm font-semibold hover:bg-purple-700 transition">
                    Cari
                </button>
            </form>
        </div>

        {{-- Filter Kategori --}}
        <div class="mb-7 flex flex-wrap gap-2">
            <a href="{{ url()->current() }}"
               class="px-4 py-1.5 rounded-full text-xs font-medium shadow
                      {{ request('category') ? 'bg-pink-100 text-pink-600' : 'bg-pink-600 text-white' }}">
                Semua
            </a>
            @foreach ($categories as $category)
                <a href="?category={{ $category->id }}"
                   class="px-4 py-1.5 rounded-full text-xs font-medium shadow
                          {{ request('category') == $category->id ? 'bg-pink-600 text-white' : 'bg-purple-100 text-purple-600 hover:bg-purple-200' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        {{-- GRID PRODUK --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @forelse ($products as $product)
                <div class="bg-white rounded-2xl shadow-md border border-pink-100 overflow-hidden hover:shadow-lg hover:-translate-y-1 transition">
                    <div class="relative">
                        <img src="{{ $product->thumbnail_url ?? 'https://via.placeholder.com/400x300?text=Product' }}"
                             alt="{{ $product->name }}"
                             class="w-full h-44 object-cover">

                        <span class="absolute top-2 left-2 bg-white/90 text-[10px] font-semibold px-2 py-1 rounded-full text-pink-600 shadow">
                            {{ $product->category->name ?? 'Tanpa Kategori' }}
                        </span>
                    </div>

                    <div class="p-4">
                        <h3 class="text-sm font-semibold text-gray-800 line-clamp-2">{{ $product->name }}</h3>

                        <p class="text-xs text-gray-500 mt-1">
                            {{ $product->store->name ?? 'Toko' }}
                        </p>

                        <p class="mt-2 text-pink-700 font-extrabold text-lg">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>

                        <a href="{{ route('member.product.show', $product->slug) }}"
                           class="mt-3 inline-flex items-center justify-center w-full text-sm font-semibold px-3 py-2 rounded-xl bg-pink-600 text-white hover:bg-pink-700 transition">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500 col-span-full text-center py-10">
                    Belum ada produk tersedia.
                </p>
            @endforelse
        </div>

    </div>
</div>
@endsection
