<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Top-Up Saldo</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

<style>
/* --- WARNA INTI --- */
:root {
    --primary-color: #c96a7f; /* Merah Muda Gelap (seperti button di home) */
    --secondary-color: #6b2b38; /* Warna teks gelap */
    --background-start: #f5b8c8;
    --background-end: #d56e82;
}

/* --- GLOBAL --- */
body { 
    font-family: 'Poppins', sans-serif; 
    /* Background Gradient seperti home */
    background: linear-gradient(135deg, var(--background-start), #e58fa2, var(--background-end));
    margin: 0; 
    padding: 40px 0;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

/* --- CONTAINER GLASSMORPHISM --- */
.container { 
    max-width: 450px; 
    width: 90%;
    /* Gaya Glassmorphism */
    background: rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(16px);
    padding: 30px; 
    border-radius: 20px; 
    box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.5);
}

h2 { 
    text-align: center; 
    color: var(--secondary-color); 
    margin-bottom: 25px; 
    font-weight: 700;
}

/* --- FORM ELEMENTS --- */
label {
    display: block;
    color: var(--secondary-color);
    font-weight: 600;
    margin-bottom: 8px;
}

input[type="number"] { 
    width: 100%; 
    padding: 12px 15px; 
    margin-bottom: 20px; 
    border-radius: 10px; 
    border: 2px solid var(--primary-color);
    background: rgba(255, 255, 255, 0.6); /* Sedikit transparan */
    color: var(--secondary-color);
    font-size: 16px;
    transition: border-color 0.3s;
    box-sizing: border-box; /* Penting agar padding tidak melebarkan input */
}
input[type="number"]:focus {
    border-color: #a44c61;
    outline: none;
    background: #fff;
}
input::placeholder {
    color: rgba(107, 43, 56, 0.6);
}

/* --- BUTTON SUBMIT --- */
.btn-submit { 
    padding: 12px 20px; 
    border:none; 
    border-radius:10px; 
    background: var(--primary-color); 
    color:#fff; 
    cursor:pointer; 
    width:100%; 
    font-weight:700; 
    font-size: 1.1rem;
    transition: background 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 10px rgba(201, 106, 127, 0.4);
}
.btn-submit:hover { 
    background: #a44c61; /* Warna hover yang lebih gelap */
    box-shadow: 0 6px 12px rgba(201, 106, 127, 0.5);
}

/* --- STATUS & BALANCE --- */
.success { 
    background: rgba(76, 175, 80, 0.8);
    color: #fff;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 15px; 
    font-weight: 600;
    text-align: center;
}

.current-balance {
    margin-top:25px;
    text-align: center;
    color: var(--secondary-color);
    font-size: 1rem;
    padding: 10px;
    background: rgba(255, 255, 255, 0.5);
    border-radius: 10px;
    font-weight: 600;
}
.balance-amount {
    font-weight: 900;
    font-size: 1.5rem;
    display: block;
    color: var(--primary-color);
    margin-top: 5px;
}

/* --- BACK BUTTON --- */
.back-button {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    color: var(--secondary-color);
    margin-bottom: 20px;
    font-weight: 600;
    transition: color 0.2s;
}
.back-button:hover {
    color: var(--primary-color);
}
</style>
</head>
<body>

<div class="container">
    
    {{-- Tombol Kembali --}}
    <a href="{{ route('member.dashboard') }}" class="back-button">
        <i class="fas fa-arrow-left"></i> Kembali ke Beranda
    </a>

    <h2><i class="fas fa-wallet"></i> Top-Up Saldo Anda</h2>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <div class="current-balance">
        Saldo Anda Saat Ini: 
        <span class="balance-amount">Rp {{ number_format(auth()->user()->balance, 0, ',', '.') }}</span>
    </div>
    
    <form action="{{ route('member.topup.store') }}" method="POST" style="margin-top: 25px;">
        @csrf
        <label for="amount">Masukkan Jumlah Top-Up (Minimum Rp 1.000)</label>
        <input type="number" name="amount" id="amount" required min="1000" placeholder="Contoh: 50000" value="{{ old('amount') }}">

        @error('amount')
            <p style="color:red; font-size: 0.9em; margin-top: -15px; margin-bottom: 15px;">{{ $message }}</p>
        @enderror

        <button type="submit" class="btn-submit">Top-Up Sekarang</button>
    </form>

</div>

</body>
</html>