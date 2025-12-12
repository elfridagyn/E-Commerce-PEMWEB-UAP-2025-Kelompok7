<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tarik Saldo Toko</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

<style>
/* --- WARNA INTI (DARI CONTOH ANDA) --- */
:root {
    --primary-color: #c96a7f; /* Merah Muda Gelap (Aksi) */
    --secondary-color: #6b2b38; /* Warna teks gelap */
    --background-start: #f5b8c8;
    --background-end: #d56e82;
    --glass-bg: rgba(255, 255, 255, 0.3); /* Sedikit lebih opaque untuk form */
    --glass-blur: 16px;
    --hover-color: #a44c61;
}

/* --- GLOBAL & BODY --- */
body { 
    font-family: 'Poppins', sans-serif; 
    background: linear-gradient(135deg, var(--background-start), #e58fa2, var(--background-end));
    margin: 0; 
    padding: 40px 0;
    min-height: 100vh;
    /* Tambahan untuk menengahkan form */
    display: flex;
    justify-content: center;
    align-items: flex-start; /* Ubah dari center agar tidak terlalu rendah */
}

/* --- CONTAINER GLASSMORPHISM (Disesuaikan untuk Form) --- */
.container { 
    max-width: 500px; /* Lebar lebih kecil untuk form */
    width: 90%;
    /* Gaya Glassmorphism */
    background: var(--glass-bg);
    backdrop-filter: blur(var(--glass-blur));
    padding: 30px; /* Padding lebih besar */
    border-radius: 20px; 
    box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.5);
    margin: 40px auto; /* Margin atas dan bawah */
}

h2 { 
    margin-top:0; 
    color: var(--secondary-color); 
    font-weight: 700;
    font-size: 1.8rem; /* Lebih besar dari halaman index */
    text-align: center;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    justify-content: center; /* Tengahkan ikon dan judul */
    gap: 10px;
}

/* --- BACK BUTTON (DARI CONTOH ANDA) --- */
.back-button {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    color: var(--secondary-color); /* Ubah ke warna gelap agar kontras di latar belakang form */
    margin-bottom: 20px;
    font-weight: 600;
    transition: color 0.2s;
}
.back-button:hover {
    color: var(--primary-color);
}


/* --- FORM ELEMENTS (Baru ditambahkan/Disesuaikan) --- */
label {
    display: block;
    color: var(--secondary-color);
    font-weight: 600;
    margin-bottom: 5px;
    font-size: 0.95rem;
}

input:not([type="submit"]),
select {
    width: 100%;
    padding: 10px 15px;
    margin-bottom: 15px;
    border-radius: 10px;
    border: 2px solid var(--primary-color);
    background: rgba(255, 255, 255, 0.8); /* Latar belakang semi-putih agar jelas */
    color: var(--secondary-color);
    font-size: 16px;
    transition: border-color 0.3s;
    box-sizing: border-box;
}

input:not([type="submit"]):focus,
select:focus {
    border-color: var(--hover-color);
    outline: none;
    background: #fff;
}

input::placeholder {
    color: rgba(107, 43, 56, 0.6);
}

/* --- BUTTON SUBMIT (Menggantikan .btn-withdraw, Disesuaikan) --- */
.btn-submit {
    padding: 12px 20px;
    border: none;
    border-radius: 10px;
    background: var(--primary-color);
    color: #fff;
    cursor: pointer;
    width: 100%;
    font-weight: 700;
    font-size: 1.1rem;
    margin-top: 15px;
    transition: background 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 10px rgba(201, 106, 127, 0.4);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-submit:hover {
    background: var(--hover-color);
    box-shadow: 0 6px 12px rgba(201, 106, 127, 0.5);
}

/* --- Pesan Error/Saldo (Jika Ada) --- */
.error-message {
    color: #d32f2f;
    font-size: 0.85rem;
    margin-top: -10px;
    margin-bottom: 15px;
    display: block;
}
</style>
</head>

<body>
    <div class="container">

        <a href="{{ route('seller.withdrawals.index') }}" class="back-button">
            <i class="fas fa-arrow-left"></i> Kembali ke Riwayat Penarikan
        </a>

        <h2><i class="fas fa-money-check-alt"></i> Tarik Saldo Toko</h2>

        {{-- Tampilkan pesan sukses atau error (Tambahkan di sini jika ada) --}}
        {{-- @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif --}}
        {{-- @if(session('error')) <div class="alert alert-error">{{ session('error') }}</div> @endif --}}

        {{-- TAMPILAN SALDO DENGAN STYLE DARI INDEX --}}
        <p style="text-align: center; color: var(--secondary-color); font-weight: 600; margin-bottom: 20px;">
            Saldo Tersedia: <span style="font-size: 1.2rem; font-weight: 900; color: var(--primary-color);">
                Rp {{ number_format($balance->balance ?? 0, 0, ',', '.') }}
            </span>
        </p>

        <form action="{{ route('seller.withdrawals.store') }}" method="POST">
            @csrf

            {{-- Tambahkan Field Form di Sini --}}
            {{-- Jumlah Penarikan --}}
            <label for="amount">Jumlah Penarikan</label>
            <input type="number" name="amount" id="amount" required min="10000" placeholder="Minimum Rp 10.000" value="{{ old('amount') }}">
            {{-- @error('amount') <span class="error-message">{{ $message }}</span> @enderror --}}

            {{-- Metode Penarikan (Bank) --}}
            <label for="bank_name">Pilih Bank Tujuan</label>
            <select name="bank_name" id="bank_name" required>
                <option value="">-- Pilih Bank --</option>
                <option value="BCA" {{ old('bank_name') == 'BCA' ? 'selected' : '' }}>Bank BCA</option>
                <option value="Mandiri" {{ old('bank_name') == 'Mandiri' ? 'selected' : '' }}>Bank Mandiri</option>
                <option value="BRI" {{ old('bank_name') == 'BRI' ? 'selected' : '' }}>Bank BRI</option>
                <option value="BNI" {{ old('bank_name') == 'BNI' ? 'selected' : '' }}>Bank BNI</option>
                <option value="CIMB" {{ old('bank_name') == 'CIMB' ? 'selected' : '' }}>Bank CIMB Niaga</option>
            </select>
            {{-- @error('bank_name') <span class="error-message">{{ $message }}</span> @enderror --}}

            {{-- Nomor Rekening (Menggunakan 'account_number' untuk input) --}}
            <label for="account_number">Nomor Rekening</label>
            <input type="text" name="account_number" id="account_number" required placeholder="Masukkan Nomor Rekening" value="{{ old('account_number') }}">
            {{-- @error('account_number') <span class="error-message">{{ $message }}</span> @enderror --}}

            {{-- Nama Pemilik Rekening (Menggunakan 'account_holder' untuk input) --}}
            <label for="account_holder">Nama Pemilik Rekening</label>
            <input type="text" name="account_holder" id="account_holder" required placeholder="Sesuai Nama di Rekening Bank" value="{{ old('account_holder') }}">
            {{-- @error('account_holder') <span class="error-message">{{ $message }}</span> @enderror --}}

            <button type="submit" class="btn-submit"><i class="fas fa-paper-plane"></i> Ajukan Penarikan</button>
        </form>

    </div>
</body>
</html>