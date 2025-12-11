
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Seller</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5b8c8, #e58fa2, #d56e82);
            margin: 0;
            padding: 40px 0;
        }

        /* NAVBAR */
        .top-navbar {
            display: flex;
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 30px;
            padding: 0 40px;
        }

        .back-btn {
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
            transition: 0.3s;
        }

        .back-btn:hover { background: rgba(255, 255, 255, 0.5); transform: scale(1.04); }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.35);
            padding: 10px 18px;
            border-radius: 30px;
            cursor: pointer;
            backdrop-filter: blur(10px);
        }

        .avatar { width: 36px; height: 36px; border-radius: 50%; }

        /* DROPDOWN */
        .dropdown-menu {
            position: absolute;
            top: 60px;
            right: 40px;
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            width: 180px;
            border-radius: 14px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.20);
            display: none;
            flex-direction: column;
            overflow: hidden;
        }

        .dropdown-menu a, .dropdown-menu button {
            padding: 12px 18px;
            background: none;
            border: none;
            text-align: left;
            font-size: 15px;
            color: #632c38;
            cursor: pointer;
            width: 100%;
            text-decoration: none;
        }

        .dropdown-menu a:hover,
        .dropdown-menu button:hover {
            background: rgba(230, 170, 185, 0.3);
        }

        /* CONTAINER */
        .container { max-width: 1100px; margin: auto; padding: 0 40px; }

        /* WELCOME BOX */
        .welcome-box {
            background: rgba(255,255,255,0.25);
            padding: 40px;
            border-radius: 20px;
            backdrop-filter: blur(14px);
            text-align: center;
            color: #5b2230;
            margin-bottom: 40px;
            border-left: 8px solid #c96a7f;
            box-shadow: 0px 10px 25px rgba(0,0,0,0.15);
        }

        .welcome-box i { font-size: 3.5rem; margin-bottom: 10px; color: #c96a7f; }
        .welcome-box h1 { font-size: 2.2rem; font-weight: 700; margin-bottom: 10px; }

        /* MENU GRID */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 25px;
        }

        .menu-card {
            background: rgba(255,255,255,0.35);
            padding: 25px;
            border-radius: 18px;
            text-align: center;
            backdrop-filter: blur(10px);
            box-shadow: 0px 8px 20px rgba(0,0,0,0.15);
            transition: 0.3s;
        }

        .menu-card:hover {
            transform: translateY(-6px);
            background: rgba(255,255,255,0.5);
        }

        .menu-card i {
            font-size: 2.5rem;
            color: #a83c55;
            margin-bottom: 12px;
        }

        .menu-card a {
            text-decoration: none;
            font-size: 18px;
            font-weight: 600;
            color: #5b2a36;
        }
    </style>
</head>

<body>
<div class="top-navbar">
    <div></div> <!-- spacer kiri -->

    <div class="user-info" id="userInfoBtn" onclick="toggleDropdown()">
        <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" class="avatar" alt="avatar">
        <span>{{ auth()->user()->name }}</span>
        <i class="fas fa-caret-down" style="margin-left:6px;"></i>

        <div id="dropdownMenu" class="dropdown-menu" aria-hidden="true">
            <a href="{{ route('seller.profile.show') }}">Profil</a>

            <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <div class="welcome-box">
        <i class="fas fa-store"></i>
        <h1>Dashboard Seller</h1>
        <p>Selamat datang di dashboard toko Anda.</p>
    </div>

    <div class="menu-grid">
        <div class="menu-card">
            <i class="fas fa-id-card"></i>
            <a href="{{ route('seller.profile.show') }}">Profil Toko</a>
        </div>

        <div class="menu-card">
            <i class="fas fa-layer-group"></i>
            <a href="#">Kelola Kategori Produk</a>
        </div>

        <div class="menu-card">
            <i class="fas fa-box"></i>
            <a href="#">Kelola Produk</a>
        </div>

        <div class="menu-card">
            <i class="fas fa-shopping-cart"></i>
            <a href="#">Pesanan Masuk</a>
        </div>

        <div class="menu-card">
            <i class="fas fa-wallet"></i>
            <a href="#">Saldo Toko</a>
        </div>

        <div class="menu-card">
            <i class="fas fa-money-bill-transfer"></i>
            <a href="#">Penarikan Dana</a>
        </div>
    </div>
</div>

<script>
function toggleDropdown() {
    const menu = document.getElementById("dropdownMenu");
    const isShown = menu.style.display === "flex";
    menu.style.display = isShown ? "none" : "flex";
    menu.setAttribute('aria-hidden', isShown ? 'true' : 'false');
}

// tutup dropdown jika klik di luar
document.addEventListener("click", function(e) {
    const menu = document.getElementById("dropdownMenu");
    const btn = document.getElementById("userInfoBtn");
    if (!btn.contains(e.target) && menu.style.display === "flex") {
        menu.style.display = "none";
        menu.setAttribute('aria-hidden', 'true');
    }
});
</script>

</body>
</html>

<h1>Seller Dashboard</h1>
