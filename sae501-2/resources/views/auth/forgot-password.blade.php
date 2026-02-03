<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Réinitialisation du mot de passe - Usine Chocolat 2026">
    <title>Mot de passe oublié – L'Usine Chocolat 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- GOOGLE FONT KAVOON -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet">

    <!-- FAVICON -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/autre/seul_blanc.svg') }}">

</head>
<body class="min-h-screen flex flex-col bg-[#FFF9EF]">

    <!-- Header -->
    <header class="bg-[#5a463a] py-6 flex justify-center" role="banner">
        <img src="/images/logos/usine_choco_26_blanc2.svg"
            alt="Logo L'Usine Chocolat 2026"
            class="h-20 w-auto">
    </header>

    <!-- Main -->
    <main class="flex-1 flex items-center justify-center relative overflow-hidden px-4 py-8 bg-[url('/images/autre/fond_auth.svg')] bg-cover bg-center bg-no-repeat" role="main">
        <!-- Card Mot de passe oublié -->
        <div class="relative z-10 w-full max-w-md bg-[#8E5442] rounded-[4rem] p-10 shadow-xl border-4 border-[#ABDDCC]/100" role="form" aria-labelledby="forgot-password-title">
            <h1 id="forgot-password-title" class="text-center text-3xl font-medium text-[#FCE097] mb-6" style="font-family: 'Kavoon', cursive;">Mot de passe oublié ?</h1>

            <p class="text-center text-sm text-[#FCE097]/90 mb-8">
                Pas de problème. Indiquez votre adresse e-mail et nous vous enverrons un lien pour réinitialiser votre mot de passe.
            </p>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-6 p-4 rounded-2xl bg-[#FCE097] text-[#5a463a] text-sm text-center" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6" aria-label="Formulaire de réinitialisation du mot de passe">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xl font-medium text-[#FCE097] mb-2" style="font-family: 'Kavoon', cursive;">Mail</label>
                    <input id="email"
                        class="block w-full px-5 py-3 rounded-full bg-[#5a463a] text-white placeholder-gray-400 border-none focus:ring-2 focus:ring-[#FCE097] text-sm"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Exemple : lola@gmail.com"
                        required
                        aria-required="true"
                        aria-describedby="email-error"
                        autofocus
                        autocomplete="email" />
                    @error('email')
                        <p class="mt-2 text-sm text-red-300" id="email-error" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lien retour connexion -->
                <div class="text-center">
                    <a href="{{ route('login') }}"
                       class="text-sm text-[#FCE097] hover:text-[#f6d97f] underline transition-colors focus:outline-none focus:ring-2 focus:ring-[#FCE097] rounded"
                       aria-label="Retour à la page de connexion">
                        Retour à la connexion
                    </a>
                </div>

                <!-- Bouton d'envoi -->
                <div class="flex justify-center mt-8">
                    <button type="submit" class="bg-[#FCE097] hover:bg-[#f6d97f] rounded-t-[2rem] rounded-b-3xl p-4 transition-all transform hover:scale-110 focus:outline-none focus:ring-4 focus:ring-[#FCE097]/50" aria-label="Envoyer le lien de réinitialisation">
                        <svg class="w-8 h-8 text-[#5a463a]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-[#5a463a] py-6 text-center text-xs text-[#e6d5b8]" role="contentinfo">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex items-center justify-center space-x-16">
                <img src="/images/logos/usine_choco_26_blanc2.svg" alt="Logo Usine Chocolat"
                    class="w-auto h-10 object-contain opacity-80 hover:opacity-100 transition-opacity">

                <div class="text-center space-y-2 min-w-[320px]">
                    <p class="font-semibold text-md text-[#e6d5b8]">
                        Copyright 2025 DRINNHAUSEN Lou - SCHMITT Lola
                    </p>
                    <nav class="flex flex-wrap items-center justify-center gap-6 text-md" aria-label="Liens légaux">
                        <a href="{{ route('mentions-legales') }}" class="underline hover:text-[#e6d5b8] hover:underline-offset-2 transition-all focus:outline-none focus:ring-2 focus:ring-[#e6d5b8] rounded" aria-label="Consulter les mentions légales">
                            Mentions Légales
                        </a>
                    </nav>
                </div>

                <img src="/images/logos/haguenau.png" alt="Logo Haguenau"
                    class="w-auto h-10 object-contain opacity-80 hover:opacity-100 transition-opacity">
            </div>
        </div>
    </footer>

</body>
</html>
