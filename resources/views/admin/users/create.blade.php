<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User - Admin</title>

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
        }

        .dropdown-menu button {
            padding: 12px 18px;
            background: none;
            border: none;
            text-align: left;
            width: 100%;
            cursor: pointer;
            font-size: 15px;
            color: #6b2b38;
        }

        /* CONTENT */
        .container {
            max-width: 600px;
            margin: auto;
            padding: 0 40px;
        }

        .form-box {
            background: rgba(255,255,255,0.4);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0px 10px 25px rgba(0,0,0,0.15);
        }

        h2 {
            text-align: center;
            color: #6b2b38;
            font-weight: 700;
            margin-bottom: 25px;
        }

        label {
            color: #6b2b38;
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #c96a7f;
            outline: none;
            margin-bottom: 18px;
            background: rgba(255,255,255,0.7);
        }

        .btn-submit {
            width: 100%;
            background: #6b2b38;
            color: white;
            padding: 12px;
            border-radius: 10px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.15);
            transition: 0.3s;
        }

        .btn-submit:hover {
            background: #541f2a;
        }
    </style>
</head>

<body>

{{-- NAVBAR --}}
<div class="top-navbar">
    <a href="{{ route('admin.users.index') }}" class="back-to-dashboard">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>

    <div class="nav-right">
        <div class="user-info" onclick="toggleDropdown()">
            <img src="https://ui-avatars.com/api/?name=Admin" class="avatar">
            <span class="username">Admin</span>
            <i class="fas fa-caret-down"></i>
        </div>

        <div class="dropdown-menu" id="dropdownMenu">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
</div>

<div class="container">

    <div class="form-box">
        <h2>Tambah User</h2>

        <form action="/admin/users" method="POST">
            @csrf

            <label>Nama</label>
            <input type="text" name="name" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <label>Role</label>
            <select name="role" required>
                <option value="admin">Admin</option>
                <option value="seller">Seller</option>
                <option value="buyer">Buyer</option>
            </select>

            <button class="btn-submit">Simpan</button>
        </form>
    </div>

</div>

<script>
function toggleDropdown() {
    const menu = document.getElementById("dropdownMenu");
    menu.style.display = menu.style.display === "block" ? "none" : "block";
}
</script>

</body>
</html>
