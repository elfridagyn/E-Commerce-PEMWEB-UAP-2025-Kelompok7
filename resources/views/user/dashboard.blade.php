<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User E-commerce</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJzL3m3rQkC8mP+kLhV/I/s8v7l3fI/T6x9X/0nU/5sI4ZJ8E5Y5n5G5G5G5G5G5H5G5G5G5G5G5G5H5G5G5G5G==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        :root {
            /* Palet Warna */
            --primary-color: #0d6efd; /* Biru Primer Baru */
            --secondary-color: #6c757d;
            --accent-color: #198754; /* Hijau */
            --background-color: #f4f6f9; /* Latar belakang sangat terang */
            --surface-color: #ffffff; /* Warna Card */
            --text-color-dark: #212529;
            --text-color-light: #5a6268;
            --box-shadow-subtle: 0 4px 12px rgba(0, 0, 0, 0.08);
            --spacing-md: 1.5rem;
            --spacing-lg: 2rem;
        }

        /* Reset dan Tipografi Dasar */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif; 
            background-color: var(--background-color);
            color: var(--text-color-dark);
            line-height: 1.6;
            min-height: 100vh;
            display: flex; /* Memposisikan konten di tengah halaman */
            justify-content: center;
            align-items: center;
        }

        /* Container Utama */
        .main-container {
            width: 100%;
            max-width: 500px; /* Batasi lebar agar fokus */
            padding: var(--spacing-lg);
            text-align: center; /* Teks di tengah container */
        }

        /* CARD STYLE: Untuk membungkus konten utama */
        .info-card {
            background-color: var(--surface-color);
            border-radius: 16px; /* Sudut lebih membulat */
            padding: var(--spacing-lg);
            box-shadow: var(--box-shadow-subtle);
            margin-bottom: var(--spacing-lg);
            transition: transform 0.3s ease;
            border-left: 5px solid var(--primary-color); /* Garis aksen */
        }
        
        .info-card:hover {
            transform: translateY(-5px); /* Efek mengangkat saat hover */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        /* 1. Dashboard Admin Title */
        .admin-title {
            font-size: 2rem; /* Ukuran lebih kecil karena ada ikon besar */
            font-weight: 700;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
            color: var(--text-color-dark);
        }

        /* Ikon Besar di atas Card */
        .title-icon-wrapper {
            font-size: 3.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            animation: pulse 2s infinite; /* Efek berdetak kecil */
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        /* 2. Selamat datang, User! */
        .welcome-text {
            font-size: 1.1rem;
            color: var(--text-color-light);
            margin-bottom: var(--spacing-md);
        }

        /* 3. Tombol Ke Halaman Utama (Styling sebagai Button) */
        .main-page-link {
            /* Dikelola oleh button-link styling */
            margin-top: var(--spacing-md);
        }
        
        .button-link {
            display: inline-flex;
            align-items: center;
            background-color: var(--accent-color); /* Warna hijau yang menarik */
            color: var(--surface-color); /* Teks putih */
            text-decoration: none; 
            font-weight: 600;
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            border: none;
        }

        .button-link:hover {
            background-color: #157347; /* Sedikit lebih gelap saat hover */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .icon-link {
            margin-right: 10px;
        }
    </style>
</head>
<body>

    <main class="main-container">
        
        <div class="info-card">
            
            <div class="title-icon-wrapper">
                <i class="fas fa-cubes"></i> 
            </div>
            
            <h2 class="admin-title">Dashboard User</h2>
            
            <p class="welcome-text">
                Selamat datang, User! 
            </p>
            
            <div class="main-page-link">
                <a href="{{ route('user.dashboard') }}" class="button-link">
                    <i class="fas fa-home icon-link"></i> 
                    User Panel
                </a>
            </div>
        </div>
        
    </main>

</body>
</html>