<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accès interdit - L'Usine Chocolat</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- GOOGLE FONT KAVOON -->
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
            --green: #ABDDCC;
        }
        body {
            background: var(--green);
            min-height: 100vh;
            padding: 2vh 1rem;
            margin: 0;
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen flex justify-center items-start">
    <div class="max-w-2xl w-full">
        <!-- Card principale -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 sm:p-12 text-center">
            <!-- Code d'erreur -->
            <div class="mb-6">
                <h1 class="text-8xl sm:text-9xl font-bold text-[var(--choco)] font-kavoon">403</h1>
            </div>

            <!-- Message -->
            <div class="mb-8 flex flex-col items-center">
                <h2 class="text-2xl sm:text-3xl font-bold text-[var(--choco-brown)] mb-4 font-kavoon text-center">Accès Interdit</h2>
                <p class="text-base sm:text-lg text-[var(--choco-brown)]/70 max-w-md text-center">
                    {{ $exception->getMessage() ?: "Vous n'avez pas accès à cette page. Seul un administrateur ou superviseur peut accéder à cette section." }}
                </p>
            </div>

            <!-- Bouton retour -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ url('/liste') }}" class="bg-[var(--choco)] text-white px-8 py-3 rounded-full font-bold hover:bg-[var(--choco-brown)] transition inline-block">
                    Retour à l'accueil
                </a>
                <button onclick="history.back()" class="bg-[var(--green)] text-[var(--choco-brown)] px-8 py-3 rounded-full font-bold hover:bg-[var(--green)]/80 transition">
                    Page précédente
                </button>
            </div>
        </div>

        <!-- Logo -->
        <div class="text-center mt-8">
            <img src="/images/logos/usine_choco_26_couleur.svg" alt="L'Usine Chocolat" class="h-16 mx-auto opacity-70">
        </div>
    </div>
</body>
</html>
