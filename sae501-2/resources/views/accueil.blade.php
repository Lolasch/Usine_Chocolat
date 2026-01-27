<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Usine à Chocolat</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    /* Pour garder un rendu très mobile */
    body {
      background-color: #2f2621;
    }
  </style>
</head>

<body class="flex justify-center">

  <!-- CONTAINER -->
  <main class="w-full max-w-[390px] bg-[#FFF9EF] text-[#3B2A21] overflow-hidden">

    <!-- HEADER -->
    <header class="bg-[#554840] py-6 flex justify-center">
      <img
        src="/images/logos/usine_choco_26_blanc2.svg"
        alt="Usine à Chocolat"
        class="h-16 mt-2"
      />
    </header>

    <!-- TYPES DE CHOCOLATS -->
    <section class="bg-[#ABDDCC] py-1">
        <div class="flex justify-around items-center">
            <div>
            <img src="/images/chocolats/lait.svg" class="h-20 mx-auto" />
            </div>
            <div>
            <img src="/images/chocolats/lait_amandes.svg" class="h-20 mx-auto" />
            </div>
            <div>
            <img src="/images/chocolats/lait_noisettes.svg" class="h-20 mx-auto" />
            </div>
            <div>
            <img src="/images/chocolats/noir.svg" class="h-20 mx-auto" />
            </div>
            <div>
            <img src="/images/chocolats/noir_amandes.svg" class="h-20 mx-auto" />
            </div>
            <div>
            <img src="/images/chocolats/noir_noisettes.svg" class="h-20 mx-auto" />
            </div>
        </div>
    </section>

    <!-- COMMANDE -->
    <section class="relative min-h-[62vh] py-5 px-6 text-center bg-[url('/images/autre/fond_accueil.svg')] bg-cover bg-center bg-no-repeat">
        <img src="/images/logos/usine_choco_26_couleur.svg" class="absolute top-[15%] left-1/2 -translate-x-1/2 h-auto w-44 z-10" alt="Logo" />

        <button class="absolute top-[55%] left-1/2 -translate-x-1/2 bg-[#8E5442] text-white font-semibold leading-tight px-6 py-4 rounded-3xl shadow-[5px_5px_0_0_#554840] z-20">
            <span class="block">Cliquez pour</span>
            <span class="block">commander</span>
        </button>

        <div class="absolute top-[75%] right-6 z-10">
            <button class="w-12 h-12 bg-[#ABDDCC] rounded-full flex items-center justify-center shadow-md hover:bg-[#96c9c2] transition">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 text-[#554840]"
                    fill="none" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 5.25 7.5 7.5 7.5-7.5m-15 6 7.5 7.5 7.5-7.5" />
                </svg>
            </button>
        </div>
    </section>

    <!-- NAV BAR -->
    <nav class="bg-[#6B4A3A] py-3 flex justify-around">
      <div class="w-12 h-12 bg-[#4A3A32] rounded-full flex items-center justify-center text-white">
        🏠
      </div>
      <div class="w-12 h-12 bg-[#4A3A32] rounded-full flex items-center justify-center text-white">
        🔒
      </div>
    </nav>

    <!-- PHOTOS USINE -->
    <section class="px-6 py-8">
    <!-- Galerie photos -->
    <div class="grid grid-cols-2 gap-4 mb-8 h-80">
        <!-- Photo verticale (gauche) -->
        <div class="bg-[#CFC0B5] rounded-lg">
        <img src="/images/autre/demo1.png" alt="Photo usine" class="h-full w-full object-cover rounded-lg">
        </div>

        <!-- Côté droit : deux photos empilées -->
        <div class="grid grid-rows-2 gap-4">
        <div class="bg-[#CFC0B5] rounded-lg">
            <img src="/images/autre/demo2.png" alt="Photo usine" class="h-full w-full object-cover rounded-lg">
        </div>
        <div class="bg-[#CFC0B5] rounded-lg">
            <img src="/images/autre/demo3.png" alt="Photo usine" class="h-full w-full object-cover rounded-lg">
        </div>
        </div>
    </div>

    <!-- Titre et texte -->
    <h2 class="text-2xl font-bold mb-4">L’Usine à Chocolat</h2>
    <p class="text-sm leading-relaxed">
        Depuis plusieurs années, l’IUT propose aux visiteurs des Journées Portes
        Ouvertes pour visiter une usine à chocolat. Anciennement initiée par
        les étudiants en BUT QLIO, cette année l’Usine à Chocolat ouvre ses portes
        à tous les visiteurs.
    </p>
    </section>

    <!-- SECTION VIDEO -->
    <section class="px-6 pb-8">
    <img src="/images/autre/bulle_video.svg" alt="Vidéo Usine" class="w-full rounded-xl object-cover">
    </section>



    <!-- VIDEO SECTION -->
    <section class="bg-[#4A3A32] py-10 text-center text-[#A8DAD3]">
      <h3 class="text-2xl font-bold mb-6">Vidéo Usine Chocolat</h3>

      <!-- Placeholder vidéo -->
      <div class="mx-6 h-48 bg-[#2F2621] rounded-xl flex items-center justify-center text-white">
        Vidéo ici
      </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-[#4A3A32] text-[#F8EFE6] text-center py-10 px-6">
      <img
        src="/images/logos/usine_choco_26_blanc.svg"
        class="h-16 mx-auto mb-6"
      />

      <button class="bg-[#7A4A32] px-6 py-3 rounded-full mb-6">
        Site de l’IUT
      </button>

      <div class="bg-white rounded-lg p-4 mb-6">
        <img src="/images/logos/hag.png" class="mx-auto" />
      </div>

      <div class="flex justify-center gap-4 mb-4">
        <div class="w-10 h-10 bg-[#7A4A32] rounded-full"></div>
        <div class="w-10 h-10 bg-[#7A4A32] rounded-full"></div>
        <div class="w-10 h-10 bg-[#7A4A32] rounded-full"></div>
      </div>

      <p class="text-xs">
        Copyright 2025<br/>
        DRINNHAUSEN Lou - SCHMITT Lola
      </p>

      <div class="flex justify-center gap-4 mt-2 text-xs underline">
        <a href="#">Mentions légales</a>
        <a href="#">Crédits</a>
      </div>
    </footer>

  </main>

</body>
</html>
