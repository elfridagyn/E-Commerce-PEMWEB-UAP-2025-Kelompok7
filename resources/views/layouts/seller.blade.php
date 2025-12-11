<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller - @yield('title')</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f7f8fc;
            margin: 0;
        }

        /* CONTENT FULL WIDTH */
        .content {
            width: 100%;
            padding: 30px;
        }
    </style>
</head>

<body>

<div class="content">
    @yield('content')
</div>

</body>
</html>
