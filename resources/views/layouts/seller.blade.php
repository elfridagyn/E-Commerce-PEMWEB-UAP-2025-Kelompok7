<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Seller Dashboard')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    @stack('styles')
    <style>
        body { font-family: 'Poppins', sans-serif; margin:0; padding:0; background: #fdf2f2; }
        a { text-decoration: none; color: inherit; }
        .menu-card { 
            padding:20px; border-radius:12px; background:#fff3f3; text-align:center; 
            transition:0.3s; box-shadow:0 4px 15px rgba(0,0,0,0.1); 
        }
        .menu-card:hover { transform: translateY(-3px); background:#ffdce0; }
        .menu-card i { font-size:2rem; color:#c96a7f; margin-bottom:10px; display:block; }
    </style>
</head>
<body>
    <header style="padding:20px; background:#ffe0e5;">
        <h1>@yield('title')</h1>
    </header>
    <main style="padding:20px;">
        @yield('content')
    </main>
    @stack('scripts')
</body>
</html>