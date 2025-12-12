<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pesanan Masuk - Seller</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

<style>
/* --- Gaya Mirip Contoh Kedua --- */
body {
    font-family: 'Poppins', sans-serif;
    /* Menggunakan gradien yang serupa */
    background: linear-gradient(135deg, #f3b8c8, #e38fa2, #d86e82);
    margin: 0;
    padding: 40px 0;
}

.top-navbar {
    display: flex;
    justify-content: space-between; 
    align-items: center; 
    margin-bottom: 30px;
    padding: 0 40px;
    position: relative;
    z-index: 1000;
}

.back-to-dashboard {
    display: flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    background: rgba(255, 255, 255, 0.35);
    backdrop-filter: blur(10px);
    padding: 10px 18px;
    border-radius: 30px;
    color: #6b2b38;
    font-weight: 600;
    box-shadow: 0px 4px 12px rgba(0,0,0,0.15);
    transition: 0.3s;
}

.back-to-dashboard:hover {
    background: rgba(255, 255, 255, 0.5);
    transform: scale(1.02);
}

.nav-right {
    display: flex;
    align-items: center;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(255, 255, 255, 0.35);
    padding: 10px 18px;
    border-radius: 30px;
    backdrop-filter: blur(10px);
    position: relative;
    color: #6b2b38;
    font-weight: 600;
    box-shadow: 0px 4px 12px rgba(0,0,0,0.15);
}

.avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    object-fit: cover;
    background: #f3e5e8;
    border: 2px solid rgba(255, 255, 255, 0.8);
}
/* --- Akhir Gaya Mirip Contoh Kedua --- */

.container { max-width: 1200px; margin: auto; padding: 0 40px; }

.title-box {
    background: rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(12px);
    padding: 35px;
    border-radius: 18px;
    box-shadow: 0px 10px 25px rgba(0,0,0,0.15);
    text-align: center;
    margin-bottom: 25px;
    border-left: 8px solid #c96a7f; /* Warna Pink/Maroon */
}

.title-box i { font-size: 3rem; color: #c96a7f; }
.title-box h2 { margin-top: 12px; font-size: 2rem; font-weight: 700; color: #6b2b38; /* Warna Maroon */ }
.title-box p { color: #6b2b38; margin: 0; } /* Menambahkan paragraf jika ada */

.table-box {
    background: rgba(255,255,255,0.4);
    backdrop-filter: blur(10px);
    padding: 25px;
    border-radius: 16px;
    box-shadow: 0px 10px 25px rgba(0,0,0,0.15);
    overflow-x: auto; /* Untuk responsivitas tabel */
}

table { width: 100%; border-collapse: collapse; font-size: 15px; min-width: 800px; /* Tambahkan min-width agar tidak terlalu kecil */ }
th, td { padding: 14px; text-align: left; color: #6b2b38; border-bottom: 1px solid rgba(107, 43, 56, 0.2); }
th { background: #c96a7f; color: #fff; font-weight: 700; border-bottom: none; } /* Warna Pink/Maroon untuk header */

tr { background: rgba(255,255,255,0.4); }
tr:hover { background: rgba(255,255,255,0.7); }

/* Styling untuk list produk di dalam tabel */
td ul { list-style: none; padding: 0; margin: 0; }
td ul li { margin-bottom: 3px; }

/* Styling untuk pesan sukses */
.alert-success {
    background: rgba(76, 175, 80, 0.8); /* Hijau */
    color: white;
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 8px;
    font-weight: 600;
    text-align: center;
    box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
}

/* Styling Form Aksi */
form { 
    display: flex; 
    gap: 8px; 
    align-items: center; 
}

input[type="text"], select { 
    padding: 8px 10px; 
    border-radius: 8px; 
    border: 1px solid #c96a7f; 
    background: rgba(255, 255, 255, 0.9);
    color: #6b2b38;
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);
}

select {
    width: auto; /* Agar tidak mengambil seluruh lebar */
}

button[type="submit"] { 
    padding: 8px 15px; 
    border: none; 
    border-radius: 8px; 
    background: #4caf50; /* Hijau untuk Update */
    color: #fff; 
    cursor: pointer; 
    font-weight: 600;
    transition: 0.2s;
}

button[type="submit"]:hover { 
    background: #388e3c; 
}

/* Styling untuk jika tidak ada data */
.no-orders {
    text-align: center;
    padding: 20px;
    font-weight: 600;
    color: #6b2b38;
}

</style>
</head>
<body>

<div class="top-navbar">
    <a href="{{ route('seller.dashboard') }}" class="back-to-dashboard">
        <i class="fas fa-arrow-left"></i>
        <span>Dashboard</span>
    </a>

    <div class="nav-right">
        <div class="user-info">
            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" class="avatar" alt="Avatar Pengguna">
            <span>{{ auth()->user()->name }}</span>
        </div>
    </div>
</div>

<div class="container">

    <div class="title-box">
        <i class="fas fa-box-open"></i>
        <h2>Kelola Pesanan Masuk</h2>
        <p>Lihat dan perbarui status pesanan dari pembeli.</p>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-box">
        <table>
            <tr>
                <th>Kode Pesanan</th>
                <th>Buyer</th>
                <th>Produk</th>
                <th>Status</th>
                <th>Tracking Number</th>
                <th>Aksi</th>
            </tr>

            @forelse($orders as $order)
            <tr>
                <td>{{ $order->code }}</td>
                <td>{{ $order->buyer->name ?? '-' }}</td>
                <td>
                    <ul>
                    @foreach($order->transactionDetails as $detail)
                        @if($detail->product->store_id == auth()->user()->store->id)
                            <li>{{ $detail->product->name }} ({{ $detail->quantity }})</li>
                        @endif
                    @endforeach
                    </ul>
                </td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->tracking_number ?? '-' }}</td>
                <td>
                    <form action="{{ route('seller.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="status" required>
                            <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Pending</option>
                            <option value="processing" {{ $order->status=='processing'?'selected':'' }}>Processing</option>
                            <option value="shipped" {{ $order->status=='shipped'?'selected':'' }}>Shipped</option>
                            <option value="completed" {{ $order->status=='completed'?'selected':'' }}>Completed</option>
                            <option value="cancelled" {{ $order->status=='cancelled'?'selected':'' }}>Cancelled</option>
                        </select>
                        <input type="text" name="tracking_number" placeholder="Tracking #" value="{{ $order->tracking_number }}">
                        <button type="submit"><i class="fas fa-check"></i> Update</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="no-orders">Tidak ada pesanan masuk.</td>
            </tr>
            @endforelse
        </table>
    </div>
</div>

</body>
</html>