<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name'))</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- CHART.JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!-- GOOGLE FONT KAVOON -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet">

    <!-- FAVICON -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/autre/seul_blanc.svg') }}">


    <!-- Styles -->
    <title>
        @yield('title', config('app.name'))
    </title>

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
<body class="font-sans antialiased bg-[var(--choco-gold)] min-h-screen flex flex-col">

    <!-- HEADER -->
    <header class="bg-[var(--choco-brown)] text-[var(--choco-beige)]">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <!-- Logo -->
            <a href="{{ url('/liste') }}" class="flex items-center gap-4 pr-2">
                <img src="{{ asset('images/logos/usine_choco_26_blanc2.svg') }}" alt="Usine Chocolat" class="h-16">
            </a>

            <!-- Navigation -->
            <nav class="hidden md:flex items-center gap-3 font-kavoon font-medium">

                {{-- SUPERVISEUR SEULEMENT --}}
                @if(auth()->user()->isSuperviseur())
                    <a href="{{ url('/liste') }}"
                        class="bg-[var(--choco-gold)] text-[var(--choco-brown)] px-4 py-2 rounded-full text-lg hover-caramel transition-colors duration-300">
                            Commandes
                    </a>

                    <a href="{{ route('stocks.index') }}"
                    class="bg-[var(--choco-gold)] text-[var(--choco-brown)] px-4 py-2 rounded-full text-lg hover-caramel transition-colors duration-300">
                        Stocks
                    </a>

                    <a href="{{ route('statistiques.index') }}"
                    class="bg-[var(--choco-gold)] text-[var(--choco-brown)] px-4 py-2 rounded-full text-lg hover-caramel transition-colors duration-300">
                        Statistiques
                    </a>

                    <a href="{{ url('/admin') }}"
                    class="bg-[var(--choco-gold)] text-[var(--choco-brown)] px-4 py-2 rounded-full text-lg hover-caramel transition-colors duration-300">
                        Admin
                    </a>

                @endif

                {{-- LOGOUT --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="bg-[var(--choco-gold)] text-[var(--choco-brown)] p-2 rounded-t-[2.25rem] rounded-b-3xl hover-caramel transition-colors duration-300">
                        <svg class="w-7 h-7 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>

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
                class="md:hidden hidden bg-[var(--choco-brown)] text-[var(--choco-beige)] px-4 py-4 space-y-3 font-kavoon font-medium">


                @if(auth()->user()->isSuperviseur())
                    <a href="{{ url('/liste') }}" class="block text-lg">Commandes</a>
                    <a href="{{ route('stocks.index') }}" class="block text-lg">Stocks</a>
                    <a href="{{ route('statistiques.index') }}" class="block text-lg">Statistiques</a>
                    <a href="{{ url('/admin') }}" class="block text-lg">Admin</a>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="flex items-center gap-2 text-lg">
                        <svg class="w-7 h-7 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Déconnexion
                    </button>
                </form>

            </div>

        </div>
    </header>

    <!-- MAIN -->
    <main class="flex-1 w-full">
        @yield('content')
    </main>


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
