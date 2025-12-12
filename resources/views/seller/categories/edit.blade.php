{{-- resources/views/seller/categories/edit.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori - Seller</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <style>
        /* CSS Umum dan Layout */
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #f3b8c8, #e38fa2, #d86e82); margin: 0; padding: 40px 0; }
        .top-navbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding: 0 40px; position: relative; z-index: 1000; }
        .back-to-dashboard { display: flex; align-items: center; gap: 8px; text-decoration: none; background: rgba(255, 255, 255, 0.35); backdrop-filter: blur(10px); padding: 10px 18px; border-radius: 30px; color: #6b2b38; font-weight: 600; box-shadow: 0px 4px 12px rgba(0,0,0,0.15); transition: 0.3s; }
        .back-to-dashboard:hover { background: rgba(255, 255, 255, 0.5); transform: scale(1.02); }
        .container { max-width: 600px; margin: auto; padding: 0 40px; }

        /* --- CSS Tambahan untuk User Info --- */
        .nav-right { display: flex; align-items: center; }
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
        
        /* Gaya Form */
        .form-box { background: rgba(255,255,255,0.4); backdrop-filter: blur(10px); padding: 30px; border-radius: 16px; box-shadow: 0px 10px 25px rgba(0,0,0,0.15); }
        .form-box h2 { text-align: center; color: #6b2b38; margin-bottom: 25px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #6b2b38; }
        .form-group input[type="text"] { width: 100%; padding: 12px; border: 1px solid rgba(107, 43, 56, 0.3); border-radius: 8px; box-sizing: border-box; font-size: 16px; background: rgba(255,255,255,0.7); }
        .form-group input[type="text"]:focus { outline: none; border-color: #c96a7f; box-shadow: 0 0 0 3px rgba(201, 106, 127, 0.2); }
        .btn-submit { display: block; width: 100%; padding: 12px; background: #c96a7f; color: #fff; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: 0.3s; }
        .btn-submit:hover { background: #a44c61; }
        .alert-danger { background: #ffe6e6; border: 1px solid #e6c8c8; color: #703838; padding: 10px; border-radius: 8px; margin-top: 10px; margin-bottom: 20px; border-left: 5px solid red; }
    </style>
</head>
<body>

<div class="top-navbar">
    <a href="{{ route('seller.categories.index') }}" class="back-to-dashboard">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Kategori</span>
    </a>

    <div class="nav-right">
        <div class="user-info">
            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" class="avatar" alt="Avatar Pengguna">
            <span>{{ auth()->user()->name }}</span>
        </div>
    </div>
    </div>

<div class="container">
    <div class="form-box">
        <h2>Edit Kategori: {{ $category->name }}</h2>
        
        @if ($errors->any())
            <div class="alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('seller.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nama Kategori</label>
                <input type="text" id="name" name="name" required value="{{ old('name', $category->name) }}">
            </div>
            <button type="submit" class="btn-submit">Perbarui Kategori</button>
        </form>
    </div>
</div>

</body>
</html>