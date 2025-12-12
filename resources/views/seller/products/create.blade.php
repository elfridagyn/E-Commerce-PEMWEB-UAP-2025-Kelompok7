<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Seller</title>

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
        .back-to-dashboard:hover { background: rgba(255, 255, 255, 0.5); transform: scale(1.02); }

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

        .container { max-width: 600px; margin: auto; padding: 0 40px; }

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

        form {
            background: rgba(255,255,255,0.4);
            backdrop-filter: blur(10px);
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0px 10px 25px rgba(0,0,0,0.15);
        }

        label { font-weight: 600; color: #6b2b38; display: block; margin-bottom: 6px; }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 18px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
        }

        .btn-submit {
            width: 100%; /* Membuat tombol submit full width */
            background: #4caf50;
            color: #fff;
            padding: 10px 18px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-submit:hover { background: #388e3c; }
    </style>
</head>
<body>

<div class="top-navbar">
    <a href="{{ route('seller.products.index') }}" class="back-to-dashboard">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Produk</span>
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
        <i class="fas fa-plus"></i>
        <h2>Tambah Produk Baru</h2>
        <p>Isi data produk baru dengan lengkap.</p>
    </div>

    <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="name">Nama Produk</label>
        <input type="text" name="name" id="name" required value="{{ old('name') }}">

        <label for="category_id">Kategori</label>
        <select name="category_id" id="category_id" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <label for="price">Harga (Rp)</label>
        <input type="number" name="price" id="price" required value="{{ old('price') }}">

        <label for="stock">Stok</label>
        <input type="number" name="stock" id="stock" required value="{{ old('stock') }}">

        <label for="description">Deskripsi</label>
        <textarea name="description" id="description" rows="4">{{ old('description') }}</textarea>

        <label for="image">Gambar Produk</label>
        <input type="file" name="image" id="image">

        <button type="submit" class="btn-submit">Simpan Produk</button>
    </form>

</div>

</body>
</html>