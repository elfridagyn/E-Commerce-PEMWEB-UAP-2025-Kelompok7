<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin E-commerce</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f3b8c8, #e38fa2, #d86e82);
            /* Perbaikan: Hapus padding horizontal, pertahankan padding vertikal */
            margin: 0;
            padding: 40px 0; 
        }

        /* NAVBAR */
        .top-navbar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
            /* Perbaikan: Tambahkan padding horizontal agar ada jarak dari tepi */
            padding: 0 40px; 
            /* Penting: Pastikan ia berada di atas konten lain */
            position: relative;
            z-index: 1000;
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
            /* Ganti placeholder ini dengan gambar avatar sungguhan jika ada */
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
            /* Perbaikan: z-index lebih tinggi dari navbar */
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
            text-decoration: none; /* Tambahkan agar a tidak bergaris bawah */
        }

        .dropdown-menu a:hover,
        .dropdown-menu button:hover {
            background: rgba(230, 170, 185, 0.3);
        }

        /* DASHBOARD TITLE */
        .dashboard {
            max-width: 900px;
            margin: auto;
            /* Perbaikan: Tambahkan padding horizontal agar konten tidak menempel ke tepi */
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

        .title-box p {
            margin-top: 8px;
            color: #6b2b38;
            font-weight: 500;
        }

        /* MENU GRID */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 22px;
        }

        .menu-card {
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 25px;
            text-align: center;
            box-shadow: 0px 8px 20px rgba(0,0,0,0.12);
            transition: 0.3s;
            border-bottom: 4px solid transparent;
        }

        .menu-card:hover {
            transform: translateY(-6px);
            border-bottom: 4px solid #c96a7f;
        }

        .menu-card i {
            font-size: 2.4rem;
            color: #c96a7f;
            margin-bottom: 12px;
        }

        .menu-card a {
            text-decoration: none;
            color: #6b2b38;
            font-weight: 600;
            display: block;
            margin-top: 8px;
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="top-navbar">
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

<div class="dashboard">

    <div class="title-box">
        <i class="fas fa-crown"></i>
        <h2>Dashboard Admin</h2>
        <p>Selamat datang di panel administrasi sistem e-commerce.</p>
    </div>

    <div class="menu-grid">

        <div class="menu-card">
            <i class="fas fa-tags"></i>
            <a href="{{ route('admin.kategori.index') }}">Daftar Kategori Produk</a>
        </div>

        <div class="menu-card">
            <i class="fas fa-box"></i>
            <a href="{{ route('admin.produk.index') }}">Daftar Produk</a>
        </div>

        <div class="menu-card">
            <i class="fas fa-users"></i>
            <a href="{{ route('admin.users.index') }}">Kelola User</a>
        </div>

        <div class="menu-card">
            <i class="fas fa-store"></i>
            <a href="{{ route('admin.store.index') }}">Verifikasi Toko</a>
        </div>

    </div>

</div>

<script>
function toggleDropdown() {
    const menu = document.getElementById("dropdownMenu");
    // Perbaikan: gunakan class list untuk mengelola tampilan (lebih baik dari style.display)
    // Namun untuk mempertahankan kode aslinya, kita gunakan style.display
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}

document.addEventListener("click", function(e) {
    const menu = document.getElementById("dropdownMenu");
    const userInfo = document.querySelector(".user-info");

    // Tutup dropdown jika klik di luar area user-info
    if (menu.style.display === "block" && !userInfo.contains(e.target) && !menu.contains(e.target)) {
        menu.style.display = "none";
    }
});
</script>

</body>
</html>