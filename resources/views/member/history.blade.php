@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="bg-gradient-to-b from-purple-50 to-white min-h-screen py-8">
    <div class="max-w-5xl mx-auto px-4">
        <h1 class="text-2xl font-bold text-purple-800 mb-4">Riwayat Transaksi</h1>

        <div class="space-y-4">
            @if($transaction)
                <div class="border p-4 rounded-lg shadow-sm">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-semibold">Kode Transaksi:</span>
                        <span>{{ $transaction->code }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-semibold">Tanggal:</span>
                        <span>{{ $transaction->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-semibold">Total:</span>
                        <span>
                            Rp {{ number_format($transaction->grand_total ?? $transaction->details->sum(fn($item) => $item->subtotal), 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="mt-2">
                        <span class="font-semibold">Produk:</span>
                        <ul class="list-disc list-inside">
                            @foreach($transaction->details as $item)
                                <li>{{ $item->product->name }} ({{ $item->qty }}x)</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @else
                <p class="text-gray-500">Belum ada transaksi.</p>
            @endif
        </div>

        <!-- Tombol selalu muncul di luar if/else -->
        <div class="mt-6">
            <a href="{{ route('member.dashboard') }}" 
               class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
               Kembali ke Home
            </a>
        </div>
    </div>
</div>
@endsection
