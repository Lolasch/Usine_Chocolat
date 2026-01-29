<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', "L'Usine Chocolat") }}</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- GOOGLE FONT KAVOON -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Thème chocolat custom -->
    <style>
        .font-kavoon { font-family: 'Kavoon', cursive; }
        :root {
            --choco-brown: #554840;
            --choco: #8E5442;
            --choco-beige: #FFF9EF;
            --choco-gold: #FCE097;
            --caramel: #FDAD42;
            --caramel-dark: #DB692B;
            --green: #ABDDCC;
        }
        .hover-caramel:hover {
            background-color: var(--caramel);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-[#FDF3D8] to-[#F5E8C7] min-h-screen flex flex-col">

    <!-- HEADER -->
    <header class="bg-[var(--choco-brown)] text-[var(--choco-beige)]">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo -->
            <a href="{{ url('/liste') }}" class="flex items-center gap-4">
                <img src="{{ asset('images/logos/usine_choco_26_blanc2.svg') }}" alt="Usine Chocolat" class="h-16">
            </a>

            <!-- Navigation -->
            <nav class="hidden md:flex items-center gap-3 font-kavoon font-medium">
                <a href="{{ url('/liste') }}"
                class="bg-[var(--choco-gold)] text-[var(--choco-brown)]
                        px-6 py-2 rounded-full
                        text-lg hover-caramel transition-colors duration-300">
                    Commandes
                </a>
                <a href="#"
                class="bg-[var(--choco-gold)] text-[var(--choco-brown)]
                        px-6 py-2 rounded-full
                        text-lg hover-caramel transition-colors duration-300">
                    Frigo
                </a>
                <a href="#"
                class="bg-[var(--choco-gold)] text-[var(--choco-brown)]
                        px-6 py-2 rounded-full
                        text-lg hover-caramel transition-colors duration-300">
                    Statistiques
                </a>
                <a href="{{ url('/admin') }}"
                class="bg-[var(--choco-gold)] text-[var(--choco-brown)]
                        px-6 py-2 rounded-full
                        text-lg hover-caramel transition-colors duration-300">
                    Admin
                </a>
                <button class="bg-[var(--choco-gold)] text-[var(--choco-brown)]
                            p-2 rounded-t-[2.25rem] rounded-b-3xl
                            hover-caramel transition-colors duration-300"
                        aria-label="Logout">
                    <svg class="w-7 h-7 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </nav>

            <!-- Menu Burger Mobile -->
            <div class="md:hidden">
                <button id="mobile-menu-button" class="p-2 rounded-md hover:bg-[var(--choco)] transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
            <!-- MENU MOBILE -->
            <div id="mobile-menu"
                class="md:hidden hidden bg-[var(--choco-brown)] text-[var(--choco-beige)] px-6 py-4 space-y-3 font-kavoon font-medium">

                <a href="{{ url('/liste') }}" class="block text-lg">Commandes</a>
                <a href="#" class="block text-lg">Frigo</a>
                <a href="#" class="block text-lg">Statistiques</a>
                <a href="{{ url('/admin') }}" class="block text-lg">Admin</a>

                <button class="flex items-center gap-2 text-lg">
                    <svg class="w-7 h-7 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </div>

        </div>
    </header>

    <!-- MAIN -->
    <main class="flex-1">
        @include('layouts.navigation')
        {{ $header ?? '' }}
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#5a463a] py-6 text-center text-xs text-[#e6d5b8]">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex items-center justify-center space-x-16">
                <img src="/images/logos/usine_choco_26_blanc2.svg" alt="icône logo"
                    class="w-auto h-10 object-contain opacity-80 hover:opacity-100 transition-opacity">

                <div class="text-center space-y-2 min-w-[320px]">
                    <p class="font-semibold text-md text-[#e6d5b8]">
                        Copyright 2026 DRINHAUSEN Lou - SCHMITT Lola
                    </p>
                    <div class="flex flex-wrap items-center justify-center gap-6 text-md">
                        <a href="#" class="underline hover:text-[#e6d5b8] hover:underline-offset-2 transition-all">
                            Mentions légales
                        </a>
                        <a href="#" class="underline hover:text-[#e6d5b8] hover:underline-offset-2 transition-all">
                            Crédits
                        </a>
                    </div>
                </div>

                <img src="/images/logos/haguenau.png" alt="icône haguenau"
                    class="w-auto h-10 object-contain opacity-80 hover:opacity-100 transition-opacity">
            </div>
        </div>
    </footer>

    <!-- Script Hamburger -->
    <script>
        const btn = document.getElementById('mobile-menu-button');
        const menu = document.getElementById('mobile-menu');
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>

</body>
</html>
