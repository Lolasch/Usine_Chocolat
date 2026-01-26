<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChocoL'at - Chocolaterie artisanale</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-text { background: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
    </style>
</head>
<body class="bg-gradient-to-b from-orange-50 to-amber-100 min-h-screen font-sans">

    <!-- Header -->
    <header class="bg-white/90 backdrop-blur-md shadow-sm sticky top-0 z-50 p-4">
        <div class="flex justify-between items-center">
            <div class="text-2xl font-bold gradient-text">🍫 ChocoL'at</div>
            <button class="p-2">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </header>

    <!-- Hero -->
    <section class="px-6 py-12 text-center">
        <h1 class="text-4xl font-bold gradient-text mb-6 leading-tight">
            La Chocolaterie
        </h1>
        <p class="text-lg text-gray-700 mb-10 leading-relaxed max-w-md mx-auto">
            Personnalisez votre chocolat sur mesure avec notre atelier de chocolaterie artisanale.
        </p>
        <button class="bg-gradient-to-r from-orange-600 to-amber-700 hover:from-orange-700 hover:to-amber-800 text-white px-12 py-4 rounded-full text-xl font-semibold shadow-xl w-full mb-4 transform hover:scale-[1.02] transition-all duration-200">
            Commander maintenant
        </button>
        <button class="border-4 border-orange-600 text-orange-600 hover:bg-orange-600 hover:text-white px-12 py-4 rounded-full text-xl font-semibold w-full transform hover:scale-[1.02] transition-all duration-200">
            Découvrir
        </button>
    </section>

    <!-- Section 1: L'atelier -->
    <section class="px-6 py-12 bg-white/50 rounded-3xl mx-6 -mt-12 relative z-10 shadow-2xl">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">L'Atelier Chocolat</h2>
            <p class="text-gray-700 mb-8 leading-relaxed">
                Découvrez notre atelier où chaque chocolat est fabriqué avec passion par des maîtres chocolatiers.
            </p>
            <div class="grid grid-cols-2 gap-4 mb-8">
                <div class="bg-orange-100 p-4 rounded-2xl">
                    <div class="w-16 h-16 bg-orange-500 rounded-full mx-auto mb-2 flex items-center justify-center">
                        🍫
                    </div>
                    <p class="font-semibold text-gray-800">Chocolat pur</p>
                </div>
                <div class="bg-orange-100 p-4 rounded-2xl">
                    <div class="w-16 h-16 bg-orange-500 rounded-full mx-auto mb-2 flex items-center justify-center">
                        ✨
                    </div>
                    <p class="font-semibold text-gray-800">Fait main</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="px-6 py-16">
        <div class="space-y-12">
            <!-- Qualité -->
            <div class="bg-gradient-to-r from-orange-500/20 to-amber-500/20 p-8 rounded-3xl">
                <div class="flex items-start space-x-4">
                    <div class="w-16 h-16 bg-white/80 rounded-2xl flex items-center justify-center shadow-lg">
                        <span class="text-2xl">⭐</span>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Qualité artisanale</h3>
                        <p class="text-gray-700 leading-relaxed">Chaque chocolat est une œuvre d'art fabriquée avec des ingrédients premium.</p>
                    </div>
                </div>
            </div>

            <!-- Personnalisation -->
            <div class="bg-gradient-to-r from-orange-500/20 to-amber-500/20 p-8 rounded-3xl">
                <div class="flex items-start space-x-4">
                    <div class="w-16 h-16 bg-white/80 rounded-2xl flex items-center justify-center shadow-lg">
                        <span class="text-2xl">🎨</span>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">100% personnalisé</h3>
                        <p class="text-gray-700 leading-relaxed">Créez votre chocolat selon vos goûts, allergies et envies.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="px-6 py-16 bg-gradient-to-b from-orange-600 to-amber-700 rounded-3xl mx-6 -mt-12 relative z-10 shadow-2xl text-white">
        <div class="text-center">
            <h2 class="text-3xl font-bold mb-6">Votre chocolat sur mesure vous attend</h2>
            <p class="text-xl mb-10 opacity-90">Commandez dès maintenant</p>
            <button class="bg-white text-orange-600 px-16 py-6 rounded-full text-xl font-bold shadow-2xl w-full transform hover:scale-[1.02] transition-all duration-200">
                Passer commandeee
            </button>
        </div>
    </section>

    <!-- Footer -->
    <footer class="px-6 py-12 text-center text-gray-600 bg-white/50 rounded-t-3xl mx-6 -mt-12 shadow-2xl">
        <div class="text-2xl font-bold gradient-text mb-4">🍫 ChocoL'at</div>
        <p class="mb-6">Chocolaterie artisanale - Fabrication sur mesure</p>
        <div class="flex flex-col space-y-2 text-sm">
            <a href="#" class="hover:text-orange-600">Mentions légales</a>
            <a href="#" class="hover:text-orange-600">CGV</a>
            <a href="#" class="hover:text-orange-600">Contact</a>
        </div>
    </footer>
</body>
</html>
