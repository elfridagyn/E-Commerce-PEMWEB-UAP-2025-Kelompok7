<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Memuat asset CSS dan JS dari Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Stack untuk CSS tambahan per halaman --}}
    @stack('styles') 
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-transparent"> 

        @include('layouts.navigation')

        @isset($header)
            <header class="bg-transparent shadow-none">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main>
            @yield('content')
        </main>
    </div>
    
    {{-- Stack untuk JS tambahan per halaman --}}
    @stack('scripts') 
</body>
</html>
