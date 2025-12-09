@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="bg-gradient-to-b from-purple-50 to-white min-h-screen py-8">
    <div class="max-w-5xl mx-auto px-4">
        <h1 class="text-2xl font-bold text-purple-800 mb-4">Riwayat Transaksi</h1>

        <div class="space-y-4">
            @forelse ($transactions as $trx)
                <div class="bg-white border border-purple-100 rounded-2xl shadow-sm p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs text-gray-400">Kode Transaksi</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $trx->code }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                Tanggal: {{ $trx->created_at->format('d M Y H:i') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-400">Total</p>
                            <p class="text-sm font-bold text-purple-700">
                                Rp {{ number_format($trx->total, 0, ',', '.') }}
                            </p>
                            <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[10px] font-semibold
                                @if($trx->status === 'paid') bg-green-100 text-green-700
                                @elseif($trx->status === 'pending') bg-yellow-100 text-yellow-700
                                @else bg-gray-100 text-gray-600 @endif">
                                {{ strtoupper($trx->status) }}
                            </span>
                        </div>
                    </div>

                    {{-- Detail produk --}}
                    <div class="mt-3 border-t border-purple-50 pt-2">
                        <p class="text-xs text-gray-400 mb-1">Produk:</p>
                        <ul class="text-xs text-gray-700 list-disc list-inside space-y-0.5">
                            @foreach ($trx->details as $detail)
                                <li>{{ $detail->product->name }} ({{ $detail->qty }}x)</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500">Kamu belum pernah melakukan transaksi.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
