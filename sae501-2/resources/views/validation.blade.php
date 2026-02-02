<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Confirmation - L'Usine à Chocolat 2026</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arimo:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- FAVICON -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/autre/seul_blanc.svg') }}">

    <!-- Tailwind CSS -->z
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        html, body {
            background-color: #FFF9EF !important;
            margin: 0;
            padding: 0;
            font-family: 'Arimo', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .font-kavoon {
            font-family: 'Kavoon', cursive;
        }

        @keyframes bounce-in {
            0% {
                transform: scale(0.3);
                opacity: 0;
            }
            50% {
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-bounce-in {
            animation: bounce-in 0.6s ease-out;
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
        <header class="bg-[#554840] py-6 flex justify-center">
            <img src="{{ asset('images/logos/usine_choco_26_blanc2.svg') }}" alt="Usine à Chocolat" class="h-14" />
        </header>

        <!-- CONTENU PRINCIPAL -->
        <div class="pt-6 px-4 sm:px-6" role="main" aria-label="Confirmation de commande">
            <div class="w-full bg-[#554840] rounded-[32px] p-6 sm:p-8 relative mb-4">

                <!-- TITRE -->
                <h1 class="text-2xl sm:text-3xl font-black text-[#A8C9C3] mb-6 text-center leading-tight font-kavoon">
                    Merci pour votre<br>commande !
                </h1>

                <!-- NUMÉRO DE COMMANDE -->
                <div class="text-center mb-6" role="status" aria-label="Numéro de commande">
                    <p class="text-[#FFF9EF] text-base mb-2 font-medium">
                        Numéro de commande :
                    </p>
                    <p class="text-[#FFF9EF] text-2xl font-black tracking-wider font-kavoon" aria-label="Numéro {{ $commande->numero_commande }}">
                        {{ $commande->numero_commande }}
                    </p>
                </div>

                <!-- INFORMATIONS CLIENT AVEC BONHOMME -->
                <div class="bg-[#6B5D52] rounded-2xl p-6 mb-6 relative" role="region" aria-label="Informations du client">
                    <!-- Image chocolat BIEN EN DANS le bloc -->
                    <img src="{{ asset('images/autre/seul_blanc.svg') }}"
                         alt="Chocolat"
                         class="absolute right-3 top-3 w-12 h-12 object-contain">

                    <div class="pr-16 space-y-1.5">
                        <p class="text-[#FFF9EF] text-base leading-tight">
                            <span class="font-bold">Nom :</span> {{ $commande->visiteur->nom }}
                        </p>
                        <p class="text-[#FFF9EF] text-base leading-tight">
                            <span class="font-bold">Prénom :</span> {{ $commande->visiteur->prenom }}
                        </p>
                        <p class="text-[#FFF9EF] text-sm leading-tight break-words">
                            <span class="font-bold">Mail :</span> {{ $commande->visiteur->email }}
                        </p>
                    </div>
                </div>

                <!-- TYPE DE CHOCOLAT -->
                <div class="mb-6">
                    <p class="text-[#FFF9EF] text-base mb-1 font-medium">
                        Type de chocolat :
                    </p>
                    <p class="text-[#FFF9EF] text-lg font-bold leading-tight">
                        {{ $commande->chocolat->nom }}
                    </p>
                </div>

                <!-- SUIVI DE COMMANDE -->
                <div class="mb-6 bg-[#6B5D52] rounded-2xl p-6 shadow-lg" id="suivi-commande" role="region" aria-label="Suivi de commande en temps réel" aria-live="polite">
                    <div class="flex items-center justify-center gap-3 mb-5">
                        <svg class="w-7 h-7 text-[#A8C9C3]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        <p class="text-[#A8C9C3] text-xl mb-0 font-black text-center">
                            Suivi de votre commande
                        </p>
                    </div>

                    <div class="space-y-3" id="etapes-container" role="list" aria-label="Étapes de production">
                        @foreach($etapes as $etape)
                            @php
                                $estActuel = $posteActuel && $posteActuel->nom_poste === $etape->nom;
                                $estPasse = $posteActuel && $etape->ordre < $posteActuel->ordre;
                                $estFutur = !$posteActuel || $etape->ordre > $posteActuel->ordre;

                                if ($commande->finalisee) {
                                    $estPasse = true;
                                    $estActuel = false;
                                    $estFutur = false;
                                }
                            @endphp

                            <div class="flex items-center gap-4 p-4 rounded-xl shadow-lg transform transition-all {{ $estActuel ? 'bg-[#A8C9C3] scale-105' : ($estPasse ? 'bg-[#FFF9EF]' : 'bg-[#554840]') }}" role="listitem" aria-label="Étape {{ $etape->nom }}, statut : {{ $estActuel ? 'en cours' : ($estPasse ? 'terminée' : 'à venir') }}">
                                <!-- Icône -->
                                <div class="flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center shadow-md {{ $estActuel ? 'bg-[#554840]' : ($estPasse ? 'bg-[#A8C9C3]' : 'bg-[#FFF9EF]/20') }}" aria-hidden="true">
                                    @if($estPasse)
                                        <svg class="w-7 h-7 text-[#554840]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    @elseif($estActuel)
                                        <svg class="w-7 h-7 text-[#A8C9C3] animate-spin" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    @else
                                        <div class="w-3 h-3 rounded-full bg-[#FFF9EF]/40"></div>
                                    @endif
                                </div>

                                <!-- Texte -->
                                <div class="flex-1">
                                    <p class="font-black text-xl {{ $estActuel || $estPasse ? 'text-[#554840]' : 'text-[#FFF9EF]/70' }}">
                                        {{ $etape->nom }}
                                    </p>
                                    @if($estActuel)
                                        <p class="text-sm text-[#554840] font-bold mt-1">En cours de fabrication...</p>
                                    @elseif($estPasse)
                                        <p class="text-sm text-[#554840]/80 font-bold mt-1">Terminé</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        @if($commande->finalisee)
                            <div class="flex items-center gap-4 p-5 rounded-xl bg-[#A8C9C3] shadow-xl transform scale-105" role="status" aria-label="Commande terminée et prête à récupérer">
                                <div class="flex-shrink-0 w-14 h-14 rounded-full flex items-center justify-center bg-[#554840] shadow-md" aria-hidden="true">
                                    <svg class="w-8 h-8 text-[#A8C9C3]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-black text-xl text-[#554840]">Commande prête !</p>
                                    <p class="text-sm text-[#554840] font-bold mt-1">Vous pouvez la récupérer maintenant</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- ALLERGIE -->
                @if($commande->allergie)
                <div class="mb-6">
                    <p class="text-[#FFF9EF] text-base mb-1 font-medium">
                        Allergie :
                    </p>
                    <p class="text-[#FFF9EF] text-lg font-bold leading-tight">
                        {{ $commande->allergie }}
                    </p>
                </div>
                @endif

                <!-- BADGE EMAIL -->
                <div class="bg-[#A8C9C3] rounded-2xl p-4 flex items-center justify-center gap-3 mb-4 shadow-md" role="status" aria-label="Confirmation par email">
                    <svg class="w-8 h-8 text-[#554840]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-[#554840] font-black text-base font-arimo">
                        Récapitulatif envoyé par mail
                    </span>
                </div>

                <!-- MESSAGE INFO -->
                <p class="text-[#FFF9EF] text-center text-sm leading-relaxed font-medium">
                    Un mail sera aussi envoyé quand<br>la commande sera prête !
                </p>
            </div>

            <!-- NAV BAR -->
            <nav class="fixed bottom-8 left-1/2 -translate-x-1/2 w-[300px] h-16 bg-[#8E5442] rounded-full shadow-2xl flex items-center justify-around px-8 py-9 z-50 border-4 border-[#554840]/100" role="navigation" aria-label="Navigation principale">
                <a href="/accueil" class="w-16 h-14 bg-[#524539] rounded-t-[2.25rem] rounded-b-2xl flex items-center justify-center transition-all duration-200 group shadow-[0px_10px_30px_rgba(0,0,0,0.3)] active:scale-95" aria-label="Retour à l'accueil">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-9 h-9 text-[#FFF9EF] group-hover:text-[#ABDDCC] drop-shadow-sm" aria-hidden="true">
                        <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 0 1 1.414 0l7 7A1 1 0 0 1 17 11h-1v6a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-6H3a1 1 0 0 1-.707-1.707l7-7Z" clip-rule="evenodd" />
                    </svg>
                </a>

                <a href="/formulaire" class="w-16 h-14 bg-[#524539] rounded-t-[2.25rem] rounded-b-2xl flex items-center justify-center transition-all duration-200 group shadow-[0px_10px_30px_rgba(0,0,0,0.3)] active:scale-95" aria-label="Nouvelle commande">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-9 h-9 text-[#FFF9EF] group-hover:text-[#ABDDCC] drop-shadow-sm" aria-hidden="true">
                        <path fill-rule="evenodd" d="M6 5v1H4.667a1.75 1.75 0 0 0-1.743 1.598l-.826 9.5A1.75 1.75 0 0 0 3.84 19H16.16a1.75 1.75 0 0 0 1.743-1.902l-.826-9.5A1.75 1.75 0 0 0 15.333 6H14V5a4 4 0 0 0-8 0Zm4-2.5A2.5 2.5 0 0 0 7.5 5v1h5V5A2.5 2.5 0 0 0 10 2.5ZM7.5 10a2.5 2.5 0 0 0 5 0V8.75a.75.75 0 0 1 1.5 0V10a4 4 0 0 1-8 0V8.75a.75.75 0 0 1 1.5 0V10Z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- POPUP MERCI -->
        <div id="popup-merci" class="fixed inset-0 bg-black/70 flex items-center justify-center z-[100] hidden" role="dialog" aria-labelledby="popup-titre" aria-modal="true" onclick="event.stopPropagation()">
            <div class="bg-[#554840] rounded-3xl p-8 max-w-md mx-4 shadow-2xl transform transition-all animate-bounce-in" onclick="event.stopPropagation()">
                <div class="text-center">
                    <div class="mb-6">
                        <svg class="w-20 h-20 mx-auto text-[#A8C9C3] animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>

                    <h2 id="popup-titre" class="text-2xl font-black text-[#A8C9C3] mb-4">
                        Merci d'avoir commandé !
                    </h2>

                    <p class="text-[#FFF9EF] text-base mb-6 leading-relaxed">
                        Votre commande est prête.<br>
                        N'hésitez pas à nous donner votre avis !
                    </p>

                    <div class="flex flex-col gap-3">
                        <button onclick="window.location.href='/avis'" class="bg-[#A8C9C3] hover:bg-[#96c9c2] text-[#554840] font-black py-3 px-6 rounded-xl transition-all duration-200 shadow-md active:scale-95">
                            Donner mon avis
                        </button>
                        <button onclick="fermerPopup()" class="bg-[#6B5D52] hover:bg-[#5a4e44] text-[#FFF9EF] font-bold py-3 px-6 rounded-xl transition-all duration-200 shadow-md active:scale-95">
                            Fermer
                        </button>
                    </div>
                </div>
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
                <button class="w-12 h-12 bg-[#ABDDCC] hover:bg-[#96c9c2] rounded-full flex items-center justify-center shadow-lg transition-all duration-200 active:scale-95" aria-label="Retour en haut de page" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#554840]" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 18.75 7.5-7.5 7.5 7.5" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 7.5-7.5 7.5 7.5" />
                    </svg>
                </button>
            </div>

            <div class="pt-[18%] relative z-30">
                <a href="#" class="bg-[#7A4A32] hover:bg-[#65412a] transition-all duration-200 px-[5%] py-3 mb-6 text-sm font-medium shadow-lg mx-auto block tracking-wide rounded-t-[2rem] rounded-b-lg" aria-label="Visiter le site de l'IUT de Haguenau">
                    Site de l'IUT
                </a>

                <div class="p-4 mb-6 w-[90%] max-w-[250px] mx-auto">
                    <img src="/images/logos/haguenau.png" alt="IUT Haguenau" class="w-full h-auto rounded-lg mx-auto" />
                </div>

                <div class="flex justify-center gap-4 mb-4 w-[150px] mx-auto relative z-10" role="navigation" aria-label="Réseaux sociaux">
                    <a href="#" aria-label="Suivez-nous sur Instagram" class="w-10 h-10 bg-[#7A4A32] hover:bg-[#65412a] rounded-full flex items-center justify-center transition-all duration-200 shadow-md active:scale-95 group">
                        <svg class="w-5 h-5 text-[#FFF9EF] group-hover:text-[#ABDDCC]" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    <a href="#" aria-label="Suivez-nous sur Facebook" class="w-10 h-10 bg-[#7A4A32] hover:bg-[#65412a] rounded-full flex items-center justify-center transition-all duration-200 shadow-md active:scale-95 group">
                        <svg class="w-5 h-5 text-[#FFF9EF] group-hover:text-[#ABDDCC]" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="#" aria-label="Suivez-nous sur YouTube" class="w-10 h-10 bg-[#7A4A32] hover:bg-[#65412a] rounded-full flex items-center justify-center transition-all duration-200 shadow-md active:scale-95 group">
                        <svg class="w-5 h-5 text-[#FFF9EF] group-hover:text-[#ABDDCC]" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                </div>

                <p class="text-lg leading-relaxed mb-2 px-2">Copyright 2026<br/>DRINNHAUSEN Lou - SCHMITT Lola</p>

                <div class="flex justify-center gap-4 text-lg underline mb-24">
                    <a href="#" class="hover:text-white/80 transition-colors duration-200" aria-label="Consulter les mentions légales">Mentions légales</a>
                    <a href="#" class="hover:text-white/80 transition-colors duration-200" aria-label="Consulter les crédits">Crédits</a>
                </div>
            </div>
        </footer>
    </main>

    <script>
        const numeroCommande = '{{ $commande->numero_commande }}';
        let commandeFinalisee = {{ $commande->finalisee ? 'true' : 'false' }};

        async function rafraichirStatut() {
            if (commandeFinalisee) {
                return;
            }

            try {
                const response = await fetch(`/api/commande/${numeroCommande}/statut`);
                const data = await response.json();

                if (data.finalisee !== commandeFinalisee) {
                    commandeFinalisee = data.finalisee;
                    if (data.finalisee) {
                        afficherPopup();
                    }
                }

                mettreAJourInterface(data);
            } catch (error) {
                console.error('Erreur lors de la récupération du statut:', error);
            }
        }

        function mettreAJourInterface(data) {
            const container = document.getElementById('etapes-container');
            let html = '';

            data.etapes.forEach(etape => {
                let estActuel = data.posteActuel && data.posteActuel.nom_poste === etape.nom;
                let estPasse = data.posteActuel && etape.ordre < data.posteActuel.ordre;

                if (data.finalisee) {
                    estPasse = true;
                    estActuel = false;
                }

                const bgClass = estActuel ? 'bg-[#A8C9C3] scale-105' : (estPasse ? 'bg-[#FFF9EF]' : 'bg-[#554840]');
                const iconBgClass = estActuel ? 'bg-[#554840]' : (estPasse ? 'bg-[#A8C9C3]' : 'bg-[#FFF9EF]/20');
                const textClass = estActuel || estPasse ? 'text-[#554840]' : 'text-[#FFF9EF]/70';

                html += `
                    <div class="flex items-center gap-4 p-4 rounded-xl shadow-lg transform transition-all ${bgClass}">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center shadow-md ${iconBgClass}">`;

                if (estPasse) {
                    html += `
                            <svg class="w-7 h-7 text-[#554840]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>`;
                } else if (estActuel) {
                    html += `
                            <svg class="w-7 h-7 text-[#A8C9C3] animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>`;
                } else {
                    html += `<div class="w-3 h-3 rounded-full bg-[#FFF9EF]/40"></div>`;
                }

                html += `
                        </div>
                        <div class="flex-1">
                            <p class="font-black text-xl ${textClass}">
                                ${etape.nom}
                            </p>`;

                if (estActuel) {
                    html += `<p class="text-sm text-[#554840] font-bold mt-1">En cours de fabrication...</p>`;
                } else if (estPasse) {
                    html += `<p class="text-sm text-[#554840]/80 font-bold mt-1">Terminé</p>`;
                }

                html += `
                        </div>
                    </div>`;
            });

            if (data.finalisee) {
                html += `
                    <div class="flex items-center gap-4 p-5 rounded-xl bg-[#A8C9C3] shadow-xl transform scale-105">
                        <div class="flex-shrink-0 w-14 h-14 rounded-full flex items-center justify-center bg-[#554840] shadow-md">
                            <svg class="w-8 h-8 text-[#A8C9C3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-black text-xl text-[#554840]">Commande prête !</p>
                            <p class="text-sm text-[#554840] font-bold mt-1">Vous pouvez la récupérer maintenant</p>
                        </div>
                    </div>`;
            }

            container.innerHTML = html;
        }

        function afficherPopup() {
            console.log('Affichage du popup');
            const popup = document.getElementById('popup-merci');
            if (popup) {
                popup.classList.remove('hidden');
                console.log('Popup affiché');
            } else {
                console.error('Element popup-merci introuvable');
            }
        }

        function fermerPopup() {
            document.getElementById('popup-merci').classList.add('hidden');
        }

        // Afficher la popup si la commande est déjà finalisée au chargement
        @if($commande->finalisee)
            console.log('Commande finalisée détectée');
            setTimeout(() => {
                console.log('Affichage du popup');
                afficherPopup();
            }, 1000);
        @else
            console.log('Commande non finalisée');
        @endif

        setInterval(rafraichirStatut, 3000);
    </script>
</body>
</html>
