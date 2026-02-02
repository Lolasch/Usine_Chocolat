<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commander - L'Usine à Chocolat 2026</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FAVICON -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/autre/seul_blanc.svg') }}">

    <style>
        html, body {
            background-color: #FFF9EF !important;
            margin: 0;
            padding: 0;
            border: none !important;
            outline: none !important;
        }
        main {
            border: none !important;
            box-shadow: none !important;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brown: {
                            50: '#fef3c7', 100: '#fde68a', 200: '#fcd34d',
                            600: '#d97706', 700: '#b45309', 800: '#92400e', 900: '#78350f'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="flex justify-center bg-[#FFF9EF] overflow-x-hidden min-h-screen">
    <main class="w-full bg-[#FFF9EF] text-[#3B2A21]">
        <!-- HEADER -->
        <header class="bg-[#554840] py-[4%] flex justify-center">
            <img src="/images/logos/usine_choco_26_blanc2.svg" alt="Usine à Chocolat" class="header-logo h-16 mt-4" />
        </header>

        <!-- CONTENU PRINCIPAL -->
        <div class="pt-6 px-4 sm:px-6">
            <div class="w-full bg-[#554840] rounded-[32px] p-6 sm:p-8 relative mb-4">
                <h1 class="text-2xl sm:text-3xl font-black text-[#A8C9C3] mb-6 text-center" style="font-family: 'Kavoon', cursive;">Passez commande</h1>

                <!-- Messages d'erreur -->
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-2xl mb-4">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- FORMULAIRE -->
                <form action="{{ route('commande.store') }}" method="POST" class="space-y-4 sm:space-y-5">
                    @csrf

                    <!-- Nom -->
                    <div>
                        <label class="block text-base sm:text-lg font-black text-[#FFF9EF] mb-2" style="font-family: 'Kavoon', cursive;">Nom</label>
                        <input type="text"
                               name="nom"
                               value="{{ old('nom') }}"
                               required
                               class="w-full h-12 sm:h-14 px-4 border-0 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#A8C9C3] bg-[#FFF9EF] text-[#554840] text-base placeholder-[#8B7355] font-medium"
                               placeholder="Exemple : SCHMITT">
                    </div>

                    <!-- Prénom -->
                    <div>
                        <label class="block text-base sm:text-lg font-black text-[#FFF9EF] mb-2" style="font-family: 'Kavoon', cursive;">Prénom</label>
                        <input type="text"
                               name="prenom"
                               value="{{ old('prenom') }}"
                               required
                               class="w-full h-12 sm:h-14 px-4 border-0 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#A8C9C3] bg-[#FFF9EF] text-[#554840] text-base placeholder-[#8B7355] font-medium"
                               placeholder="Exemple : Lola">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-base sm:text-lg font-black text-[#FFF9EF] mb-2" style="font-family: 'Kavoon', cursive;">Adresse mail</label>
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               class="w-full h-12 sm:h-14 px-4 border-0 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#A8C9C3] bg-[#FFF9EF] text-[#554840] text-base placeholder-[#8B7355] font-medium"
                               placeholder="Exemple : lola.schmitt@gmail.com">
                    </div>

                    <!-- Type de chocolat -->
                    <div>
                        <label class="block text-base sm:text-lg font-black text-[#FFF9EF] mb-2" style="font-family: 'Kavoon', cursive;">Type de chocolat</label>
                        <select name="type_chocolat"
                                required
                                class="w-full h-12 sm:h-14 px-4 border-0 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#A8C9C3] bg-[#FFF9EF] text-[#8B7355] text-base appearance-none cursor-pointer font-medium">
                            <option value="">-- Choix du chocolat --</option>
                                @foreach($chocolats as $chocolat)

                                    @php
                                        $rupture = !$chocolat->disponible
                                            || !$chocolat->stock
                                            || $chocolat->stock->quantite <= 0
                                            || !$chocolat->stock->actif;
                                    @endphp

                                    <option value="{{ $chocolat->id }}"
                                        class="{{ $rupture ? 'text-gray-400' : 'text-[#554840]' }}"
                                        {{ $rupture ? 'disabled' : '' }}
                                        {{ old('type_chocolat') == $chocolat->id ? 'selected' : '' }}
                                    >
                                        {{ $chocolat->nom }}
                                        {{ $rupture ? ' — Indisponible' : '' }}
                                    </option>

                                @endforeach
                        </select>
                    </div>

                    <!-- Allergies -->
                    <div>
                        <label class="block text-base sm:text-lg font-black text-[#FFF9EF] mb-2" style="font-family: 'Kavoon', cursive;">Allergies</label>
                        <textarea name="allergies"
                                  rows="2"
                                  class="w-full px-4 py-3 border-0 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#A8C9C3] bg-[#FFF9EF] text-[#554840] resize-none text-base placeholder-[#8B7355] font-medium"
                                  placeholder="Exemple : Amandes, Huile de colza ...">{{ old('allergies') }}</textarea>
                    </div>

                    <!-- Bouton Valider -->
                    <div class="pt-2">
                        <button type="submit"
                                class="w-full h-12 sm:h-14 bg-[#A8C9C3] hover:bg-[#90B5AF] text-[#554840] font-black text-lg sm:text-xl rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 active:scale-95 transition-all duration-200"
                                style="font-family: 'Kavoon', cursive;">
                            Valider
                        </button>
                    </div>
                </form>
            </div>

            <!-- NAV BAR -->
            <div class="fixed bottom-8 left-1/2 -translate-x-1/2 w-[300px] h-16 bg-[#8E5442] rounded-full shadow-2xl flex items-center justify-around px-8 py-9 z-50 border-4 border-[#554840]/100">

                <a href="/accueil" class="w-16 h-14 bg-[#524539] rounded-t-[2.25rem] rounded-b-2xl flex items-center justify-center transition-all duration-200 group shadow-[0px_10px_30px_rgba(0,0,0,0.3)] active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-9 h-9 text-[#FFF9EF] group-hover:text-[#ABDDCC] drop-shadow-sm">
                        <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 0 1 1.414 0l7 7A1 1 0 0 1 17 11h-1v6a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-6H3a1 1 0 0 1-.707-1.707l7-7Z" clip-rule="evenodd" />
                    </svg>
                </a>

                <a href="/formulaire" class="w-16 h-14 bg-[#524539] rounded-t-[2.25rem] rounded-b-2xl flex items-center justify-center transition-all duration-200 group shadow-[0px_10px_30px_rgba(0,0,0,0.3)] active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-9 h-9 text-[#FFF9EF] group-hover:text-[#ABDDCC] drop-shadow-sm">
                        <path fill-rule="evenodd" d="M6 5v1H4.667a1.75 1.75 0 0 0-1.743 1.598l-.826 9.5A1.75 1.75 0 0 0 3.84 19H16.16a1.75 1.75 0 0 0 1.743-1.902l-.826-9.5A1.75 1.75 0 0 0 15.333 6H14V5a4 4 0 0 0-8 0Zm4-2.5A2.5 2.5 0 0 0 7.5 5v1h5V5A2.5 2.5 0 0 0 10 2.5ZM7.5 10a2.5 2.5 0 0 0 5 0V8.75a.75.75 0 0 1 1.5 0V10a4 4 0 0 1-8 0V8.75a.75.75 0 0 1 1.5 0V10Z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- FOOTER -->
        <footer class="bg-[#554840] text-[#FFF9EF] text-center pt-[12%] pb-[8%] px-[5%] w-full box-border mt-20 relative">
            <div class="absolute top-[-10%] left-1/2 -translate-x-1/2 w-[48%] h-[38%] bg-[#554840] rounded-full opacity-100 z-0"></div>

            <div class="absolute top-[-7%] left-1/2 -translate-x-1/2 w-[44%] max-w-[155px] z-10">
                <img src="/images/logos/usine_choco_26_blanc.svg"
                    alt="Usine Chocolat 2026"
                    class="w-full h-auto drop-shadow-2xl block mx-auto" />
            </div>

            <div class="absolute top-[10%] right-[12%] z-20">
                <button class="w-12 h-12 bg-[#ABDDCC] hover:bg-[#96c9c2] rounded-full flex items-center justify-center shadow-lg transition-all duration-200 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#554840]" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 18.75 7.5-7.5 7.5 7.5" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 7.5-7.5 7.5 7.5" />
                    </svg>
                </button>
            </div>

            <div class="pt-[18%] relative z-30">
                <button class="bg-[#7A4A32] hover:bg-[#65412a] transition-all duration-200 px-[5%] py-3 mb-6 text-sm font-medium shadow-lg mx-auto block tracking-wide rounded-t-[2rem] rounded-b-lg">
                    Site de l'IUT
                </button>

                <div class="p-4 mb-6 w-[90%] max-w-[250px] mx-auto">
                    <img src="/images/logos/haguenau.png" alt="IUT Haguenau" class="w-full h-auto rounded-lg mx-auto" />
                </div>

                <div class="flex justify-center gap-4 mb-4 w-[150px] mx-auto relative z-10">
                    <a href="#" aria-label="Instagram" class="w-10 h-10 bg-[#7A4A32] hover:bg-[#65412a] rounded-full flex items-center justify-center transition-all duration-200 shadow-md active:scale-95 group">
                        <svg class="w-5 h-5 text-[#FFF9EF] group-hover:text-[#ABDDCC]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    <a href="#" aria-label="Facebook" class="w-10 h-10 bg-[#7A4A32] hover:bg-[#65412a] rounded-full flex items-center justify-center transition-all duration-200 shadow-md active:scale-95 group">
                        <svg class="w-5 h-5 text-[#FFF9EF] group-hover:text-[#ABDDCC]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="#" aria-label="YouTube" class="w-10 h-10 bg-[#7A4A32] hover:bg-[#65412a] rounded-full flex items-center justify-center transition-all duration-200 shadow-md active:scale-95 group">
                        <svg class="w-5 h-5 text-[#FFF9EF] group-hover:text-[#ABDDCC]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                </div>

                <p class="text-lg leading-relaxed mb-2 px-2">Copyright 2026<br/>DRINNHAUSEN Lou - SCHMITT Lola</p>

                <div class="flex justify-center gap-4 text-lg underline mb-24">
                    <a href="#" class="hover:text-white/80 transition-colors duration-200">Mentions légales</a>
                    <a href="#" class="hover:text-white/80 transition-colors duration-200">Crédits</a>
                </div>
            </div>
        </footer>
    </main>
</body>
</html>
