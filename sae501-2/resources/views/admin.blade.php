<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Administration - L'usine à chocolat</title>

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
            <a href="#" class="bg-[#F4E4A6] text-[#554840] px-6 py-2 rounded-full font-bold text-sm hover:bg-[#F0DDA0] transition">Admin</a>
            <button class="bg-[#F4E4A6] text-[#554840] p-2 rounded-full hover:bg-[#F0DDA0] transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </button>
        </nav>
    </header>

    <!-- MAIN CONTENT -->
    <main class="p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Titre -->
            <h2 class="text-4xl font-bold text-[#554840] mb-8 font-kavoon">Administration</h2>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Utilisateurs actifs -->
                <div class="bg-[#F4E4A6] rounded-3xl p-6 flex items-center gap-4 shadow-lg hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-[#554840] rounded-full flex items-center justify-center flex-shrink-0">
                        <img src="{{ asset('images/logos/usine_choco_26_blanc.svg') }}" alt="Utilisateurs" class="w-10 h-10" />
                    </div>
                    <div>
                        <p class="text-[#554840] font-bold text-lg">Utilisateurs</p>
                        <p class="text-[#554840] text-sm">actifs</p>
                        <p class="text-3xl font-bold text-[#554840] mt-2">{{ $stats['utilisateurs_actifs'] ?? 3 }}</p>
                    </div>
                </div>

                <!-- Rôles définis -->
                <div class="bg-[#8E5442] rounded-3xl p-6 flex items-center gap-4 shadow-lg hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center flex-shrink-0">
                        <img src="{{ asset('images/logos/usine_choco_26_blanc2.svg') }}" alt="Rôles" class="w-10 h-10" />
                    </div>
                    <div>
                        <p class="text-white font-bold text-lg">Rôles</p>
                        <p class="text-white text-sm">définis</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $stats['roles'] ?? 7 }}</p>
                    </div>
                </div>

                <!-- Postes de travail -->
                <div class="bg-[#F4E4A6] rounded-3xl p-6 flex items-center gap-4 shadow-lg hover:shadow-xl transition">
                    <div class="w-16 h-16 bg-[#554840] rounded-full flex items-center justify-center flex-shrink-0">
                        <img src="{{ asset('images/logos/usine_choco_26_blanc.svg') }}" alt="Postes" class="w-10 h-10" />
                    </div>
                    <div>
                        <p class="text-[#554840] font-bold text-lg">Postes</p>
                        <p class="text-[#554840] text-sm">de travail</p>
                        <p class="text-3xl font-bold text-[#554840] mt-2">{{ $stats['postes'] ?? 5 }}</p>
                    </div>
                </div>
            </div>

            <!-- Main Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Liste des étudiants -->
                <div class="bg-white rounded-3xl p-6 shadow-lg">
                    <h3 class="text-2xl font-bold text-[#554840] mb-6 font-kavoon">Liste des étudiants</h3>

                    <!-- Recherche et Bouton Ajouter -->
                    <div class="flex gap-3 mb-6">
                        <div class="flex-1 relative">
                            <input type="text" id="searchInput" placeholder="Rechercher un étudiant" class="w-full px-4 py-2 rounded-full bg-[#D4E4E0] text-[#554840] placeholder-[#554840]/50 focus:outline-none focus:ring-2 focus:ring-[#A8C9C3]" onkeyup="filterOperators()">
                            <svg class="w-5 h-5 absolute right-4 top-1/2 -translate-y-1/2 text-[#554840]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <button onclick="document.getElementById('addOperatorModal').style.display='block'; loadAvailableOperators();" class="bg-[#554840] text-white px-6 py-2 rounded-full font-bold hover:bg-[#3B2A21] transition flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Ajouter
                        </button>
                    </div>

                    <!-- Liste -->
                    <div class="space-y-3 max-h-96 overflow-y-auto" id="operatorsList">
                        @forelse($etudiants ?? [] as $etudiant)
                            <a href="{{ route('admin.show', $etudiant) }}" class="flex items-center justify-between p-4 bg-[#F5F5F5] rounded-2xl hover:bg-[#EFEFEF] transition cursor-pointer">
                                <div class="flex items-center gap-3 flex-1">
                                    <div class="w-12 h-12 bg-gradient-to-br from-[#D4A574] to-[#B8860B] rounded-full flex items-center justify-center text-white font-bold">
                                        {{ substr($etudiant->prenom ?? 'E', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-[#554840]">{{ $etudiant->prenom ?? 'Étudiant' }} {{ $etudiant->nom ?? '' }}</p>
                                        <p class="text-sm text-[#8B7355]">Rôle : {{ $etudiant->role->nom ?? 'Utilisateur' }}</p>
                                    </div>
                                </div>
                                <div class="text-[#554840] hover:text-[#8E5442] transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-8 text-[#8B7355]">
                                <p>Aucun étudiant pour le moment</p>
                                <button onclick="document.getElementById('addUserModal').style.display='block'" class="mt-4 bg-[#A8C9C3] text-[#554840] px-4 py-2 rounded-full text-sm font-bold hover:bg-[#90B5AF] transition">
                                    Ajouter un étudiant
                                </button>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Détail de l'étudiant / Formulaire -->
                <div class="bg-white rounded-3xl p-6 shadow-lg">
                    @if($selectedUser ?? false)
                        <h3 class="text-2xl font-bold text-[#554840] mb-6 font-kavoon">Détail de l'étudiant</h3>

                        <div class="bg-[#F4E4A6] rounded-2xl p-4 mb-6">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-16 h-16 bg-gradient-to-br from-[#D4A574] to-[#B8860B] rounded-full flex items-center justify-center text-white font-bold text-2xl">
                                    {{ substr($selectedUser->prenom ?? 'E', 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-lg font-bold text-[#554840]">{{ $selectedUser->prenom ?? '' }} {{ $selectedUser->nom ?? '' }}</h4>
                                    <p class="text-sm text-[#8B7355]">{{ $selectedUser->email ?? '' }}</p>
                                </div>
                                <a href="{{ route('admin.edit', $selectedUser) }}" class="bg-[#8E5442] text-white px-6 py-2 rounded-full font-bold hover:bg-[#6B4535] transition">
                                    Modifier
                                </a>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="text-sm font-bold text-[#554840] block mb-2">Mail :</label>
                                <p class="text-[#554840] underline">{{ $selectedUser->email ?? '' }}</p>
                            </div>

                            <div>
                                <label class="text-sm font-bold text-[#554840] block mb-2">Rôle :</label>
                                <div class="flex gap-2 flex-wrap">
                                    <span class="bg-[#8E5442] text-white px-4 py-2 rounded-full font-bold">
                                        {{ $selectedUser->role->nom ?? 'Utilisateur' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="h-full flex items-center justify-center">
                            <div class="text-center">
                                <p class="text-[#8B7355] text-lg mb-4">Sélectionnez un étudiant pour voir ses détails</p>
                                <button onclick="document.getElementById('addUserModal').style.display='block'" class="bg-[#A8C9C3] text-[#554840] px-6 py-2 rounded-full font-bold hover:bg-[#90B5AF] transition">
                                    Ajouter un nouvel étudiant
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Ajouter Opérateur -->
    <div id="addOperatorModal" style="display:none" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-3xl p-8 max-w-3xl w-full mx-4 shadow-2xl">
            <h3 class="text-2xl font-bold text-[#554840] mb-6 font-kavoon">Ajouter un opérateur</h3>

            <!-- Recherche dans le modal -->
            <div class="flex-1 relative mb-6">
                <input type="text" id="operatorSearch" placeholder="Rechercher par nom..." class="w-full px-4 py-2 rounded-full bg-[#D4E4E0] text-[#554840] placeholder-[#554840]/50 focus:outline-none focus:ring-2 focus:ring-[#A8C9C3]" onkeyup="filterAvailableOperators()">
                <svg class="w-5 h-5 absolute right-4 top-1/2 -translate-y-1/2 text-[#554840]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <!-- Liste des opérateurs disponibles -->
            <div id="availableOperatorsList" class="space-y-3 max-h-96 overflow-y-auto mb-6">
                <div class="text-center py-8 text-[#8B7355]">
                    <p>Chargement des opérateurs disponibles...</p>
                </div>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" onclick="document.getElementById('addOperatorModal').style.display='none'" class="flex-1 bg-[#D4E4E0] text-[#554840] px-6 py-2 rounded-full font-bold hover:bg-[#C0D8D3] transition">
                    Fermer
                </button>
            </div>
        </div>
    </div>

    <script>
        // Données des opérateurs stockées globalement
        let allOperators = {!! json_encode($etudiants) !!};

        // Initialiser la liste au chargement
        document.addEventListener('DOMContentLoaded', function() {
            renderOperators(allOperators);
        });

        // Filtrer les opérateurs en temps réel
        function filterOperators() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();

            const filtered = allOperators.filter(op => {
                const nom = (op.nom || '').toLowerCase();
                const prenom = (op.prenom || '').toLowerCase();
                const email = (op.email || '').toLowerCase();

                return nom.includes(searchTerm) || prenom.includes(searchTerm) || email.includes(searchTerm);
            });

            renderOperators(filtered);
        }

        // Afficher les opérateurs dans la liste
        function renderOperators(operators) {
            const listDiv = document.getElementById('operatorsList');

            if (operators.length === 0) {
                listDiv.innerHTML = '<div class="text-center py-8 text-[#8B7355]"><p>Aucun opérateur trouvé</p></div>';
                return;
            }

            listDiv.innerHTML = operators.map(op => `
                <a href="/admin/users/${op.id}" class="flex items-center justify-between p-4 bg-[#F5F5F5] rounded-2xl hover:bg-[#EFEFEF] transition cursor-pointer">
                    <div class="flex items-center gap-3 flex-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-[#D4A574] to-[#B8860B] rounded-full flex items-center justify-center text-white font-bold">
                            ${op.prenom.charAt(0)}
                        </div>
                        <div>
                            <p class="font-bold text-[#554840]">${op.prenom} ${op.nom}</p>
                            <p class="text-sm text-[#8B7355]">Rôle : ${op.role?.nom || 'Utilisateur'}</p>
                        </div>
                    </div>
                    <div class="text-[#554840] hover:text-[#8E5442] transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </a>
            `).join('');
        }

        // Fermer le modal en cliquant en dehors
        document.getElementById('addOperatorModal').addEventListener('click', function(event) {
            if (event.target === this) {
                this.style.display = 'none';
            }
        });

        // Données des opérateurs disponibles
        let availableOperatorsData = [];

        // Charger les opérateurs disponibles au départ
        async function loadAvailableOperators() {
            try {
                const response = await fetch(`{{ route('admin.availableOperators') }}`);
                availableOperatorsData = await response.json();
                filterAvailableOperators();
            } catch (error) {
                console.error('Erreur:', error);
                document.getElementById('availableOperatorsList').innerHTML = '<div class="text-center py-8 text-red-500"><p>Erreur lors du chargement</p></div>';
            }
        }

        // Filtrer les opérateurs en temps réel
        function filterAvailableOperators() {
            const searchTerm = document.getElementById('operatorSearch')?.value.toLowerCase() || '';

            // Récupérer les IDs des opérateurs déjà assignés
            const assignedIds = allOperators.map(op => op.id);

            const filtered = availableOperatorsData.filter(op => {
                // Exclure les opérateurs déjà assignés
                if (assignedIds.includes(op.id)) {
                    return false;
                }

                const nom = (op.nom || '').toLowerCase();
                const prenom = (op.prenom || '').toLowerCase();
                const email = (op.email || '').toLowerCase();

                return nom.includes(searchTerm) || prenom.includes(searchTerm) || email.includes(searchTerm);
            });

            renderAvailableOperators(filtered);
        }

        // Afficher les opérateurs disponibles
        function renderAvailableOperators(operators) {
            const listDiv = document.getElementById('availableOperatorsList');

            if (operators.length === 0) {
                listDiv.innerHTML = '<div class="text-center py-8 text-[#8B7355]"><p>Aucun opérateur disponible</p></div>';
                return;
            }

            listDiv.innerHTML = operators.map(op => `
                <div class="flex items-center justify-between p-4 bg-[#F5F5F5] rounded-2xl hover:bg-[#EFEFEF] transition cursor-pointer">
                    <div class="flex items-center gap-3 flex-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-[#D4A574] to-[#B8860B] rounded-full flex items-center justify-center text-white font-bold">
                            ${op.prenom.charAt(0)}
                        </div>
                        <div>
                            <p class="font-bold text-[#554840]">${op.prenom} ${op.nom}</p>
                            <p class="text-sm text-[#8B7355]">${op.email}</p>
                        </div>
                    </div>
                    <button type="button" class="bg-[#554840] text-white px-4 py-2 rounded-full font-bold hover:bg-[#3B2A21] transition" onclick="addOperatorToTeam(${op.id})">
                        Ajouter
                    </button>
                </div>
            `).join('');
        }

        // Ajouter un opérateur à l'équipe
        async function addOperatorToTeam(userId) {
            try {
                const response = await fetch(`{{ route('admin.addOperator', 'USER_ID') }}`.replace('USER_ID', userId), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    alert(data.message);
                    loadAvailableOperators();
                    // Reload page to update the list
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                } else {
                    alert(data.error || 'Erreur lors de l\'ajout');
                }
            } catch (error) {
                console.error('Erreur:', error);
                alert('Erreur lors de l\'ajout de l\'opérateur');
            }
        }
    </script>
</body>
</html>
