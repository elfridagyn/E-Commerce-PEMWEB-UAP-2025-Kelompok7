@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="bg-gradient-to-b from-purple-50 to-white min-h-screen py-8">
    <div class="max-w-5xl mx-auto px-4">

        {{-- Back link --}}
        <a href="{{ route('home') }}" class="text-xs text-pink-600 hover:underline">&larr; Kembali ke Beranda</a>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Gambar Produk --}}
            <div class="space-y-3">

                {{-- Thumbnail utama --}}
                <div class="bg-white rounded-2xl border border-pink-100 shadow-sm overflow-hidden">
                    <img src="{{ $product->thumbnail_url ?? asset('no-image.png') }}"
                         class="w-full h-64 object-cover"
                         alt="{{ $product->name }}">
                </div>

                {{-- Thumbnail lainnya --}}
                <div class="flex gap-2 overflow-x-auto">
                    @forelse (($product->images ?? []) as $img)
                        <img src="{{ $img->url }}"
                             class="w-20 h-20 rounded-xl object-cover border border-pink-100 shadow-sm">
                    @empty
                        {{-- Tidak ada gambar tambahan --}}
                    @endforelse
                </div>
            </div>

            {{-- Detail Produk --}}
            <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-6">
                <h1 class="text-2xl font-bold text-gray-800">{{ $product->name }}</h1>

                <p class="text-xs text-gray-500 mt-1">
                    Toko:
                    <span class="font-semibold text-pink-700">
                        {{ $product->store->name ?? 'Store' }}
                    </span>
                </p>

                <p class="mt-4 text-2xl font-extrabold text-pink-700">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>

                <p class="mt-3 text-sm text-gray-600 leading-relaxed">
                    {{ $product->description ?? 'Belum ada deskripsi untuk produk ini.' }}
                </p>

                {{-- Tombol Beli --}}
                <form action="{{ route('checkout.start', $product->id) }}" method="GET" class="mt-6">
                    <button
                        class="w-full bg-pink-600 hover:bg-pink-700 text-white font-semibold py-2.5 rounded-xl text-sm transition">
                        Beli Sekarang
                    </button>
                </form>
            </div>
        </div>

        {{-- Review Produk --}}
        <div class="mt-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">Ulasan Produk</h2>

            <div class="space-y-3">
                @forelse ($reviews as $review)
                    <div class="bg-white border border-purple-100 rounded-2xl p-4 shadow-sm">
                        <div class="flex justify-between items-center mb-1">
                            <p class="text-sm font-semibold text-gray-800">{{ $review->user->name }}</p>
                            <p class="text-xs text-yellow-500">⭐ {{ $review->rating }}/5</p>
                        </div>
                        <p class="text-xs text-gray-600">{{ $review->comment }}</p>
                    </div>
                @empty
                    <p class="text-xs text-gray-500">Belum ada ulasan untuk produk ini.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
