@extends('layouts.app')

@section('title', 'Topup Saldo')

@section('content')
<div class="bg-gradient-to-b from-purple-50 to-white min-h-screen py-8">
    <div class="max-w-md mx-auto px-4">

        <h1 class="text-2xl font-bold text-purple-800 mb-4">Topup Saldo</h1>

        <div class="bg-white rounded-2xl border border-purple-100 shadow-sm p-5">
            <form action="{{ route('wallet.topup.process') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nominal Topup
                    </label>
                    <input
                        type="number"
                        name="amount"
                        min="10000"
                        step="1000"
                        class="w-full text-sm border border-purple-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-300"
                        placeholder="Minimal 10.000"
                        required>
                </div>

                <button
                    class="w-full px-4 py-2.5 rounded-xl bg-purple-600 text-white text-sm font-semibold hover:bg-purple-700 transition">
                    Buat Permintaan Topup
                </button>
            </form>

            @isset($va_number)
                <div class="mt-5 p-3 rounded-xl bg-purple-50 border border-purple-100 text-sm">
                    <p class="font-semibold text-purple-800 mb-1">Virtual Account Topup</p>
                    <p class="text-gray-700">
                        Silakan transfer ke nomor VA berikut:
                    </p>
                    <p class="mt-1 text-lg font-mono font-bold text-purple-700">
                        {{ $va_number }}
                    </p>
                    <p class="mt-1 text-xs text-gray-500">
                        Setelah pembayaran terkonfirmasi, saldo kamu akan otomatis bertambah.
                    </p>
                </div>
            @endisset
        </div>

    </div>
</div>
@endsection
