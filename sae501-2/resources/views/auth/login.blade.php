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
    <main class="flex-1 flex items-center justify-center relative overflow-hidden px-4 bg-[url('/images/autre/fond_auth.svg')] bg-cover bg-center bg-no-repeat">
        <!-- Card Connexion -->
        <div class="relative z-10 w-full max-w-md bg-[#8E5442] rounded-[4rem] p-10 shadow-xl border-4 border-[#ABDDCC]/100">
            <h1 class="text-center text-3xl font-medium text-[#FCE097] mb-8" style="font-family: 'Kavoon', cursive;">Connexion</h1>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="text-[#f6e3a1]" />
                    <x-text-input id="email"
                        class="block mt-1 w-full rounded-full bg-[#5a463a] text-white"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" class="text-[#f6e3a1]" />
                    <x-text-input id="password"
                        class="block mt-1 w-full rounded-full bg-[#5a463a] text-white"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center text-sm text-[#f6e3a1]">
                        <input id="remember_me"
                            type="checkbox"
                            class="rounded border-[#f6e3a1] text-[#5a463a] focus:ring-[#f6e3a1]"
                            name="remember">
                        <span class="ms-2">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="text-center mt-2">
                    <a href="{{ route('register') }}"
                    class="text-sm text-[#f6e3a1] underline hover:opacity-80">
                        Créer un compte
                    </a>
                </div>

                <div class="flex items-center justify-between mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-[#f6e3a1] hover:opacity-80"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button class="ms-3">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-[#5a463a] py-6 text-center text-xs text-[#e6d5b8]">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex items-center justify-center space-x-16">
                <img src="/images/logos/usine_choco_26_blanc2.svg" alt="icône logo"
                    class="w-auto h-10 object-contain opacity-80 hover:opacity-100 transition-opacity">

                <div class="text-center space-y-2 min-w-[320px]">
                    <p class="font-semibold text-md text-[#e6d5b8]">
                        Copyright 2026 DRINHAUSEN Lou - SCHMITT Lola
                    </p>
                    <div class="flex flex-wrap items-center justify-center gap-6 text-md">
                        <a href="#" class="underline hover:text-[#e6d5b8] hover:underline-offset-2 transition-all">
                            Mentions légales
                        </a>
                        <a href="#" class="underline hover:text-[#e6d5b8] hover:underline-offset-2 transition-all">
                            Crédits
                        </a>
                    </div>
                </div>

                <img src="/images/logos/haguenau.png" alt="icône haguenau"
                    class="w-auto h-10 object-contain opacity-80 hover:opacity-100 transition-opacity">
            </div>
        </div>
    </footer>

</body>
</html>
