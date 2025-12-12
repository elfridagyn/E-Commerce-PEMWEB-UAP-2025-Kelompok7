<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Saldo Toko</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
{{-- Memuat Font Awesome untuk ikon --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
<style>
/* --- WARNA INTI --- */
:root {
    --primary-color: #c96a7f; /* Merah Muda Gelap (Aksi) */
    --secondary-color: #6b2b38; /* Warna teks gelap */
    --background-start: #f5b8c8;
    --background-end: #d56e82;
    --glass-bg: rgba(255, 255, 255, 0.25);
    --glass-blur: 16px;
    --hover-color: #a44c61;
}

/* --- GLOBAL & BODY --- */
body { 
    font-family: 'Poppins', sans-serif; 
    /* Background Gradient */
    background: linear-gradient(135deg, var(--background-start), #e58fa2, var(--background-end));
    margin: 0; 
    padding: 40px 0;
    min-height: 100vh;
}

.container { 
    max-width: 900px; 
    margin: auto; 
    padding: 0 20px; 
}

/* --- CARD GLASSMORPHISM --- */
.card { 
    /* Gaya Glassmorphism */
    background: var(--glass-bg);
    backdrop-filter: blur(var(--glass-blur));
    padding: 25px; 
    border-radius: 20px; 
    margin-bottom: 25px; 
    box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.5);
}

h2 { 
    margin-top:0; 
    color: var(--secondary-color); 
    font-weight: 700;
    font-size: 1.5rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* --- BALANCE CARD --- */
.balance-card-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 15px;
}

.current-balance-amount {
    font-size: 2.5rem;
    font-weight: 900;
    color: var(--primary-color);
}

/* --- WITHDRAW BUTTON --- */
.btn-withdraw {
    padding: 12px 25px;
    border: none;
    border-radius: 10px;
    background: var(--primary-color);
    color: #fff;
    cursor: pointer;
    font-weight: 700;
    font-size: 1rem;
    transition: background 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 10px rgba(201, 106, 127, 0.4);
    text-decoration: none; /* Jika menggunakan tag <a> */
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-withdraw:hover {
    background: var(--hover-color);
    box-shadow: 0 6px 12px rgba(201, 106, 127, 0.5);
}

/* --- HISTORY TABLE --- */
table { 
    width:100%; 
    border-collapse:collapse; 
    margin-top:20px; 
    background: rgba(255, 255, 255, 0.8); /* Latar belakang semi-putih untuk keterbacaan tabel */
    border-radius: 10px;
    overflow: hidden;
}

th, td { 
    padding:15px; 
    text-align:left; 
    border-bottom:1px solid rgba(107, 43, 56, 0.1); 
    color: var(--secondary-color);
    font-size: 0.9rem;
}

th { 
    background: #ffc4d5; /* Merah muda muda */
    font-weight: 700;
    color: var(--secondary-color);
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

tr:last-child td {
    border-bottom: none;
}

/* Warna khusus untuk Tipe (Opsional) */
.type-credit { font-weight: 600; color: #388e3c; } /* Hijau untuk Pemasukan */
.type-debit { font-weight: 600; color: #d32f2f; } /* Merah untuk Pengeluaran (Withdraw) */

/* --- BACK BUTTON --- */
.back-button {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    color: #fff; /* Putih agar kontras dengan gradient body */
    margin-bottom: 20px;
    font-weight: 600;
    background: rgba(107, 43, 56, 0.6);
    padding: 8px 15px;
    border-radius: 8px;
    transition: background 0.2s;
}
.back-button:hover {
    background: var(--secondary-color);
}
</style>
</head>
<body>

<div class="container">
    {{-- Tombol Kembali (Diasumsikan kembali ke Seller Dashboard) --}}
    <a href="{{ route('seller.dashboard') }}" class="back-button">
        <i class="fas fa-arrow-left"></i> Dashboard Seller
    </a>

    {{-- Kartu Saldo Saat Ini --}}
    <div class="card">
        <h2><i class="fas fa-coins"></i> Saldo Toko Saat Ini</h2>
        <div class="balance-card-content">
            <p class="current-balance-amount">Rp {{ number_format($balance->balance ?? 0, 0, ',', '.') }}</p>
            
        </div>
    </div>

    {{-- Kartu Riwayat Saldo --}}
    <div class="card">
        <h2><i class="fas fa-history"></i> Riwayat Transaksi Saldo</h2>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Tipe</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($history as $h)
                <tr>
                    <td>{{ $h->created_at->format('d M Y H:i') }}</td>
                    {{-- Menambahkan class berdasarkan tipe (credit/debit) --}}
                    <td class="{{ $h->type == 'credit' ? 'type-credit' : 'type-debit' }}">{{ ucfirst($h->type) }}</td>
                    <td>Rp {{ number_format($h->amount,0,',','.') }}</td>
                    <td>{{ $h->remarks }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center; color: var(--secondary-color);">Belum ada riwayat saldo.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>