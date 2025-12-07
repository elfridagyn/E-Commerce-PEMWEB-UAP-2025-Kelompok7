<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - @yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
<div class="d-flex">
    <!-- SIDEBAR -->
    <div class="bg-dark text-white p-3" style="width: 240px; height: 100vh;">
        <h4 class="mb-4">Admin Panel</h4>

        <a href="{{ route('admin.dashboard') }}" class="text-white d-block mb-2">Dashboard</a>
        <a href="{{ url('/admin/users') }}" class="text-white d-block mb-2">Manajemen User</a>
        <a href="{{ url('/admin/verification') }}" class="text-white d-block mb-2">Verifikasi Toko</a>
        <a href="{{ url('/categories') }}" class="text-white d-block mb-2">Kategori</a>
        <a href="{{ url('/admin/products') }}" class="text-white d-block mb-2">Produk</a>

        <hr class="text-white">

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger w-100 mt-3">
                Logout
            </button>
        </form>


        <a href="{{ url('/') }}" class="text-white"></a>
    </div>


    <!-- CONTENT -->
    <div class="p-4 flex-grow-1">
        <h2>@yield('title')</h2>
        <hr>
        @yield('content')
    </div>
</div>
</body>
</html>
