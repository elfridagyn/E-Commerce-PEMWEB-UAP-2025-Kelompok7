<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Penarikan Dana</title>
    
    {{-- FONT DAN ICON EKSTERNAL --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    
    {{-- STYLING CSS --}}
    <style>
        /* ========================================================== */
        /* 1. VARIBEL WARNA & GLASSMORPHISM BASE (Diambil dari Form Style) */
        /* ========================================================== */
        :root {
            --primary-color: #c96a7f;
            --secondary-color: #6b2b38;
            --background-start: #f5b8c8;
            --background-end: #d56e82;
            --glass-bg: rgba(255, 255, 255, 0.3); /* Lebih opaque */
            --glass-blur: 16px;
            --hover-color: #a44c61;
        }

        /* ========================================================== */
        /* 2. BODY & CONTAINER */
        /* ========================================================== */
        body { 
            font-family: 'Poppins', sans-serif; 
            background: linear-gradient(135deg, var(--background-start), #e58fa2, var(--background-end));
            margin: 0; 
            padding: 40px 0;
            min-height: 100vh;
        }

        .container { 
            max-width: 900px; /* Diperlebar untuk tabel */
            margin: auto; 
            padding: 0 20px;
        }

        /* ========================================================== */
        /* 3. JUDUL, BACK BUTTON, DAN CARD BASE */
        /* ========================================================== */
        
        /* Kartu Glassmorphism */
        .card { 
            background: var(--glass-bg);
            backdrop-filter: blur(var(--glass-blur));
            padding: 25px; 
            border-radius: 20px; 
            margin-bottom: 25px; 
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2); /* Shadow lebih kuat */
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        /* Judul (Disesuaikan agar rata kiri di halaman index) */
        h2 { 
            margin-top:0; 
            color: var(--secondary-color); 
            font-weight: 700;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
            justify-content: flex-start; /* Rata Kiri */
            margin-bottom: 20px;
        }

        /* Tombol Kembali ke Dashboard (BARU) */
        .dashboard-button {
            position: absolute;
            top: 20px;
            left: 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: var(--secondary-color);
            padding: 10px 15px;
            border-radius: 10px;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.7);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.2s;
            z-index: 10;
        }
        .dashboard-button:hover {
            color: var(--primary-color);
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        
        /* ========================================================== */
        /* 4. TOMBOL DAN CARD AKSI */
        /* ========================================================== */
        .card-action {
            background: var(--glass-bg);
            backdrop-filter: blur(var(--glass-blur));
            padding: 15px 25px;
            border-radius: 20px; 
            margin-bottom: 25px; 
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.5);
            display: flex;
            justify-content: flex-end;
        }

        .btn-primary { 
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
            text-decoration: none; 
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            background: var(--hover-color);
            box-shadow: 0 6px 12px rgba(201, 106, 127, 0.5);
            color: #fff; 
        }

        /* ========================================================== */
        /* 5. TABEL RIWAYAT */
        /* ========================================================== */
        table.table { 
            width:100%; 
            border-collapse:collapse; 
            /* Background tabel disesuaikan dengan gaya form (lebih solid) */
            background: rgba(255, 255, 255, 0.8); 
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
            background: #ffc4d5; 
            font-weight: 700;
            color: var(--secondary-color);
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        tr:last-child td {
            border-bottom: none;
        }
        
        /* ========================================================== */
        /* 6. STATUS BADGE & ALERT */
        /* ========================================================== */
        .badge {
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: 600;
            font-size: 0.8rem;
            line-height: 1; 
            display: inline-block;
        }

        .bg-success { background-color: #388e3c; color: white; }
        .bg-danger { background-color: #d32f2f; color: white; }
        .bg-warning.text-dark { background-color: #ffc4d5; color: var(--secondary-color); }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
            font-weight: 600;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* UTILITY (d-flex/mb/mt) - Menggantikan class Bootstrap dasar */
        .d-flex { display: flex; }
        .justify-content-end { justify-content: flex-end; }
        .justify-content-center { justify-content: center; }
        .mb-4 { margin-bottom: 1.5rem; }
        .mb-3 { margin-bottom: 1rem; }
        .mt-3 { margin-top: 1rem; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    {{-- BARU: TOMBOL KE DASHBOARD DI POJOK KIRI ATAS --}}
    <a href="{{ route('seller.dashboard') }}" class="dashboard-button">
        <i class="fas fa-tachometer-alt"></i> Kembali ke Dashboard
    </a>

<div class="container">
    
    {{-- AKSI UTAMA: KOTAK TOMBOL AJUKAN PENARIKAN --}}
    <div class="card-action">
         <a href="{{ route('seller.withdrawals.create') }}" class="btn btn-primary">
             <i class="fas fa-money-bill-wave"></i> Ajukan Penarikan Baru
         </a>
    </div>

    <h2><i class="fas fa-history"></i> Riwayat Penarikan Dana</h2>
    
    {{-- ALERT MESSAGES --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- KARTU UTAMA: DAFTAR RIWAYAT --}}
    <div class="card mb-4">
        
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Jumlah</th>
                    <th>Bank Tujuan</th>
                    <th>Nama Pemilik</th> 
                    <th>No. Rekening</th>
                    <th>Status</th>
                    <th>Tanggal Pengajuan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($withdrawals as $withdrawal)
                <tr>
                    <td>#{{ $withdrawal->id }}</td>
                    <td>Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</td>
                    
                    {{-- Detail Bank --}}
                    <td>{{ $withdrawal->bank_name }}</td>
                    <td>{{ $withdrawal->bank_account_name }}</td> 
                    <td>{{ $withdrawal->bank_account_number }}</td>
                    
                    <td>
                        {{-- Logika Status --}}
                        <span class="badge 
                            @if($withdrawal->status == 'completed') bg-success
                            @elseif($withdrawal->status == 'rejected') bg-danger
                            @else bg-warning text-dark
                            @endif">
                            {{ ucfirst($withdrawal->status) }}
                        </span>
                    </td>
                    <td>{{ $withdrawal->created_at->format('d M Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada riwayat penarikan dana.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- PAGINATION --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $withdrawals->links() }}
        </div>
    </div>
</div>
</body>
</html>