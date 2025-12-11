@extends('layouts.app')

@section('title', 'Checkout')

@push('styles')
<style>
    body {
        font-family: 'Poppins', sans-serif !important;
        background: linear-gradient(135deg, #f3b8c8, #e38fa2, #d86e82);
    }

    .glass-container {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(16px);
        border-radius: 30px;
        padding: 30px;
        max-width: 900px;
        margin: 30px auto;
        box-shadow: 0px 15px 40px rgba(0, 0, 0, 0.12);
    }

    .glass-box {
        background: rgba(255, 255, 255, 0.35);
        backdrop-filter: blur(12px);
        border-radius: 25px;
        padding: 20px;
        border: 1px solid rgba(255,255,255,0.45);
        box-shadow: 0px 10px 30px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    textarea, input[type="text"] {
        border-radius: 18px;
        border: 2px solid #b25c6a;
        background: rgba(255,255,255,0.35);
        color: #6b2b38;
        padding: 10px 14px;
    }

    .radio-item {
        background: rgba(255, 255, 255, 0.4);
        border: 2px solid #ffc4d5;
        border-radius: 20px;
        padding: 15px;
        transition: .25s;
    }
    .radio-item:hover {
        background: rgba(255,255,255,0.6);
    }

    .btn-pink {
        background: #c96a7f;
        color: white;
        padding: 10px 25px;
        border-radius: 20px;
        font-weight: bold;
        transition: .2s;
    }
    .btn-pink:hover {
        background: #a44c61;
    }

    .btn-back {
        display: inline-block;
        background: #c96a7f;
        color: white;
        padding: 8px 18px;
        border-radius: 18px;
        font-weight: 600;
        margin-bottom: 15px;
        transition: .2s;
    }
    .btn-back:hover {
        background: #a44c61;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen px-4 py-10">

    <div class="glass-container">

        <h1 class="text-3xl font-bold text-[#6b2b38] mb-4">Checkout</h1>

            {{-- Tombol Kembali --}}
<a href="{{ url()->previous() }}" 
   class="inline-block mb-4 px-4 py-2 bg-[#e5c3c8] hover:bg-[#d9aab2] text-[#6b2b38] font-semibold rounded-lg shadow">
    ← Kembali
</a>
        <form action="{{ route('member.checkout.store', $product->id) }}" method="POST">
            @csrf
            <input type="hidden" name="qty" value="1">

            {{-- Ringkasan Produk --}}
            <div class="glass-box">
                <h2 class="text-lg font-semibold text-[#6b2b38] mb-3">Ringkasan Pesanan</h2>

                <div class="flex items-center gap-4">
                    <img src="{{ $product->thumbnail_url ?? 'https://via.placeholder.com/120' }}"
                         class="w-20 h-20 rounded-xl object-cover">

                    <div>
                        <p class="font-semibold text-[#6b2b38]">{{ $product->name }}</p>
                        <p class="text-xs text-[#6b2b38] opacity-70">
                            Toko: {{ $product->store->name ?? 'Store' }}
                        </p>
                        <p class="font-bold text-[#6b2b38] mt-1">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <input type="hidden" name="product_id" value="{{ $product->id }}">
            </div>

            {{-- Alamat --}}
            <div class="glass-box">
                <h2 class="text-lg font-semibold text-[#6b2b38] mb-3">Alamat Pengiriman</h2>

                <textarea name="address" rows="3" class="w-full"
                          placeholder="Tulis alamat lengkap..." required>{{ old('address') }}</textarea>
            </div>

            {{-- Nomor HP --}}
<div class="glass-box">
    <h2 class="text-lg font-semibold text-[#6b2b38] mb-3">Nomor HP</h2>
    <input type="text" name="phone" class="w-full" 
           placeholder="Masukkan nomor HP aktif..." required
           value="{{ old('phone') }}">
</div>

            {{-- Pengiriman --}}
            <div class="glass-box">
                <h2 class="text-lg font-semibold text-[#6b2b38] mb-3">Metode Pengiriman</h2>

                @forelse($shippingTypes as $type)
                    <label class="radio-item flex items-center justify-between mb-2 cursor-pointer">
                        <div>
                            <p class="font-semibold text-[#6b2b38]">{{ $type->name }}</p>
                            <p class="text-xs text-[#6b2b38] opacity-70">
                                Estimasi {{ $type->estimate }}
                            </p>
                        </div>

                        <div class="flex items-center gap-3">
                            <p class="font-bold text-[#6b2b38]">
                                Rp {{ number_format($type->cost, 0, ',', '.') }}
                            </p>
                            <input type="radio" name="shipping_type_id" value="{{ $type->id }}" required>
                        </div>
                    </label>
                @empty
                    <p class="text-sm text-[#6b2b38] opacity-70">Belum ada metode pengiriman.</p>
                @endforelse
            </div>

            {{-- Pembayaran --}}
            <div class="glass-box">
                <h2 class="text-lg font-semibold text-[#6b2b38] mb-3">Metode Pembayaran</h2>

                <div class="grid md:grid-cols-2 gap-3">
                    <label class="radio-item flex justify-between cursor-pointer">
                        <div>
                            <p class="font-semibold text-[#6b2b38]">Saldo</p>
                            <p class="text-xs text-[#6b2b38] opacity-70">Gunakan saldo dompet.</p>
                        </div>
                        <input type="radio" name="payment_method" value="wallet" required>
                    </label>

                    <label class="radio-item flex justify-between cursor-pointer">
                        <div>
                            <p class="font-semibold text-[#6b2b38]">Virtual Account</p>
                            <p class="text-xs text-[#6b2b38] opacity-70">Transfer via VA bank.</p>
                        </div>
                        <input type="radio" name="payment_method" value="va" required>
                    </label>
                </div>
            </div>

            {{-- Tombol Submit --}}
<div class="text-right">
    <button type="submit" class="btn-pink">Buat Pesanan</button>
</div>

        </form>

    </div>

</div>
@endsection
