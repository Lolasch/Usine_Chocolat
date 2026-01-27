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

  <!-- CONTAINER MOBILE -->
  <main class="w-full max-w-[390px] bg-[#F8EFE6] text-[#3B2A21] overflow-hidden">

    <!-- HEADER -->
    <header class="bg-[#4A3A32] py-6 flex justify-center">
      <img
        src="/images/logos/usine_choco_26_blanc2.svg"
        alt="Usine à Chocolat"
        class="h-14"
      />
    </header>

    <!-- TYPES DE CHOCOLATS -->
    <section class="bg-[#6B4A3A] py-4">
      <div class="flex justify-around text-center text-xs text-[#F8EFE6]">
        <div>
          <img src="/images/chocolats/lait.svg" class="h-10 mx-auto mb-1" />
          <p>Lait</p>
        </div>
        <div>
          <img src="/images/chocolats/lait_amandes.svg" class="h-10 mx-auto mb-1" />
        </div>
        <div>
          <img src="/images/chocolats/lait_noisettes.svg" class="h-10 mx-auto mb-1" />
          <p>Lait<br/>Noisettes</p>
        </div>
        <div>
          <img src="/images/chocolats/noir.svg" class="h-10 mx-auto mb-1" />
          <p>Noir</p>
        </div>
        <div>
          <img src="/images/chocolats/noir_amandes.svg" class="h-10 mx-auto mb-1" />
          <p>Noir<br/>Amandes</p>
        </div>
      </div>
    </section>

    <!-- HERO -->
    <section class="py-10 px-6 text-center relative">
      <img
        src="/images/logos/usine_choco_26_couleur.svg"
        class="h-24 mx-auto mb-6"
        alt="Logo"
      />

      <button class="bg-[#7A4A32] text-white px-8 py-4 rounded-full text-lg font-semibold shadow">
        Cliquez pour commander
      </button>

      <!-- Scroll indicator -->
      <div class="mt-6 flex justify-center">
        <div class="w-10 h-10 bg-[#A8DAD3] rounded-full flex items-center justify-center">
          ↓
        </div>
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
    <section class="px-6 py-10">
      <div class="grid grid-cols-2 gap-4 mb-6">
        <!-- Placeholders photos -->
        <div class="h-32 bg-[#CFC0B5] rounded-lg"></div>
        <div class="h-32 bg-[#CFC0B5] rounded-lg"></div>
        <div class="h-32 bg-[#CFC0B5] rounded-lg"></div>
        <div class="h-32 bg-[#CFC0B5] rounded-lg"></div>
      </div>

      <h2 class="text-2xl font-bold mb-4">L’Usine à Chocolat</h2>
      <p class="text-sm leading-relaxed mb-6">
        Depuis plusieurs années, l’IUT propose aux visiteurs des Journées Portes
        Ouvertes pour visiter une usine à chocolat. Anciennement initiée par
        les étudiants en BUT QLIO, cette année l’Usine à Chocolat ouvre ses portes
        à tous les visiteurs.
      </p>

      <div class="flex items-center gap-4">
        <div class="w-14 h-14 bg-[#7AC7BD] rounded-full flex items-center justify-center">
          🙂
        </div>
        <div class="bg-[#F3D18C] px-4 py-2 rounded-full text-sm font-semibold">
          Regarde la vidéo en dessous !!
        </div>
      </div>
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
