<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentions Légales & Crédits - L'Usine à Chocolat 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet">
    <style>
        .font-kavoon { font-family: 'Kavoon', cursive; }
        :root {
            --choco-brown: #554840;
            --choco: #8E5442;
            --choco-beige: #FFF9EF;
            --choco-gold: #FCE097;
            --caramel: #FDAD42;
            --green: #ABDDCC;
        }
    </style>
</head>
<body class="bg-[var(--choco-gold)] text-[var(--choco-brown)]">
    <!-- HEADER -->
    <header class="bg-[var(--choco-brown)] text-[var(--choco-beige)]">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <a href="{{ url('/accueil') }}" class="flex items-center gap-4">
                <img src="{{ asset('images/logos/usine_choco_26_blanc2.svg') }}" alt="Usine Chocolat" class="h-16">
            </a>
        </div>
    </header>

    <!-- CONTENU PRINCIPAL -->
    <main class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto bg-[var(--choco-beige)] rounded-3xl p-8 shadow-lg">

            <h1 class="font-kavoon text-4xl text-[var(--choco-brown)] mb-8 text-center">
                Mentions Légales & Crédits
            </h1>

            <!-- MENTIONS LÉGALES -->
            <section class="mb-12">
                <h2 class="font-kavoon text-2xl text-[var(--choco-brown)] mb-4 border-b-2 border-[var(--caramel)] pb-2">
                    Mentions Légales
                </h2>

                <div class="space-y-6">
                    <div>
                        <h3 class="font-bold text-lg text-[var(--choco)] mb-2">Éditeur</h3>
                        <p class="text-sm">
                            L'Usine à Chocolat 2026<br>
                            Université de Strasbourg - MMI<br>
                            France
                        </p>
                    </div>

                    <div>
                        <h3 class="font-bold text-lg text-[var(--choco)] mb-2">Responsable de publication</h3>
                        <p class="text-sm">
                            Projet SAE 501 - Semestre 5 MMI
                        </p>
                    </div>

                    <div>
                        <h3 class="font-bold text-lg text-[var(--choco)] mb-2">Hébergement</h3>
                        <p class="text-sm">
                            Serveur Plesk - Hosting OVH<br>
                            L'application est déployée en continu via Plesk.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-bold text-lg text-[var(--choco)] mb-2">Données personnelles</h3>
                        <p class="text-sm">
                            Les données collectées via les formulaires sont stockées de manière sécurisée et utilisées uniquement à des fins de fonctionnement de l'application.
                            Aucune donnée n'est partagée avec des tiers.
                        </p>
                    </div>

                    <div>
                        <h3 class="font-bold text-lg text-[var(--choco)] mb-2">Propriété Intellectuelle</h3>
                        <p class="text-sm">
                            L'ensemble des contenus (textes, logos, images) de ce site est la propriété exclusive de L'Usine à Chocolat 2026 ou de ses partenaires.
                        </p>
                    </div>
                </div>
            </section>

            <!-- CRÉDITS TECHNOLOGIQUES -->
            <section class="mb-12">
                <h2 class="font-kavoon text-2xl text-[var(--choco-brown)] mb-4 border-b-2 border-[var(--caramel)] pb-2">
                    Crédits Technologiques
                </h2>

                <div class="space-y-4">
                    <div class="bg-white rounded-xl p-4 border-l-4 border-[var(--caramel)]">
                        <h3 class="font-bold text-[var(--choco)]">Backend</h3>
                        <p class="text-sm mt-1">
                            <strong>Laravel 11</strong> - Framework PHP moderne<br>
                            <a href="https://laravel.com" target="_blank" class="text-[var(--caramel)] hover:underline">laravel.com</a>
                        </p>
                    </div>

                    <div class="bg-white rounded-xl p-4 border-l-4 border-[var(--caramel)]">
                        <h3 class="font-bold text-[var(--choco)]">Frontend</h3>
                        <p class="text-sm mt-1">
                            <strong>Tailwind CSS</strong> - Framework CSS utilitaire<br>
                            <a href="https://tailwindcss.com" target="_blank" class="text-[var(--caramel)] hover:underline">tailwindcss.com</a>
                        </p>
                    </div>

                    <div class="bg-white rounded-xl p-4 border-l-4 border-[var(--caramel)]">
                        <h3 class="font-bold text-[var(--choco)]">Build & Versionning</h3>
                        <p class="text-sm mt-1">
                            <strong>Vite</strong> - Module bundler<br>
                            <strong>Git</strong> - Contrôle de version<br>
                            <a href="https://vitejs.dev" target="_blank" class="text-[var(--caramel)] hover:underline">vitejs.dev</a>
                        </p>
                    </div>

                    <div class="bg-white rounded-xl p-4 border-l-4 border-[var(--caramel)]">
                        <h3 class="font-bold text-[var(--choco)]">Base de données</h3>
                        <p class="text-sm mt-1">
                            <strong>MySQL</strong> - Système de gestion de base de données<br>
                            <strong>Eloquent ORM</strong> - Mapper objet-relationnel
                        </p>
                    </div>

                    <div class="bg-white rounded-xl p-4 border-l-4 border-[var(--caramel)]">
                        <h3 class="font-bold text-[var(--choco)]">Visualisation</h3>
                        <p class="text-sm mt-1">
                            <strong>Chart.js</strong> - Libraire graphiques<br>
                            <strong>QRCode.js</strong> - Génération de codes QR<br>
                            <a href="https://www.chartjs.org" target="_blank" class="text-[var(--caramel)] hover:underline">chartjs.org</a>
                        </p>
                    </div>

                    <div class="bg-white rounded-xl p-4 border-l-4 border-[var(--caramel)]">
                        <h3 class="font-bold text-[var(--choco)]">Typographie</h3>
                        <p class="text-sm mt-1">
                            <strong>Google Fonts - Kavoon</strong> - Police personnalisée<br>
                            <strong>Google Fonts - Arimo</strong> - Police de base
                        </p>
                    </div>
                </div>
            </section>

            <!-- ÉQUIPE -->
            <section class="mb-12">
                <h2 class="font-kavoon text-2xl text-[var(--choco-brown)] mb-4 border-b-2 border-[var(--caramel)] pb-2">
                    Équipe
                </h2>

                <div class="bg-[var(--green)] rounded-2xl p-6 text-center">
                    <p class="text-[var(--choco-brown)] font-medium">
                        Développement: Drinnhausen Lou & Schmitt Lola<br>
                        Projet SAE 501 - Université de Strasbourg<br>
                        <span class="text-sm italic">Février 2026</span>
                    </p>
                </div>
            </section>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="bg-[var(--choco-brown)] text-[var(--choco-beige)] text-center py-6 mt-12">
        <p class="text-sm">
            © 2026 L'Usine à Chocolat |
            <a href="{{ url('/mentions-legales') }}" class="hover:underline">Mentions Légales</a>
        </p>
    </footer>
</body>
</html>
