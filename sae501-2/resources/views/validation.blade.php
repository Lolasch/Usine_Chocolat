<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation - L'usine à chocolat</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html, body {
            background-color: #FFF9EF !important;
            margin: 0;
            padding: 0;
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
<body class="flex justify-center bg-[#FFF9EF]">
    <main class="w-full max-w-[414px] sm:max-w-[480px] bg-[#FFF9EF] text-[#3B2A21] overflow-hidden min-h-screen">
        <header class="bg-[#554840] py-6 flex justify-center">
            <img src="{{ asset('images/logos/usine_choco_26_blanc2.svg') }}" alt="Usine à Chocolat" class="h-14" />
        </header>

        <div class="pt-6 pb-48 px-4 sm:px-6">
            <div class="w-full bg-[#554840] rounded-[32px] p-6 sm:p-8 relative mb-4">
                <h1 class="text-2xl sm:text-3xl font-black text-[#A8C9C3] mb-6 text-center leading-tight" style="font-family: 'Kavoon', cursive;">
                    Merci pour votre<br>commande !
                </h1>

                <div class="text-center mb-6">
                    <p class="text-[#FFF9EF] text-base mb-2">Numéro de commande :</p>
                    <p class="text-[#FFF9EF] text-2xl font-black" style="font-family: 'Kavoon', cursive;">
                        {{ $commande->numero_commande }}
                    </p>
                </div>

                <div class="bg-[#6B5D52] rounded-2xl p-5 mb-6 relative">
                    <div class="absolute -right-2 -top-2 w-16 h-16 bg-[#FFF9EF] rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-[#554840]" viewBox="0 0 100 100" fill="currentColor">
                            <circle cx="50" cy="45" r="35"/>
                            <ellipse cx="35" cy="35" rx="5" ry="7" fill="#FFF9EF"/>
                            <ellipse cx="65" cy="35" rx="5" ry="7" fill="#FFF9EF"/>
                            <path d="M 30 50 Q 50 60 70 50" stroke="#FFF9EF" stroke-width="3" fill="none" stroke-linecap="round"/>
                        </svg>
                    </div>

                    <div class="space-y-2 pr-12">
                        <p class="text-[#FFF9EF] text-base">
                            <span class="font-semibold">Nom :</span> {{ $commande->visiteur->nom }}
                        </p>
                        <p class="text-[#FFF9EF] text-base">
                            <span class="font-semibold">Prénom :</span> {{ $commande->visiteur->prenom }}
                        </p>
                        <p class="text-[#FFF9EF] text-base break-all">
                            <span class="font-semibold">Mail :</span> {{ $commande->visiteur->email }}
                        </p>
                    </div>
                </div>

                <div class="mb-4">
                    <p class="text-[#FFF9EF] text-base mb-1">Type de chocolat :</p>
                    <p class="text-[#FFF9EF] text-lg font-black" style="font-family: 'Kavoon', cursive;">
                        {{ $commande->chocolat->nom }}
                    </p>
                </div>

                @if($commande->allergie)
                <div class="mb-6">
                    <p class="text-[#FFF9EF] text-base mb-1">Type de garniture :</p>
                    <p class="text-[#FFF9EF] text-lg font-black" style="font-family: 'Kavoon', cursive;">
                        {{ $commande->allergie }}
                    </p>
                </div>
                @endif

                <div class="bg-[#A8C9C3] rounded-2xl p-4 flex items-center justify-center gap-3 mb-4">
                    <svg class="w-8 h-8 text-[#554840]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-[#554840] font-black text-base" style="font-family: 'Kavoon', cursive;">
                        Récapitulatif envoyé par mail
                    </span>
                </div>

                <p class="text-[#FFF9EF] text-center text-sm leading-relaxed">
                    Un mail sera aussi envoyé quand<br>la commande sera prête !
                </p>
            </div>

            <div class="fixed bottom-8 left-1/2 transform -translate-x-1/2 w-[280px] h-16 bg-[#6B5D52] rounded-full shadow-2xl flex items-center justify-around px-8 z-50">
                <a href="{{ route('home') }}" class="w-14 h-14 bg-[#524539] rounded-full flex items-center justify-center hover:bg-[#3D332A] transition-colors">
                    <svg class="w-7 h-7 text-[#FFF9EF]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                    </svg>
                </a>
                <a href="{{ route('commande.formulaire') }}" class="w-14 h-14 bg-[#524539] rounded-full flex items-center justify-center hover:bg-[#3D332A] transition-colors">
                    <svg class="w-7 h-7 text-[#FFF9EF]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                    </svg>
                </a>
            </div>

            <div class="relative w-screen -mx-4 pointer-events-none">
                <img src="{{ asset('images/autre/bas_choco.svg') }}" alt="Décoration chocolat" class="w-full" />
            </div>
        </div>
    </main>
</body>
</html>
