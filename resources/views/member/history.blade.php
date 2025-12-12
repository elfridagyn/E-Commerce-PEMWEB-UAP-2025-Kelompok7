@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@push('styles')
{{-- Memuat Font Awesome jika dibutuhkan (opsional di sini, tapi baik untuk konsistensi) --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

<style>
/* --- FONT & BACKGROUND GLOBAL (PINK/UNGU) --- */
body {
    font-family: 'Poppins', sans-serif;
    /* Background Gradient Pink/Purple sesuai tema GyZal */
    background: linear-gradient(135deg, #f5b8c8, #e58fa2, #d56e82); 
    min-height: 100vh;
}

/* --- WRAPPER UTAMA (MAX-W) --- */
.history-container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 40px;
}

/* --- Ganti Gaya Tombol Kembali (Dipindah ke atas) --- */
.btn-back {
    display: inline-flex; /* Menggunakan flex untuk ikon dan teks */
    align-items: center;
    padding: 8px 15px; /* Padding lebih kecil */
    background-color: #c96a7f; /* Warna pink dari tema GyZal */
    color: white;
    font-weight: 600;
    border-radius: 20px; /* Lebih bulat */
    transition: background-color 0.2s;
    text-decoration: none;
    margin-bottom: 25px; /* Jarak ke judul */
    box-shadow: 0 3px 8px rgba(201, 106, 127, 0.4);
}

.btn-back:hover {
    background-color: #a44c61;
}

/* --- JUDUL --- */
.history-container h1 {
    font-size: 2rem;
    font-weight: 700;
    color: #6b2b38; /* Warna teks gelap yang cocok dengan tema pink */
    margin-bottom: 25px;
    text-shadow: 1px 1px 3px rgba(255, 255, 255, 0.4);
}

/* --- KARTU TRANSAKSI (Glassmorphism Card) --- */
.transaction-card {
    background: rgba(255, 255, 255, 0.4); /* Transparan */
    backdrop-filter: blur(12px); /* Efek Blur */
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.6); /* Border putih tipis */
    transition: transform 0.3s ease;
}

.transaction-card:hover {
    transform: translateY(-3px);
    box-shadow: 0px 12px 35px rgba(0, 0, 0, 0.15);
}

/* Header Transaksi */
.transaction-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid rgba(107, 43, 56, 0.2); /* Garis pemisah */
}

.transaction-header .code {
    font-size: 1.25rem;
    font-weight: 800;
    color: #6b2b38;
}

/* Info Detail (Tanggal, Metode, Kirim) */
.transaction-details {
    color: #8c5765; /* Warna teks detail */
    font-size: 0.9rem;
    line-height: 1.6;
}

.transaction-details .font-semibold {
    color: #6b2b38;
}

/* Total Pembayaran */
.total-payment {
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px dashed rgba(107, 43, 56, 0.3);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.total-payment .label {
    font-size: 1.1rem;
    font-weight: 700;
    color: #6b2b38;
}

.total-payment .amount {
    font-size: 1.6rem;
    font-weight: 900;
    color: #d53d5f; /* Warna merah muda yang kuat */
}

/* Detail Produk */
.product-detail-box {
    margin-top: 15px;
    padding: 12px;
    background: rgba(255, 255, 255, 0.6); /* Background lebih terang */
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.8);
}

.product-detail-box .font-semibold {
    color: #6b2b38;
}

.product-detail-box ul {
    padding-left: 20px;
    margin-top: 5px;
    color: #8c5765;
}

/* Override utility bawaan Tailwind yang mungkin bertabrakan dengan Glassmorphism */
.space-y-4 > div {
    /* Menghapus gaya bawaan jika ada */
}

</style>
@endpush

@section('content')
<div class="history-container">
    
    {{-- TOMBOL KEMBALI KE BERANDA (DIPINDAH KE POJOK ATAS) --}}
    <a href="{{ route('member.dashboard') }}" 
        class="btn-back">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Beranda
    </a>

    <h1 class="">Riwayat Transaksi</h1>
    
    {{-- Pesan Sukses --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 shadow-md" role="alert">
            <i class="fas fa-check-circle mr-2"></i> 
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="space-y-6"> 
        {{-- Looping menggunakan $transactions --}}
        @forelse($transactions as $transaction)
            <div class="transaction-card">
                <div class="transaction-header">
                    <div>
                        <span class="font-semibold text-sm text-gray-700 block">Kode Transaksi:</span>
                        <span class="code">{{ $transaction->code }}</span>
                    </div>
                    {{-- Badge Status --}}
                    <span class="text-xs font-semibold px-3 py-1 rounded-full 
                        {{ $transaction->status == 'completed' ? 'bg-green-200 text-green-800' : 
                          ($transaction->status == 'pending' ? 'bg-yellow-200 text-yellow-800' : 
                          ($transaction->status == 'cancelled' ? 'bg-red-200 text-red-800' : 'bg-gray-200 text-gray-800')) }}">
                        {{ strtoupper($transaction->status) }}
                    </span>
                </div>
                
                <div class="grid grid-cols-2 gap-y-2 transaction-details">
                    <div>
                        <span class="font-semibold">Tanggal:</span>
                        <span>{{ $transaction->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="font-semibold">Metode Pembayaran:</span>
                        <span>{{ strtoupper($transaction->payment_method) }}</span>
                    </div>
                    <div>
                        <span class="font-semibold">Tipe Kirim:</span>
                        <span>{{ $transaction->shipping_type ?? 'Digital/Non-Fisik' }}</span>
                    </div>
                </div>
                
                <div class="total-payment">
                    <span class="label">Total Pembayaran:</span>
                    <span class="amount">
                        Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                    </span>
                </div>

                <div class="product-detail-box">
                    <span class="font-semibold block mb-2 text-md">Detail Produk:</span>
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach($transaction->transactionDetails as $item)
                            @if($item->product) 
                                <li>
                                    {{ $item->product->name }} ({{ $item->qty }}x) 
                                    <span class="font-bold">- Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </li>
                            @else
                                <li>Produk tidak ditemukan (ID: {{ $item->product_id }})</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                
            </div>
        @empty
            <div class="text-center p-8 transaction-card">
                <i class="fas fa-box-open text-5xl text-gray-400 mb-3"></i>
                <p class="text-gray-600 font-semibold">Anda belum memiliki riwayat transaksi.</p>
            </div>
        @endforelse
    </div>
    
    {{-- Bagian ini dihapus karena tombol sudah dipindah ke atas
    <div class="mt-8">
        <a href="{{ route('member.dashboard') }}" 
            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
            Kembali ke Home
        </a>
    </div> --}}
</div>
@endsection