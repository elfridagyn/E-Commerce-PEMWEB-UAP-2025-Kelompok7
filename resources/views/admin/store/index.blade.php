<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Toko - Admin</title>

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
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 0 40px;
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
            position: relative;
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
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
        }

        .dropdown-menu {
            position: absolute;
            top: 60px;
            right: 0;
            background: rgba(255,255,255,0.75);
            width: 180px;
            border-radius: 12px;
            box-shadow: 0px 8px 18px rgba(0,0,0,0.20);
            display: none;
            flex-direction: column;
            padding: 12px 0;
        }

        .dropdown-menu a,
        .dropdown-menu button {
            padding: 12px 18px;
            text-align: left;
            background: none;
            border: none;
            cursor: pointer;
            text-decoration: none;
            color: #6b2b38;
            font-size: 15px;
        }

        .dropdown-menu a:hover,
        .dropdown-menu button:hover {
            background: rgba(230,170,185,0.3);
        }

        /* CONTENT */
        .container {
            max-width: 1000px;
            margin: auto;
            padding: 0 40px;
        }

        .title-box {
            background: rgba(255,255,255,0.25);
            backdrop-filter: blur(12px);
            padding: 35px;
            border-radius: 18px;
            text-align: center;
            margin-bottom: 35px;
            border-left: 8px solid #c96a7f;
            box-shadow: 0px 10px 25px rgba(0,0,0,0.15);
        }

        .title-box i {
            font-size: 3rem;
            color: #6b2b38;
        }

        .title-box h2 {
            margin-top: 12px;
            color: #6b2b38;
            font-size: 2rem;
            font-weight: 700;
        }

        /* TABLE */
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

        .btn-approve {
            background: #28a745;
            padding: 7px 14px;
            border-radius: 6px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .btn-reject {
            background: #b11d2b;
            padding: 7px 14px;
            border-radius: 6px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .btn-approve:hover { opacity: .85; }
        .btn-reject:hover { opacity: .85; }

    </style>
</head>

<body>

{{-- NAVBAR --}}
<div class="top-navbar">
    <a href="{{ route('admin.dashboard') }}" class="back-to-dashboard">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>

    <div class="nav-right">
        <div class="user-info" onclick="toggleDropdown()">
            <img src="https://ui-avatars.com/api/?name=Admin" class="avatar">
            <span>Admin</span>
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

    <!-- TITLE -->
    <div class="title-box">
        <i class="fas fa-store"></i>
        <h2>Verifikasi Toko</h2>
        <p>Daftar toko yang perlu diverifikasi oleh admin.</p>
    </div>

    <!-- TABLE -->
    <div class="table-box">
        <table>
            <tr>
                <th>Nama Toko</th>
                <th>Pemilik</th>
                <th>Telepon</th>
                <th>Aksi</th>
            </tr>

            @foreach($stores as $store)
            <tr>
                <td>{{ $store->store_name }}</td>
                <td>{{ $store->user->name }}</td>
                <td>{{ $store->phone }}</td>

                <td>
                    <a href="{{ route('admin.store.approve', $store->id) }}" class="btn-approve">Approve</a>
                    <a href="{{ route('admin.store.reject', $store->id) }}" class="btn-reject">Reject</a>
                </td>
            </tr>
            @endforeach

            @if($stores->isEmpty())
            <tr>
                <td colspan="4" style="text-align:center; padding: 20px; font-weight:600;">Tidak ada toko untuk diverifikasi.</td>
            </tr>
            @endif

        </table>
    </div>

</div>

<script>
function toggleDropdown() {
    const menu = document.getElementById("dropdownMenu");
    menu.style.display = menu.style.display === "block" ? "none" : "block";
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
