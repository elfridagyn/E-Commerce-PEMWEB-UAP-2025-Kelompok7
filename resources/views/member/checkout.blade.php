@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="bg-gradient-to-b from-purple-50 to-white min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4">

        <h1 class="text-2xl font-bold text-purple-800 mb-4">Checkout</h1>

        <form action="{{ route('checkout.process') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Ringkasan Produk --}}
            <div class="bg-white rounded-2xl border border-purple-100 shadow-sm p-5">
                <h2 class="text-lg font-semibold mb-3">Ringkasan Pesanan</h2>
                <div class="flex items-center gap-4">
                    <img src="{{ $product->thumbnail_url ?? 'https://via.placeholder.com/120x120?text=Product' }}"
                         class="w-20 h-20 rounded-xl object-cover">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $product->name }}</p>
                        <p class="text-sm text-gray-500">Toko: {{ $product->store->name ?? 'Store' }}</p>
                        <p class="mt-1 text-purple-700 font-bold">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
                <input type="hidden" name="product_id" value="{{ $product->id }}">
            </div>

            {{-- Alamat --}}
            <div class="bg-white rounded-2xl border border-purple-100 shadow-sm p-5">
                <h2 class="text-lg font-semibold mb-3">Alamat Pengiriman</h2>
                <textarea
                    name="address"
                    rows="3"
                    class="w-full text-sm border border-purple-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-300"
                    placeholder="Tulis alamat lengkap pengiriman..."
                    required>{{ old('address') }}</textarea>
            </div>

            {{-- Pengiriman --}}
            <div class="bg-white rounded-2xl border border-purple-100 shadow-sm p-5">
                <h2 class="text-lg font-semibold mb-3">Metode Pengiriman</h2>
                <div class="space-y-2">
                    @foreach ($shippingTypes as $type)
                        <label class="flex items-center justify-between border border-purple-100 rounded-xl px-3 py-2 text-sm cursor-pointer hover:bg-purple-50">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $type->name }}</p>
                                <p class="text-xs text-gray-500">Estimasi {{ $type->estimate }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <p class="text-purple-700 font-bold">
                                    Rp {{ number_format($type->cost, 0, ',', '.') }}
                                </p>
                                <input type="radio" name="shipping_type_id" value="{{ $type->id }}" required>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Pembayaran --}}
            <div class="bg-white rounded-2xl border border-purple-100 shadow-sm p-5">
                <h2 class="text-lg font-semibold mb-3">Metode Pembayaran</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">

                    <label class="border border-purple-200 rounded-2xl px-4 py-3 cursor-pointer flex items-center justify-between hover:bg-purple-50">
                        <div>
                            <p class="font-semibold text-gray-800">Saldo</p>
                            <p class="text-xs text-gray-500">Gunakan saldo dompet kamu.</p>
                        </div>
                        <input type="radio" name="payment_method" value="wallet" required>
                    </label>

                    <label class="border border-purple-200 rounded-2xl px-4 py-3 cursor-pointer flex items-center justify-between hover:bg-purple-50">
                        <div>
                            <p class="font-semibold text-gray-800">Virtual Account</p>
                            <p class="text-xs text-gray-500">Bayar melalui transfer bank VA.</p>
                        </div>
                        <input type="radio" name="payment_method" value="va" required>
                    </label>

                </div>
            </div>

            {{-- Submit --}}
            <div class="flex justify-end">
                <button
                    class="px-6 py-2.5 rounded-xl bg-purple-600 text-white text-sm font-semibold hover:bg-purple-700 transition">
                    Buat Pesanan
                </button>
            </div>

        </form>

    </div>
</div>
@endsection