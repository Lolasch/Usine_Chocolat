<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un utilisateur - L'usine à chocolat</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arimo:wght@400;500;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        html, body {
            background-color: #FFF9EF;
            margin: 0;
            padding: 0;
            font-family: 'Arimo', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .font-kavoon {
            font-family: 'Kavoon', cursive;
        }
    </style>
</head>
<body class="bg-[#A8C9C3] min-h-screen">
    <!-- HEADER -->
    <header class="bg-[#554840] py-4 px-6 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <img src="{{ asset('images/logos/usine_choco_26_blanc2.svg') }}" alt="Usine à Chocolat" class="h-12" />
            <h1 class="text-white text-lg font-bold font-kavoon">L'usine à chocolat</h1>
        </div>

        <nav class="flex items-center gap-3">
            <a href="#" class="bg-[#F4E4A6] text-[#554840] px-6 py-2 rounded-full font-bold text-sm hover:bg-[#F0DDA0] transition">Frigo</a>
            <a href="#" class="bg-[#F4E4A6] text-[#554840] px-6 py-2 rounded-full font-bold text-sm hover:bg-[#F0DDA0] transition">Statistiques</a>
            <a href="{{ route('admin.index') }}" class="bg-[#F4E4A6] text-[#554840] px-6 py-2 rounded-full font-bold text-sm hover:bg-[#F0DDA0] transition">Admin</a>
            <button class="bg-[#F4E4A6] text-[#554840] p-2 rounded-full hover:bg-[#F0DDA0] transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </button>
        </nav>
    </header>

    <!-- MAIN CONTENT -->
    <main class="p-6">
        <div class="max-w-2xl mx-auto">
            <!-- Titre -->
            <h2 class="text-4xl font-bold text-[#554840] mb-8 font-kavoon">Modifier l'utilisateur</h2>

            <!-- Formulaire -->
            <div class="bg-white rounded-3xl p-8 shadow-lg">
                <div class="bg-[#F4E4A6] rounded-2xl p-4 mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-[#D4A574] to-[#B8860B] rounded-full flex items-center justify-center text-white font-bold text-2xl">
                            {{ substr($user->prenom ?? 'E', 0, 1) }}
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-[#554840]">{{ $user->prenom ?? '' }} {{ $user->nom ?? '' }}</h4>
                            <p class="text-sm text-[#8B7355]">{{ $user->email ?? '' }}</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.update', $user) }}" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-bold text-[#554840] block mb-2">Prénom *</label>
                            <input type="text" name="prenom" required value="{{ $user->prenom }}" class="w-full px-4 py-2 rounded-lg border-2 border-[#D4E4E0] focus:border-[#A8C9C3] focus:outline-none">
                            @error('prenom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="text-sm font-bold text-[#554840] block mb-2">Nom *</label>
                            <input type="text" name="nom" required value="{{ $user->nom }}" class="w-full px-4 py-2 rounded-lg border-2 border-[#D4E4E0] focus:border-[#A8C9C3] focus:outline-none">
                            @error('nom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-bold text-[#554840] block mb-2">Email *</label>
                        <input type="email" name="email" required value="{{ $user->email }}" class="w-full px-4 py-2 rounded-lg border-2 border-[#D4E4E0] focus:border-[#A8C9C3] focus:outline-none">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="border-t-2 border-[#D4E4E0] pt-6">
                        <p class="text-sm font-bold text-[#554840] mb-4">Laisser vide pour garder le mot de passe actuel</p>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-bold text-[#554840] block mb-2">Nouveau mot de passe</label>
                                <input type="password" name="password" class="w-full px-4 py-2 rounded-lg border-2 border-[#D4E4E0] focus:border-[#A8C9C3] focus:outline-none">
                                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="text-sm font-bold text-[#554840] block mb-2">Confirmer</label>
                                <input type="password" name="password_confirmation" class="w-full px-4 py-2 rounded-lg border-2 border-[#D4E4E0] focus:border-[#A8C9C3] focus:outline-none">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-bold text-[#554840] block mb-2">Rôle *</label>
                        <select name="role_id" required class="w-full px-4 py-2 rounded-lg border-2 border-[#D4E4E0] focus:border-[#A8C9C3] focus:outline-none">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->role_id === $role->id ? 'selected' : '' }}>{{ $role->nom }}</option>
                            @endforeach
                        </select>
                        @error('role_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="actif" id="actif" {{ $user->actif ? 'checked' : '' }} class="w-4 h-4 rounded">
                        <label for="actif" class="text-sm font-bold text-[#554840]">Utilisateur actif</label>
                    </div>

                    <div class="flex gap-3 pt-6 border-t-2 border-[#D4E4E0]">
                        <button type="submit" class="flex-1 bg-[#554840] text-white px-6 py-3 rounded-full font-bold hover:bg-[#3B2A21] transition">
                            Sauvegarder les modifications
                        </button>
                        <a href="{{ route('admin.show', $user) }}" class="flex-1 bg-[#D4E4E0] text-[#554840] px-6 py-3 rounded-full font-bold hover:bg-[#C0D8D3] transition text-center">
                            Annuler
                        </a>
                    </div>

                    <!-- Bouton Supprimer -->
                    <form method="POST" action="{{ route('admin.destroy', $user) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');" class="pt-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 text-white px-6 py-2 rounded-full font-bold hover:bg-red-700 transition">
                            Supprimer cet utilisateur
                        </button>
                    </form>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
