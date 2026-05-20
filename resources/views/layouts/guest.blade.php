@props(['reverse' => false])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-white">
        
        @php
            $bgImage = $reverse 
                ? 'https://aaafoodhandler.com/wp-content/uploads/2025/10/Dry-Storage-101-1-scaled.webp' // Gambar untuk halaman REGISTER (Kondisi Reverse True)
                : 'https://cdn.shopify.com/s/files/1/0809/9689/2706/files/commercial-kitchen-food-storage-cool-room-organisation_jpg.png?v=1775015092'; // Gambar untuk halaman LOGIN (Kondisi Reverse False)
        @endphp

        <div class="min-h-screen flex flex-col {{ $reverse ? 'lg:flex-row-reverse' : 'lg:flex-row' }}">
            
            <div class="w-full lg:w-1/2 relative min-h-[40vh] lg:min-h-screen flex flex-col items-center justify-center p-8 overflow-hidden border-r border-gray-100">
                
                <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $bgImage }}');"></div>
                
                <div class="absolute inset-0 bg-secondary/80 mix-blend-multiply"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-secondary/60 to-secondary/90"></div>
                
                <div class="relative z-10 text-center text-primary w-full max-w-2xl px-4">
                    <div class="flex flex-row items-center justify-center gap-6">
                        <img 
                            src="{{ asset('storage/android-chrome-192x192.png') }}" 
                            alt="Logo SIPEKA" 
                            class="h-20 w-20 sm:h-24 sm:w-24 object-contain drop-shadow-md"
                        >
                        <h1 class="text-5xl sm:text-7xl font-bold tracking-wider font-serif">SIPEKA</h1>
                    </div>
                    
                    <p class="mt-6 text-base sm:text-xl font-medium tracking-wide border-t border-primary/30 pt-4">
                        Sistem Pengecekan Kesegaran Bahan
                    </p>
                </div>
            </div>

            <div class="w-full lg:w-1/2 flex items-center justify-center bg-white px-6 py-12 sm:px-16 lg:px-24">
                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </div>

        </div>
    </body>
</html>