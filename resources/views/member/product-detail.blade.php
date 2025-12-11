@extends('layouts.app')

@section('title', $product->name)

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
        transform: scale(1.02);
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
        padding: 12px 20px;
        font-weight: 600;
        text-align: center;
        border-radius: 20px;
        transition: 0.2s;
        display: inline-block;
    }

    .btn-buy:hover {
        background: #a44c61;
    }

    h1, h2, h3, p, span {
        color: #6b2b38;
    }

    .product-img {
    width: 600px;   
    height: 500px; 
    object-fit: cover;
    border-radius: 20px;
}
</style>

<div class="bg-gradient-to-b from-purple-50 to-white min-h-screen py-10">
    <div class="max-w-4xl mx-auto px-4">

    {{-- Tombol Kembali --}}
<a href="{{ url()->previous() }}" 
   class="inline-block mb-4 px-4 py-2 bg-[#e5c3c8] hover:bg-[#d9aab2] text-[#6b2b38] font-semibold rounded-lg shadow">
    ← Kembali
</a>

        <div class="bg-gradient-to-b from-purple-50 to-white min-h-screen py-10">
    <div class="max-w-4xl mx-auto px-4">

        {{-- DETAIL PRODUK --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center justify-center mt-6">

            {{-- KIRI: GAMBAR PRODUK --}}
            <div class="flex justify-center md:justify-start">
                <img src="{{ $product->thumbnail_url ?? 'https://via.placeholder.com/400x300?text=Product' }}" 
                     alt="{{ $product->name }}"
                     class="product-img">
            </div>

            {{-- KANAN: INFORMASI PRODUK --}}
            <div class="flex flex-col justify-center">
                <h1 class="text-3xl font-bold mb-4 text-gray-800">
                    {{ $product->name }}
                </h1>

                <p class="mb-4 text-gray-700 leading-relaxed">
                    {{ $product->description ?? 'Tidak ada deskripsi' }}
                </p>

                <p class="font-bold text-xl text-gray-800 mb-2">
                    Harga: Rp {{ number_format($product->price,0,',','.') }}
                </p>

                <p class="text-sm text-gray-600 mb-6">
                    {{ $product->store->name ?? 'Toko' }}
                </p>

                {{-- Tombol Checkout --}}
                <a href="{{ route('member.checkout.start', $product->id) }}" class="btn-buy">
                    Checkout
                </a>
            </div>
        </div>

    {{-- GAMBAR PRODUK (RATA KANAN) --}}
    <div class="order-2 md:order-2 flex justify-end w-full">
    </div>

</div>

        {{-- PRODUK REKOMENDASI --}}
        <h2 class="text-xl font-bold mb-4">Produk Rekomendasi</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($products as $item)
                @if($item->id !== $product->id)
                    <div class="glass-box p-4 flex flex-col justify-between">
                        {{-- Thumbnail --}}
                        <div class="relative">
                            <img src="{{ $item->thumbnail_url ?? 'https://via.placeholder.com/400x300?text=Product' }}" 
                                 alt="{{ $item->name }}" 
                                 class="w-full h-52 object-cover thumb-main mb-2">
                            <span class="absolute top-3 left-3 bg-white/80 text-[10px] font-semibold px-2 py-1 rounded-full shadow">
                            </span>
                            @if($item->discount)
                                <span class="absolute top-3 right-3 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-full shadow">
                                    -{{ $item->discount }}%
                                </span>
                            @endif
                        </div>
                        {{-- Nama & Harga --}}
                        <div class="mt-2">
                            <h3 class="text-sm font-semibold line-clamp-2">{{ $item->name }}</h3>
                            <p class="font-bold text-lg mt-1">Rp {{ number_format($item->price,0,',','.') }}</p>
                            <a href="{{ route('member.product.show', $item->slug) }}" class="btn-buy mt-2 text-center block text-sm">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

    </div>
</div>
@endsection
