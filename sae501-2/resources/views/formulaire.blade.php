<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commander - L'usine à chocolat</title>

    <!-- TAILWIND CSS VIA CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        html, body {
            background-color: #FFF9EF !important;
            margin: 0;
            padding: 0;
        }
    </style>

    <!-- CONFIG COULEURS CHOCOLAT -->
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
    <!-- CONTAINER MOBILE -->
    <main class="w-full max-w-[390px] bg-[#FFF9EF] text-[#3B2A21] overflow-hidden min-h-screen">
        <!-- HEADER -->
        <header class="bg-[#554840] py-6 flex justify-center">
            <img src="images/logos/usine_choco_26_blanc2.svg" alt="Usine à Chocolat" class="h-14" />
        </header>

        <!-- CONTENU PRINCIPAL -->
        <div class="pt-6 pb-48 px-4">
            <div class="w-full bg-[#554840] rounded-[32px] p-6 relative mb-4">

                <h1 class="text-2xl font-black text-[#A8C9C3] mb-6 text-center" style="font-family: 'Comic Sans MS', cursive, sans-serif;">Passez commande</h1>

                <!-- Formulaire -->
                <form action="/commandes" method="POST" class="space-y-4">

                    <!-- Nom -->
                    <div>
                        <label class="block text-base font-black text-[#FFF9EF] mb-1" style="font-family: 'Comic Sans MS', cursive, sans-serif;">Nom</label>
                        <input type="text"
                               name="nom"
                               required
                               class="w-full h-12 px-4 border-0 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#A8C9C3] bg-[#FFF9EF] text-[#554840] text-base placeholder-[#8B7355]"
                               placeholder="Exemple : SCHMITT">
                    </div>

                    <!-- Prénom -->
                    <div>
                        <label class="block text-base font-black text-[#FFF9EF] mb-1" style="font-family: 'Comic Sans MS', cursive, sans-serif;">Prénom</label>
                        <input type="text"
                               name="prenom"
                               required
                               class="w-full h-12 px-4 border-0 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#A8C9C3] bg-[#FFF9EF] text-[#554840] text-base placeholder-[#8B7355]"
                               placeholder="Exemple : Lola">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-base font-black text-[#FFF9EF] mb-1" style="font-family: 'Comic Sans MS', cursive, sans-serif;">Adresse mail</label>
                        <input type="email"
                               name="email"
                               required
                               class="w-full h-12 px-4 border-0 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#A8C9C3] bg-[#FFF9EF] text-[#554840] text-base placeholder-[#8B7355]"
                               placeholder="Exemple : lola.schmitt@gmail.com">
                    </div>

                    <!-- Type de chocolat -->
                    <div>
                        <label class="block text-base font-black text-[#FFF9EF] mb-1" style="font-family: 'Comic Sans MS', cursive, sans-serif;">Type de chocolat</label>
                        <select name="type_chocolat"
                                required
                                class="w-full h-12 px-4 border-0 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#A8C9C3] bg-[#FFF9EF] text-[#8B7355] text-base appearance-none cursor-pointer">
                            <option value="">-- Choix du chocolat --</option>
                            <option value="chocolat_noir" class="text-[#554840]">Chocolat noir</option>
                            <option value="chocolat_noir_amandes" class="text-[#554840]">Chocolat noir aux amandes</option>
                            <option value="chocolat_noir_noisettes" class="text-[#554840]">Chocolat noir aux noisettes</option>
                            <option value="chocolat_lait" class="text-[#554840]">Chocolat au lait</option>
                            <option value="chocolat_lait_amandes" class="text-[#554840]">Chocolat lait aux amandes</option>
                            <option value="chocolat_lait_noisettes" class="text-[#554840]">Chocolat lait aux noisettes</option>
                        </select>
                    </div>

                    <!-- Allergies -->
                    <div>
                        <label class="block text-base font-black text-[#FFF9EF] mb-1" style="font-family: 'Comic Sans MS', cursive, sans-serif;">Allergies</label>
                        <textarea name="allergies"
                                  rows="2"
                                  class="w-full px-4 py-2 border-0 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#A8C9C3] bg-[#FFF9EF] text-[#554840] resize-none text-base placeholder-[#8B7355]"
                                  placeholder="Exemple : Amandes, Huile de colza ..."></textarea>
                    </div>

                    <!-- Bouton Valider -->
                    <div class="pt-2">
                        <button type="submit"
                                class="w-full h-12 bg-[#A8C9C3] hover:bg-[#90B5AF] text-[#554840] font-black text-lg rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200"
                                style="font-family: 'Comic Sans MS', cursive, sans-serif;">
                            Valider
                        </button>
                    </div>
                </form>
            </div>

            <!-- Barre de navigation en bas -->
            <div class="fixed bottom-8 left-1/2 transform -translate-x-1/2 w-[280px] h-16 bg-[#6B5D52] rounded-full shadow-2xl flex items-center justify-around px-8 z-50">
                <a href="/" class="w-14 h-14 bg-[#524539] rounded-full flex items-center justify-center hover:bg-[#3D332A] transition-colors">
                    <svg class="w-7 h-7 text-[#FFF9EF]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                    </svg>
                </a>
                <a href="/formulaire" class="w-14 h-14 bg-[#524539] rounded-full flex items-center justify-center hover:bg-[#3D332A] transition-colors">
                    <svg class="w-7 h-7 text-[#FFF9EF]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l.03-.12.9-1.63h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/>
                    </svg>
                </a>
            </div>

            <!-- Image décorative chocolat en bas -->
            <div class="relative w-screen -mx-4 pointer-events-none">
                <img src="images/autre/bas_choco.svg" alt="Décoration chocolat" class="w-full" />
            </div>
        </div>

    </main>
    <!-- FIN CONTAINER MOBILE -->

</body>
</html>
