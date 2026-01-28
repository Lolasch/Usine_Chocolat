<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Usine à Chocolat</title>

    <!-- GOOGLE FONT KAVOON -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet">

    <!-- TAILWIND CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background-color: #2f2621;
            margin: 0;
            padding: 0;
        }

        .main-container {
            width: 100%;
            max-width: 100vw;
        }

        @media (max-width: 360px) {
            .chocolat-img {
                height: 60px;
            }
            .header-logo {
                height: 48px;
            }
        }
    </style>
</head>

<body class="flex justify-center m-0 p-0">

    <!-- CONTAINER -->
    <main class="main-container bg-[#FFF9EF] text-[#3B2A21] overflow-hidden">

        <!-- HEADER -->
        <header class="bg-[#554840] py-[4%] flex justify-center">
            <img src="/images/logos/usine_choco_26_blanc2.svg" alt="Usine à Chocolat" class="header-logo h-16 mt-4" />
        </header>

        <!-- TYPES DE CHOCOLATS -->
        <section class="bg-[#ABDDCC] py-1">
            <div class="flex justify-around items-center px-[2%]">
                <div class="w-[16%]"><img src="/images/chocolats/lait.svg" class="chocolat-img w-full h-auto mx-auto" /></div>
                <div class="w-[16%]"><img src="/images/chocolats/noir_amandes.svg" class="chocolat-img w-full h-auto mx-auto" /></div>
                <div class="w-[16%]"><img src="/images/chocolats/lait_noisettes.svg" class="chocolat-img w-full h-auto mx-auto" /></div>
                <div class="w-[16%]"><img src="/images/chocolats/noir.svg" class="chocolat-img w-full h-auto mx-auto" /></div>
                <div class="w-[16%]"><img src="/images/chocolats/lait_amandes.svg" class="chocolat-img w-full h-auto mx-auto" /></div>
                <div class="w-[16%]"><img src="/images/chocolats/noir_noisettes.svg" class="chocolat-img w-full h-auto mx-auto" /></div>
            </div>
        </section>

        <!-- COMMANDE -->
        <section class="relative min-h-[62vh] py-[3%] px-[5%] text-center bg-[url('/images/autre/fond_accueil.svg')] bg-cover bg-center bg-no-repeat">
            <img src="/images/logos/usine_choco_26_couleur.svg" class="absolute top-[15%] left-1/2 -translate-x-1/2 h-auto w-[45%] max-w-[180px] z-10" alt="Logo" />
            <button onclick="window.location.href='/formulaire'"
                    class="absolute top-[52%] left-1/2 -translate-x-1/2 bg-[#8E5442] hover:bg-[#7a4636] text-white font-normal leading-tight px-[8%] py-[4%] rounded-3xl shadow-[6px_6px_0_0_#554840] z-20 text-xl min-w-[200px] transition-all duration-200 hover:shadow-[4px_4px_0_0_#554840] active:scale-95 active:shadow-[2px_2px_0_0_#554840]"
                    style="font-family: 'Kavoon', cursive;">
                <span class="block text-xl leading-tight">Cliquez pour</span>
                <span class="block text-xl leading-tight">commander</span>
            </button>


            <div class="absolute top-[75%] right-[12%] z-10">
                <button class="w-12 h-12 bg-[#ABDDCC] rounded-full flex items-center justify-center shadow-md hover:bg-[#96c9c2] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#554840]" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 5.25 7.5 7.5 7.5-7.5m-15 6 7.5 7.5 7.5-7.5" />
                    </svg>
                </button>
            </div>
        </section>

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

        <!-- PHOTOS USINE -->
        <section class="px-[8%] py-[8%]">
            <div class="grid grid-cols-2 gap-[3%] mb-[5%]" style="height: 80vw; max-height: 320px;">
                <div class="w-full">
                    <img src="/images/autre/demo1.png" alt="Photo usine" class="h-full w-full object-cover rounded-3xl">
                </div>
                <div class="grid grid-rows-2 gap-[3%] w-full">
                    <div class="w-full">
                        <img src="/images/autre/demo2.png" alt="Photo usine" class="h-full w-full object-cover rounded-3xl">
                    </div>
                    <div class="w-full">
                        <img src="/images/autre/demo3.png" alt="Photo usine" class="h-full w-full object-cover rounded-3xl">
                    </div>
                </div>
            </div>

            <!-- Titre et texte -->
            <h2 class="text-3xl font-bold mb-6 mt-6 text-center text-[#554840]" style="font-family: 'Kavoon', cursive;">
                L'Usine à Chocolat
            </h2>
            <p class="text-md leading-relaxed text-justify">
                Depuis plusieurs années, l'IUT propose aux visiteurs des Journées Portes
                Ouvertes pour visiter une usine à chocolat. Anciennement initiée par
                les étudiants en BUT QLIO, cette année l'Usine à Chocolat ouvre ses portes
                à tous les visiteurs.
            </p>
        </section>

        <!-- SECTION VIDEO -->
        <section class="px-[8%] pb-[8%]">
            <img src="/images/autre/bulle_video.svg" alt="Vidéo Usine" class="w-full rounded-xl object-cover">
        </section>

        <section class="bg-[#554840] py-[8%] text-center text-[#A8DAD3]">
            <h2 class="text-3xl font-medium mb-4 text-center text-[#ABDDCC]" style="font-family: 'Kavoon', cursive;">
                Vidéo Usine Chocolat
            </h2>
            <div class="mx-[5%]">
                <video
                    src="/videos/motion.mp4"
                    loop
                    muted
                    controls
                    playsinline
                    class="w-full h-full max-h-[200px] rounded-2xl object-cover shadow-2xl hover:shadow-3xl transition-all duration-300"
                >
                    Votre navigateur ne supporte pas la vidéo.
                </video>
            </div>
        </section>


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
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4 4 0 2.209 1.791 4 4 4s4-1.791 4-4c0-2.21-1.791-4-4-4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
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
