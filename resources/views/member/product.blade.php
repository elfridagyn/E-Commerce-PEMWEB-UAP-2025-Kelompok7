@extends('layouts.app')

@section('title', $product->name)

@section('content')
<style>
    .glass-box {
        background: rgba(255, 255, 255, 0.35);
        backdrop-filter: blur(14px);
        border-radius: 30px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        border: 1px solid rgba(255,255,255,0.3);
    }

    .thumb-main {
        border-radius: 25px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        border: 1px solid #f3b8c8;
    }

    .thumb-small {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 18px;
        border: 1px solid #d18398;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
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

    .section-title {
        color: #6b2b38;
        font-weight: 600;
    }
</style>

<div class="bg-gradient-to-b from-purple-50 to-white min-h-screen py-8">
    <div class="max-w-5xl mx-auto px-4">

        {{-- Back link --}}
        <a href="{{ route('home') }}" class="text-xs text-pink-600 hover:underline">&larr; Kembali ke Beranda</a>

        {{-- GLASS PRODUCT BOX --}}
        <div class="glass-box mt-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                {{-- IMAGE SECTION --}}
                <div>
                    {{-- Thumbnail utama --}}
                    <img src="{{ $product->thumbnail_url ?? asset('no-image.png') }}"
                         class="w-full h-72 object-cover thumb-main">

                    {{-- Thumbnail lainnya --}}
                    <div class="flex gap-3 mt-3 overflow-x-auto">
                        @forelse(($product->images ?? []) as $img)
                            <img src="{{ $img->url }}" class="thumb-small">
                        @empty
                        @endforelse
                    </div>
                </div>

                {{-- DETAIL SECTION --}}
                <div>
                    <h1 class="text-2xl font-bold text-[#6b2b38]">
                        {{ $product->name }}
                    </h1>

                    <p class="text-xs mt-1 text-[#6b2b38]">
                        Toko:
                        <span class="font-semibold">{{ $product->store->name ?? 'Store' }}</span>
                    </p>

                    <p class="mt-4 text-3xl font-extrabold text-[#6b2b38]">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>

                    <p class="mt-4 text-sm text-[#6b2b38] leading-relaxed">
                        {{ $product->description ?? 'Deskripsi belum tersedia.' }}
                    </p>

                    {{-- Tombol Beli --}}
                    <form action="{{ route('member.checkout.start', $product->id) }}" method="GET">
                        <button class="btn-buy">Beli Sekarang</button>
                    </form>
                </div>
            </div>

            {{-- REVIEW SECTION --}}
            <div class="mt-10">
                <h2 class="section-title mb-3 text-lg">Ulasan Produk</h2>

                <div class="space-y-3">
                    @forelse ($reviews as $review)
                        <div class="glass-box p-4">
                            <div class="flex justify-between items-center">
                                <p class="font-semibold">{{ $review->user->name }}</p>
                                <p class="text-yellow-500 text-sm">⭐ {{ $review->rating }}/5</p>
                            </div>
                            <p class="text-sm mt-1 text-[#6b2b38]">{{ $review->comment }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-[#6b2b38]">Belum ada ulasan.</p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
