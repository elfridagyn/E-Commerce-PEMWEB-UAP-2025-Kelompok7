<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk - Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f3b8c8, #e38fa2, #d86e82);
            margin: 0;
            padding: 40px 0;
        }

        /* NAVBAR */
        .top-navbar {
            /* PERBAIKAN: Mengatur agar konten menyebar ke kiri dan kanan */
            display: flex;
            justify-content: space-between; 
            align-items: center; /* Tambahkan agar item sejajar di tengah secara vertikal */
            margin-bottom: 30px;
            padding: 0 40px;
            position: relative;
            z-index: 1000;
        }

        /* TOMBOL KEMBALI KE DASHBOARD */
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

        .back-to-dashboard i {
            font-size: 16px;
        }

        .nav-right {
            position: relative;
            display: flex;
            align-items: center;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.35);
            backdrop-filter: blur(10px);
            padding: 10px 18px;
            border-radius: 30px;
            cursor: pointer;
            box-shadow: 0px 4px 12px rgba(0,0,0,0.15);
            transition: 0.3s;
        }

        .user-info:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
        }

        .username {
            font-weight: 600;
            color: #6b2b38;
        }

        .dropdown-menu {
            position: absolute;
            top: 60px;
            right: 0;
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            width: 180px;
            border-radius: 12px;
            box-shadow: 0px 8px 18px rgba(0,0,0,0.20);
            display: none;
            flex-direction: column;
            padding: 12px 0;
            z-index: 1001; 
        }

        .dropdown-menu a,
        .dropdown-menu button {
            padding: 12px 18px;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            font-size: 15px;
            cursor: pointer;
            color: #6b2b38;
            text-decoration: none;
        }

        .dropdown-menu a:hover,
        .dropdown-menu button:hover {
            background: rgba(230, 170, 185, 0.3);
        }

        /* PAGE CONTENT */
        .container {
            max-width: 1000px;
            margin: auto;
            padding: 0 40px;
        }

        .title-box {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(12px);
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0px 10px 25px rgba(0,0,0,0.15);
            text-align: center;
            margin-bottom: 35px;
            border-left: 8px solid #c96a7f;
        }

        .title-box i {
            font-size: 3rem;
            color: #c96a7f;
        }

        .title-box h2 {
            margin-top: 12px;
            font-size: 2rem;
            font-weight: 700;
            color: #6b2b38;
        }

        /* PRODUCT TABLE */
        .table-box {
            background: rgba(255,255,255,0.4);
            backdrop-filter: blur(10px);
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0px 10px 25px rgba(0,0,0,0.15);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
        }

        th, td {
            padding: 14px;
            text-align: left;
            color: #6b2b38;
        }

        th {
            background: rgba(255,255,255,0.6);
            font-weight: 700;
        }

        tr {
            background: rgba(255,255,255,0.4);
        }

        tr:hover {
            background: rgba(255,255,255,0.7);
        }
    </style>
</head>

<body>

<div class="top-navbar">
    
    <a href="{{ route('admin.dashboard') }}" class="back-to-dashboard">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Dashboard</span>
    </a>

    <div class="nav-right">
        <div class="user-info" onclick="toggleDropdown()">
            <img src="https://ui-avatars.com/api/?name=AD" class="avatar">
            <span class="username">Admin</span>
            <i class="fas fa-caret-down"></i>
        </div>

        <div class="dropdown-menu" id="dropdownMenu">
            <a href="#">Profil</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
</div>


<div class="container">

    <div class="title-box">
        <i class="fas fa-box"></i>
        <h2>Daftar Produk</h2>
        <p>Daftar seluruh produk yang terdaftar dalam sistem.</p>
    </div>

<div class="table-box">
    <table>
        <tr>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
        </tr>

        @foreach ($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->name ?? '-' }}</td>
            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
            <td>{{ $product->stock }}</td>
        </tr>
        @endforeach

        @if ($products->isEmpty())
        <tr>
            <td colspan="4" style="text-align:center; padding: 20px; font-weight:600;">
                Tidak ada produk tersedia.
            </td>
        </tr>
        @endif

    </table>
</div>

<script>
function toggleDropdown() {
    const menu = document.getElementById("dropdownMenu");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}

document.addEventListener("click", function(e) {
    const menu = document.getElementById("dropdownMenu");
    const userInfo = document.querySelector(".user-info");

    if (menu.style.display === "block" && !userInfo.contains(e.target) && !menu.contains(e.target)) {
        menu.style.display = "none";
    }
});
</script>

</body>
</html>