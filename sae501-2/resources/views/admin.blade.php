@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <h2 class="text-4xl font-bold text-[#554840] mb-8 font-kavoon">Administration</h2>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
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

            <div class="flex gap-3 mb-6">
                <div class="flex-1 relative">
                    <input type="text" id="searchInput" placeholder="Rechercher un étudiant" class="w-full px-4 py-2 rounded-full bg-[#D4E4E0] text-[#554840] placeholder-[#554840]/50 focus:outline-none focus:ring-2 focus:ring-[#A8C9C3]">
                    <svg class="w-5 h-5 absolute right-4 top-1/2 -translate-y-1/2 text-[#554840]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <button type="button" id="btnAddOperator" class="bg-[#554840] text-white px-6 py-2 rounded-full font-bold hover:bg-[#3B2A21] transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Ajouter
                </button>
            </div>

            <div class="space-y-3 max-h-96 overflow-y-auto" id="operatorsList">
                @forelse($etudiants ?? [] as $etudiant)
                    <div onclick="loadUserDetails({{ $etudiant->id }})" class="flex items-center justify-between p-4 bg-[#F5F5F5] rounded-2xl hover:bg-[#EFEFEF] transition cursor-pointer operator-item" data-user-id="{{ $etudiant->id }}">
                        <div class="flex items-center gap-3 flex-1">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#D4A574] to-[#B8860B] rounded-full flex items-center justify-center text-white font-bold">
                                {{ strtolower(substr($etudiant->prenom ?? 'e', 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-[#554840]">{{ $etudiant->prenom ?? 'Étudiant' }} {{ $etudiant->nom ?? '' }}</p>
                                <p class="text-sm text-[#8B7355]">Rôle : {{ $etudiant->role_equipe->nom ?? $etudiant->role->nom ?? 'operateur' }}</p>
                            </div>
                        </div>
                        <div class="text-[#554840] hover:text-[#8E5442] transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-[#8B7355]">
                        <p>Aucun étudiant pour le moment</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Détail de l'étudiant -->
        <div class="bg-white rounded-3xl p-6 shadow-lg" id="userDetailsContainer">
            <div id="userDetailsContent">
                @if($selectedUser ?? false)
                    <h3 class="text-2xl font-bold text-[#554840] mb-6 font-kavoon">Détail de l'étudiant</h3>

                    <div class="bg-[#F4E4A6] rounded-2xl p-4 mb-6">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-[#D4A574] to-[#B8860B] rounded-full flex items-center justify-center text-white font-bold text-2xl">
                                {{ strtolower(substr($selectedUser->prenom ?? 'e', 0, 1)) }}
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
                            <a href="mailto:{{ $selectedUser->email ?? '' }}" class="text-[#554840] underline">{{ $selectedUser->email ?? '' }}</a>
                        </div>

                        <div>
                            <label class="text-sm font-bold text-[#554840] block mb-2">Rôle :</label>
                            <div class="flex gap-2 flex-wrap">
                                @php
                                    $isOperateur = strtolower($selectedUser->role->nom ?? '') === 'operateur';
                                    $isSuperviseur = strtolower($selectedUser->role->nom ?? '') === 'superviseur';
                                @endphp
                                <span class="px-4 py-2 rounded-full font-bold {{ $isOperateur ? 'bg-[#8E5442] text-white' : 'bg-[#F4E4A6] text-[#554840]' }}">
                                    Opérateur
                                </span>
                                <span class="px-4 py-2 rounded-full font-bold {{ $isSuperviseur ? 'bg-[#8E5442] text-white' : 'bg-[#F4E4A6] text-[#554840]' }}">
                                    Superviseur
                                </span>
                            </div>
                        </div>

                        @if($selectedUser->usersEquipe)
                            <div>
                                <label class="text-sm font-bold text-[#554840] block mb-2">Poste :</label>
                                <div class="flex items-center gap-2">
                                    <span class="text-[#554840]">{{ $selectedUser->usersEquipe->poste->nom ?? 'Aucun poste' }}</span>
                                    <svg class="w-4 h-4 text-[#554840]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="h-full flex items-center justify-center">
                        <div class="text-center">
                            <p class="text-[#8B7355] text-lg mb-4">Sélectionnez un étudiant pour voir ses détails</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Modal Ajouter Opérateur --}}
<div id="addOperatorModal" style="display:none" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-8 max-w-3xl w-full mx-4 shadow-2xl max-h-[90vh] overflow-y-auto">
        <h3 class="text-2xl font-bold text-[#554840] mb-6 font-kavoon">Ajouter un opérateur</h3>

        <div class="relative mb-6">
            <input type="text" id="operatorSearch" placeholder="Rechercher par nom..." class="w-full px-4 py-2 rounded-full bg-[#D4E4E0] text-[#554840] placeholder-[#554840]/50 focus:outline-none focus:ring-2 focus:ring-[#A8C9C3]">
            <svg class="w-5 h-5 absolute right-4 top-1/2 -translate-y-1/2 text-[#554840]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        <div id="availableOperatorsList" class="space-y-3 max-h-96 overflow-y-auto mb-6">
            <div class="text-center py-8 text-[#8B7355]">
                <p>Chargement des opérateurs disponibles...</p>
            </div>
        </div>

        <div class="flex gap-3 pt-4">
            <button type="button" id="btnCloseModal" class="flex-1 bg-[#D4E4E0] text-[#554840] px-6 py-2 rounded-full font-bold hover:bg-[#C0D8D3] transition">
                Fermer
            </button>
        </div>
    </div>
</div>

{{-- Modal de confirmation personnalisée --}}
<div id="confirmModal" style="display:none" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-8 max-w-md w-full mx-4 shadow-2xl">
        <h3 class="text-2xl font-bold text-[#554840] mb-4 font-kavoon" id="confirmTitle">Confirmation</h3>
        <p class="text-[#554840] mb-6" id="confirmMessage"></p>

        <div class="flex gap-3">
            <button type="button" onclick="confirmModalResolve(true)" class="flex-1 bg-[#8E5442] text-white px-6 py-3 rounded-full font-bold hover:bg-[#6B4535] transition">
                OK
            </button>
            <button type="button" onclick="confirmModalResolve(false)" class="flex-1 bg-[#D4E4E0] text-[#554840] px-6 py-3 rounded-full font-bold hover:bg-[#C0D8D3] transition">
                Annuler
            </button>
        </div>
    </div>
</div>

{{-- Modal d'alerte personnalisée --}}
<div id="alertModal" style="display:none" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-8 max-w-md w-full mx-4 shadow-2xl">
        <h3 class="text-2xl font-bold text-[#554840] mb-4 font-kavoon" id="alertTitle">Information</h3>
        <p class="text-[#554840] mb-6" id="alertMessage"></p>

        <div class="flex justify-center">
            <button type="button" onclick="alertModalResolve()" class="bg-[#8E5442] text-white px-8 py-3 rounded-full font-bold hover:bg-[#6B4535] transition min-w-[150px]">
                OK
            </button>
        </div>
    </div>
</div>

<script>
    // Fonction pour afficher une confirmation personnalisée
    function showConfirm(message, title = 'Confirmation') {
        return new Promise((resolve) => {
            const modal = document.getElementById('confirmModal');
            const titleElement = document.getElementById('confirmTitle');
            const messageElement = document.getElementById('confirmMessage');

            titleElement.textContent = title;
            messageElement.textContent = message;
            modal.style.display = 'flex';

            window.confirmModalResolve = (result) => {
                modal.style.display = 'none';
                resolve(result);
            };
        });
    }

    // Fonction pour afficher une alerte personnalisée
    function showAlert(message, title = 'Information') {
        return new Promise((resolve) => {
            const modal = document.getElementById('alertModal');
            const titleElement = document.getElementById('alertTitle');
            const messageElement = document.getElementById('alertMessage');

            titleElement.textContent = title;
            messageElement.textContent = message;
            modal.style.display = 'flex';

            window.alertModalResolve = () => {
                modal.style.display = 'none';
                resolve();
            };
        });
    }

    // Fonction pour charger les détails d'un utilisateur sans recharger la page
    async function loadUserDetails(userId) {
        console.log('🔵 Chargement des détails pour l\'utilisateur:', userId);

        try {
            const response = await fetch(`/admin/users/${userId}/details`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Erreur HTTP: ' + response.status);
            }

            const user = await response.json();
            console.log('✅ Détails utilisateur reçus:', user);

            // Mettre à jour l'affichage
            updateUserDetailsDisplay(user.user, user.postes, user.poste_actuel, user.role_actuel);

            // Mettre en surbrillance l'opérateur sélectionné
            document.querySelectorAll('.operator-item').forEach(item => {
                item.classList.remove('bg-[#E8D4B4]');
                item.classList.add('bg-[#F5F5F5]');
            });
            document.querySelector(`[data-user-id="${userId}"]`)?.classList.add('bg-[#E8D4B4]');
            document.querySelector(`[data-user-id="${userId}"]`)?.classList.remove('bg-[#F5F5F5]');

        } catch (error) {
            console.error('❌ Erreur loadUserDetails:', error);
            await showAlert('Erreur lors du chargement des détails', 'Erreur');
        }
    }

    function updateUserDetailsDisplay(user, postes, posteActuel, roleActuel) {
        const container = document.getElementById('userDetailsContent');
        if (!container) return;

        console.log('📊 updateUserDetailsDisplay - roleActuel:', roleActuel);
        console.log('📊 updateUserDetailsDisplay - user:', user);

        const initial = (user.prenom?.[0] || 'e').toLowerCase();

        // Utiliser le rôle de l'équipe (roleActuel) au lieu du rôle global
        const isOperateur = roleActuel ? (roleActuel.nom || '').toLowerCase() === 'operateur' : false;
        const isSuperviseur = roleActuel ? (roleActuel.nom || '').toLowerCase() === 'superviseur' : false;

        console.log('🔍 isOperateur:', isOperateur, 'isSuperviseur:', isSuperviseur);

        // Générer les options du dropdown de postes
        let postesOptions = '<option value="">Aucun poste</option>';
        if (postes && postes.length > 0) {
            postes.forEach(poste => {
                const selected = posteActuel && posteActuel.id === poste.id ? 'selected' : '';
                postesOptions += `<option value="${poste.id}" ${selected}>${poste.nom}</option>`;
            });
        }

        const posteNom = posteActuel?.nom || 'Aucun poste';

        container.innerHTML = `
            <h3 class="text-2xl font-bold text-[#554840] mb-6 font-kavoon">Détail de l'étudiant</h3>

            <div class="bg-[#F4E4A6] rounded-2xl p-4 mb-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-[#D4A574] to-[#B8860B] rounded-full flex items-center justify-center text-white font-bold text-2xl">
                        ${initial}
                    </div>
                    <div class="flex-1">
                        <h4 class="text-lg font-bold text-[#554840]">${user.prenom || ''} ${user.nom || ''}</h4>
                        <p class="text-sm text-[#8B7355]">${user.email || ''}</p>
                    </div>
                    <button onclick="deleteUser(${user.id})" class="bg-red-600 text-white px-6 py-2 rounded-full font-bold hover:bg-red-700 transition">
                        Supprimer
                    </button>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="text-sm font-bold text-[#554840] block mb-2">Mail :</label>
                    <a href="mailto:${user.email || ''}" class="text-[#554840] underline">${user.email || ''}</a>
                </div>

                <div>
                    <label class="text-sm font-bold text-[#554840] block mb-2">Rôle (dans cette équipe) :</label>
                    <div class="flex gap-2 flex-wrap">
                        <button onclick="changeUserRole(${user.id}, 2)" class="px-4 py-2 rounded-full font-bold transition hover:opacity-80 ${isOperateur ? 'bg-[#8E5442] text-white' : 'bg-[#F4E4A6] text-[#554840]'}">
                            Opérateur
                        </button>
                        <button onclick="changeUserRole(${user.id}, 1)" class="px-4 py-2 rounded-full font-bold transition hover:opacity-80 ${isSuperviseur ? 'bg-[#8E5442] text-white' : 'bg-[#F4E4A6] text-[#554840]'}">
                            Superviseur
                        </button>
                    </div>
                </div>

                <div>
                    <label class="text-sm font-bold text-[#554840] block mb-2">Poste :</label>
                    <select onchange="changeUserPoste(${user.id}, this.value)" class="w-full px-4 py-2 rounded-full bg-[#D4E4E0] text-[#554840] focus:outline-none focus:ring-2 focus:ring-[#A8C9C3] cursor-pointer">
                        ${postesOptions}
                    </select>
                </div>
            </div>
        `;
    }

    document.addEventListener('DOMContentLoaded', function() {
        console.log('🟢 DOM chargé');

        renderOperators(allOperators);

        @if($selectedUser ?? false)
            // Si un utilisateur est déjà sélectionné, le charger
            loadUserDetails({{ $selectedUser->id }});
        @endif

        // Event listener pour bouton Ajouter
        const btnAdd = document.getElementById('btnAddOperator');
        console.log('🔍 Bouton trouvé:', btnAdd);

        if (btnAdd) {
            btnAdd.addEventListener('click', function() {
                console.log('🔵 Clic sur Ajouter');
                const modal = document.getElementById('addOperatorModal');
                if (modal) {
                    modal.style.display = 'block';
                    loadAvailableOperators();
                } else {
                    console.error('❌ Modal non trouvé');
                }
            });
            console.log('✅ Event listener attaché au bouton');
        } else {
            console.error('❌ Bouton btnAddOperator non trouvé !');
        }

        // Event listener pour bouton Fermer
        const btnClose = document.getElementById('btnCloseModal');
        if (btnClose) {
            btnClose.addEventListener('click', function() {
                document.getElementById('addOperatorModal').style.display = 'none';
            });
        }

        // Fermer modal en cliquant en dehors
        const modal = document.getElementById('addOperatorModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.style.display = 'none';
                }
            });
        }

        // Event listener pour la recherche
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('keyup', filterOperators);
        }

        const operatorSearch = document.getElementById('operatorSearch');
        if (operatorSearch) {
            operatorSearch.addEventListener('keyup', filterAvailableOperators);
        }
    });

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

    function renderOperators(operators) {
        const listDiv = document.getElementById('operatorsList');

        if (operators.length === 0) {
            listDiv.innerHTML = '<div class="text-center py-8 text-[#8B7355]"><p>Aucun opérateur trouvé</p></div>';
            return;
        }

        listDiv.innerHTML = operators.map(op => `
            <div onclick="loadUserDetails(${op.id})" class="operator-item flex items-center justify-between p-4 bg-[#F5F5F5] rounded-2xl hover:bg-[#EFEFEF] transition cursor-pointer" data-user-id="${op.id}">
                <div class="flex items-center gap-3 flex-1">
                    <div class="w-12 h-12 bg-gradient-to-br from-[#D4A574] to-[#B8860B] rounded-full flex items-center justify-center text-white font-bold">
                        ${(op.prenom?.charAt(0) || 'e').toLowerCase()}
                    </div>
                    <div>
                        <p class="font-bold text-[#554840]">${op.prenom || ''} ${op.nom || ''}</p>
                        <p class="text-sm text-[#8B7355]">Rôle : ${op.role?.nom || 'operateur'}</p>
                    </div>
                </div>
                <div class="text-[#554840] hover:text-[#8E5442] transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
        `).join('');
    }

    async function loadAvailableOperators() {
        console.log('🔵 Chargement des opérateurs disponibles...');
        try {
            const response = await fetch('/admin/available-operators');
            console.log('📡 Réponse:', response);
            if (!response.ok) {
                throw new Error('Erreur HTTP: ' + response.status);
            }
            availableOperatorsData = await response.json();
            console.log('✅ Opérateurs chargés:', availableOperatorsData);
            filterAvailableOperators();
        } catch (error) {
            console.error('❌ Erreur loadAvailableOperators:', error);
            document.getElementById('availableOperatorsList').innerHTML =
                '<div class="text-center py-8 text-red-500"><p>Erreur lors du chargement</p></div>';
        }
    }

    function filterAvailableOperators() {
        const searchTerm = document.getElementById('operatorSearch')?.value.toLowerCase() || '';

        const assignedIds = allOperators.map(op => op.id);

        const filtered = availableOperatorsData.filter(op => {
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
                        ${op.prenom?.charAt(0) || 'E'}
                    </div>
                    <div>
                        <p class="font-bold text-[#554840]">${op.prenom || ''} ${op.nom || ''}</p>
                        <p class="text-sm text-[#8B7355]">${op.email || ''}</p>
                    </div>
                </div>
                <button type="button" class="bg-[#554840] text-white px-4 py-2 rounded-full font-bold hover:bg-[#3B2A21] transition" onclick="addOperatorToTeam(${op.id})">
                    Ajouter
                </button>
            </div>
        `).join('');
    }

    async function addOperatorToTeam(userId) {
        try {
            console.log('🔵 Ajout opérateur:', userId);
            const response = await fetch(`/admin/operators/${userId}/add`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();
            console.log('📡 Réponse serveur:', data);

            if (response.ok && data.success) {
                await showAlert(data.message, 'Succès');
                document.getElementById('addOperatorModal').style.display = 'none';
                setTimeout(() => {
                    location.reload();
                }, 500);
            } else {
                await showAlert(data.error || 'Erreur lors de l\'ajout', 'Erreur');
            }
        } catch (error) {
            console.error('❌ Erreur addOperatorToTeam:', error);
            await showAlert('Erreur lors de l\'ajout de l\'opérateur', 'Erreur');
        }
    }

    async function changeUserRole(userId, roleId) {
        const confirmed = await showConfirm('Voulez-vous vraiment modifier le rôle de cet utilisateur dans cette équipe ?', 'Modification du rôle');

        if (!confirmed) {
            return;
        }

        try {
            const response = await fetch(`/admin/users/${userId}/change-role`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ role_id: roleId })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                await showAlert(data.message, 'Succès');
                // Recharger les détails de l'utilisateur
                loadUserDetails(userId);

                // Mettre à jour le rôle affiché dans la liste
                const operatorItem = document.querySelector(`[data-user-id="${userId}"]`);
                if (operatorItem && data.role) {
                    const roleText = operatorItem.querySelector('.text-sm');
                    if (roleText) {
                        roleText.textContent = 'Rôle : ' + data.role.nom;
                    }
                }
            } else {
                await showAlert(data.message || 'Erreur lors de la modification du rôle', 'Erreur');
            }
        } catch (error) {
            console.error('❌ Erreur changeUserRole:', error);
            await showAlert('Erreur lors de la modification du rôle', 'Erreur');
        }
    }

    async function changeUserPoste(userId, posteId) {
        if (!posteId) {
            await showAlert('Veuillez sélectionner un poste', 'Attention');
            return;
        }

        try {
            const response = await fetch(`/admin/users/${userId}/change-poste`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ poste_id: posteId })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                await showAlert(data.message, 'Succès');
            } else {
                await showAlert(data.message || 'Erreur lors de la modification du poste', 'Erreur');
            }
        } catch (error) {
            console.error('❌ Erreur changeUserPoste:', error);
            await showAlert('Erreur lors de la modification du poste', 'Erreur');
        }
    }

    async function deleteUser(userId) {
        const confirmed = await showConfirm('Êtes-vous sûr de vouloir retirer cet utilisateur de l\'équipe ? Cette action est irréversible.', 'Retirer de l\'équipe');

        if (!confirmed) {
            return;
        }

        try {
            const response = await fetch(`/admin/users/${userId}/delete-ajax`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (response.ok && data.success) {
                await showAlert(data.message, 'Succès');
                // Supprimer l'élément de la liste
                const operatorItem = document.querySelector(`[data-user-id="${userId}"]`);
                if (operatorItem) {
                    operatorItem.remove();
                }
                // Réinitialiser l'affichage des détails
                document.getElementById('userDetailsContent').innerHTML = `
                    <div class="h-full flex items-center justify-center">
                        <div class="text-center">
                            <p class="text-[#8B7355] text-lg mb-4">Sélectionnez un étudiant pour voir ses détails</p>
                        </div>
                    </div>
                `;
            } else {
                await showAlert(data.message || 'Erreur lors de la suppression', 'Erreur');
            }
        } catch (error) {
            console.error('❌ Erreur deleteUser:', error);
            await showAlert('Erreur lors de la suppression de l\'utilisateur', 'Erreur');
        }
    }
</script>
