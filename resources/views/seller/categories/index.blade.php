<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori - Seller</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
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

        /* --- CSS Baru untuk User Info --- */
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
        /* ---------------------------------- */

        .container { max-width: 1000px; margin: auto; padding: 0 40px; }

        .title-box {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(12px);
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0px 10px 25px rgba(0,0,0,0.15);
            text-align: center;
            margin-bottom: 25px;
            border-left: 8px solid #c96a7f;
        }

        .title-box i { font-size: 3rem; color: #c96a7f; }
        .title-box h2 { margin-top: 12px; font-size: 2rem; font-weight: 700; color: #6b2b38; }

        .table-box {
            background: rgba(255,255,255,0.4);
            backdrop-filter: blur(10px);
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0px 10px 25px rgba(0,0,0,0.15);
        }

        table { width: 100%; border-collapse: collapse; font-size: 15px; }
        th, td { padding: 14px; text-align: left; color: #6b2b38; }
        th { background: rgba(255,255,255,0.6); font-weight: 700; }

        tr { background: rgba(255,255,255,0.4); }
        tr:hover { background: rgba(255,255,255,0.7); }

        .btn {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.2s;
        }

        .btn-edit { background: #c96a7f; color: #fff; }
        .btn-edit:hover { background: #a44c61; }

        .btn-delete { background: #ff4d4f; color: #fff; }
        .btn-delete:hover { background: #d9363e; }

        .btn-add { background: #4caf50; color: #fff; padding: 10px 18px; border-radius: 12px; font-weight: 600; margin-bottom: 15px; display: inline-block; }
        .btn-add:hover { background: #388e3c; }
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
        <i class="fas fa-tags"></i>
        <h2>Kelola Kategori Produk</h2>
        <p>Tambah, ubah, atau hapus kategori toko Anda.</p>
    </div>

    <a href="{{ route('seller.categories.create') }}" class="btn-add"><i class="fas fa-plus"></i> Tambah Kategori</a>

    <div class="table-box">
        <table>
            <tr>
                <th>ID</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>

            @forelse ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>
                    <a href="{{ route('seller.categories.edit', $category->id) }}" class="btn btn-edit"><i class="fas fa-edit"></i> Edit</a>
                    <form action="{{ route('seller.categories.destroy', $category->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete" onclick="return confirm('Hapus kategori ini?')">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align:center; padding:20px; font-weight:600;">
                    Tidak ada kategori tersedia.
                </td>
            </tr>
            @endforelse
        </table>
    </div>

</div>

</body>
</html>