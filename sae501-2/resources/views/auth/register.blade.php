<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion – Chocolat</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- GOOGLE FONT KAVOON -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet">
</head>

<body class="min-h-screen flex flex-col bg-[#FFF9EF]">

    <!-- Header -->
    <header class="bg-[#5a463a] py-6 flex justify-center">
        <img src="/images/logos/usine_choco_26_blanc2.svg"
            alt="L'Usine Chocolat"
            class="h-20 w-auto">
    </header>

    <!-- Main -->
    <main class="flex-1 flex items-center justify-center relative overflow-hidden px-4
                 bg-[url('/images/autre/fond_auth.svg')] bg-cover bg-center bg-no-repeat">

        <!-- Card Connexion -->
        <div class="relative z-10 w-full max-w-md bg-[#8E5442] rounded-[4rem] p-10 shadow-xl border-4 border-[#ABDDCC]">
            <h1 class="text-center text-3xl font-medium text-[#FCE097] mb-8"
                style="font-family: 'Kavoon', cursive;">
                Inscription
            </h1>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Nom -->
                <div>
                    <x-input-label for="nom" :value="__('Nom')" class="text-[#f6e3a1]" />
                    <x-text-input id="nom"
                        class="block mt-1 w-full rounded-full bg-[#5a463a] text-white"
                        type="text"
                        name="nom"
                        :value="old('nom')"
                        required
                        autofocus
                        autocomplete="name" />
                    <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                </div>

                <!-- Prénom -->
                <div>
                    <x-input-label for="prenom" :value="__('Prénom')" class="text-[#f6e3a1]" />
                    <x-text-input id="prenom"
                        class="block mt-1 w-full rounded-full bg-[#5a463a] text-white"
                        type="text"
                        name="prenom"
                        :value="old('prenom')"
                        required
                        autocomplete="given-name" />
                    <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-[#f6e3a1]" />
                    <x-text-input id="email"
                        class="block mt-1 w-full rounded-full bg-[#5a463a] text-white"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-[#f6e3a1]" />
                    <x-text-input id="password"
                        class="block mt-1 w-full rounded-full bg-[#5a463a] text-white"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-[#f6e3a1]" />
                    <x-text-input id="password_confirmation"
                        class="block mt-1 w-full rounded-full bg-[#5a463a] text-white"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mt-6">
                    <a class="underline text-sm text-[#f6e3a1] hover:opacity-80"
                        href="{{ route('login') }}">
                        {{ __('Déjà inscrit?') }}
                    </a>

                    <x-primary-button class="ms-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-[#5a463a] py-6 text-center text-xs text-[#e6d5b8]">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex items-center justify-center space-x-16">
                <img src="/images/logos/usine_choco_26_blanc2.svg"
                    alt="logo usine"
                    class="h-12 w-auto opacity-80 hover:opacity-100 transition-opacity">

                <div class="text-center space-y-2 min-w-[320px]">
                    <p class="font-semibold text-md">
                        Copyright 2025 DRINNHAUSEN Lou - SCHMITT Lola
                    </p>
                    <div class="flex justify-center gap-6 text-md">
                        <a href="#" class="underline hover:underline-offset-2">Mentions légales</a>
                        <a href="#" class="underline hover:underline-offset-2">Crédits</a>
                    </div>
                </div>

                <img src="/images/logos/haguenau.png"
                    alt="logo haguenau"
                    class="h-12 w-auto opacity-80 hover:opacity-100 transition-opacity">
            </div>
        </div>
    </footer>

</body>
</html>
