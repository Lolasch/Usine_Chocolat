<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Page d'inscription à l'application Usine Chocolat 2026">
    <title>Inscription – Chocolat</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- GOOGLE FONT KAVOON -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet">
</head>

<body class="min-h-screen flex flex-col bg-[#FFF9EF]">

    <!-- Header -->
    <header class="bg-[#5a463a] py-6 flex justify-center" role="banner">
        <img src="/images/logos/usine_choco_26_blanc2.svg"
             alt="Logo L'Usine Chocolat 2026"
             class="h-20 w-auto">
    </header>

    <!-- Main -->
    <main class="flex-1 flex items-center justify-center relative overflow-hidden px-4 py-8
                 bg-[url('/images/autre/fond_auth.svg')] bg-cover bg-center bg-no-repeat" role="main">

        <!-- Card Inscription -->
        <div class="relative z-10 w-full max-w-md bg-[#8E5442] rounded-[4rem] p-10 shadow-xl border-4 border-[#ABDDCC]" role="form" aria-labelledby="register-title">
            <h1 id="register-title" class="text-center text-3xl font-medium text-[#FCE097] mb-8"
                style="font-family: 'Kavoon', cursive;">
                Inscription
            </h1>

            <form method="POST" action="{{ route('register') }}" class="space-y-6" aria-label="Formulaire d'inscription">
                @csrf

                <!-- Nom -->
                <div>
                    <label for="nom" class="block text-xl font-medium text-[#FCE097] mb-2" style="font-family: 'Kavoon', cursive;">Nom</label>
                    <input id="nom"
                        class="block w-full px-5 py-3 rounded-full bg-[#5a463a] text-white placeholder-gray-400 border-none focus:ring-2 focus:ring-[#FCE097] text-sm"
                        type="text"
                        name="nom"
                        value="{{ old('nom') }}"
                        placeholder="Exemple : SCHMITT"
                        required
                        aria-required="true"
                        aria-describedby="nom-error"
                        autofocus
                        autocomplete="family-name" />
                    <x-input-error :messages="$errors->get('nom')" class="mt-2 text-red-300" id="nom-error" role="alert" />
                </div>

                <!-- Prénom -->
                <div>
                    <label for="prenom" class="block text-xl font-medium text-[#FCE097] mb-2" style="font-family: 'Kavoon', cursive;">Prénom</label>
                    <input id="prenom"
                        class="block w-full px-5 py-3 rounded-full bg-[#5a463a] text-white placeholder-gray-400 border-none focus:ring-2 focus:ring-[#FCE097] text-sm"
                        type="text"
                        name="prenom"
                        value="{{ old('prenom') }}"
                        placeholder="Exemple : Lola"
                        required
                        aria-required="true"
                        aria-describedby="prenom-error"
                        autocomplete="given-name" />
                    <x-input-error :messages="$errors->get('prenom')" class="mt-2 text-red-300" id="prenom-error" role="alert" />
                </div>

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
                        autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300" id="email-error" role="alert" />
                </div>

                <!-- Rôle -->
                <div>
                    <label for="role_id" class="block text-xl font-medium text-[#FCE097] mb-2" style="font-family: 'Kavoon', cursive;">Rôle</label>
                    <select id="role_id"
                        name="role_id"
                        class="block w-full px-5 py-3 rounded-full bg-[#5a463a] text-white border-none focus:ring-2 focus:ring-[#FCE097] text-sm"
                        required
                        aria-required="true"
                        aria-describedby="role-error">
                        <option value="">-- Choisir un rôle --</option>
                        @foreach($roles ?? [] as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->nom }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('role_id')" class="mt-2 text-red-300" id="role-error" role="alert" />
                </div>

                <!-- Mot de passe -->
                <div>
                    <label for="password" class="block text-xl font-medium text-[#FCE097] mb-2" style="font-family: 'Kavoon', cursive;">Mot de passe</label>
                    <input id="password"
                        class="block w-full px-5 py-3 rounded-full bg-[#5a463a] text-white placeholder-gray-400 border-none focus:ring-2 focus:ring-[#FCE097] text-sm"
                        type="password"
                        name="password"
                        placeholder="Min. 12 caractères"
                        minlength="12"
                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&#]).{12,}"
                        title="Le mot de passe doit contenir au moins 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial (@$!%*?&#)"
                        required
                        aria-required="true"
                        aria-describedby="password-error password-help"
                        autocomplete="new-password" />
                    <p id="password-help" class="mt-1 text-xs text-[#FCE097]/80">
                        12 caractères min. : majuscule, minuscule, chiffre et caractère spécial (@$!%*?&#)
                    </p>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300" id="password-error" role="alert" />
                </div>

                <!-- Confirmer le mot de passe -->
                <div>
                    <label for="password_confirmation" class="block text-xl font-medium text-[#FCE097] mb-2" style="font-family: 'Kavoon', cursive;">Confirmer le mot de passe</label>
                    <input id="password_confirmation"
                        class="block w-full px-5 py-3 rounded-full bg-[#5a463a] text-white placeholder-gray-400 border-none focus:ring-2 focus:ring-[#FCE097] text-sm"
                        type="password"
                        name="password_confirmation"
                        placeholder="Confirmer le mot de passe"
                        minlength="12"
                        required
                        aria-required="true"
                        aria-describedby="password-confirmation-error"
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-300" id="password-confirmation-error" role="alert" />
                </div>

                <!-- Lien connexion et bouton inscription -->
                <div class="flex flex-col space-y-4 mt-8">
                    <div class="text-center">
                        <a href="{{ route('login') }}"
                           class="text-sm text-[#FCE097] hover:text-[#f6d97f] underline transition-colors focus:outline-none focus:ring-2 focus:ring-[#FCE097] rounded"
                           aria-label="Déjà inscrit ? Se connecter">
                            Déjà inscrit ?
                        </a>
                    </div>

                    <div class="flex justify-center">
                        <button type="submit" class="bg-[#FCE097] hover:bg-[#f6d97f] rounded-full p-4 transition-all transform hover:scale-110 focus:outline-none focus:ring-4 focus:ring-[#FCE097]/50" aria-label="S'inscrire">
                            <svg class="w-8 h-8 text-[#5a463a]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-[#5a463a] py-6 text-center text-xs text-[#e6d5b8]" role="contentinfo">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex items-center justify-center space-x-16">
                <img src="/images/logos/usine_choco_26_blanc2.svg"
                     alt="Logo Usine Chocolat"
                     class="h-12 w-auto opacity-80 hover:opacity-100 transition-opacity">

                <div class="text-center space-y-2 min-w-[320px]">
                    <p class="font-semibold text-md">
                        Copyright 2025 DRINNHAUSEN Lou - SCHMITT Lola
                    </p>
                    <nav class="flex justify-center gap-6 text-md" aria-label="Liens légaux">
                        <a href="#" class="underline hover:text-[#e6d5b8] hover:underline-offset-2 transition-all focus:outline-none focus:ring-2 focus:ring-[#e6d5b8] rounded" aria-label="Consulter les mentions légales">Mentions Légales</a>
                        <a href="#" class="underline hover:text-[#e6d5b8] hover:underline-offset-2 transition-all focus:outline-none focus:ring-2 focus:ring-[#e6d5b8] rounded" aria-label="Consulter les crédits">Crédits</a>
                    </nav>
                </div>

                <img src="/images/logos/haguenau.png"
                     alt="Logo Haguenau"
                     class="h-12 w-auto opacity-80 hover:opacity-100 transition-opacity">
            </div>
        </div>
    </footer>

</body>
</html>
