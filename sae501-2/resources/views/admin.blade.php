@extends('layouts.app')

@section('title', 'Administration | L\'Usine Chocolat 2026')

@section('content')
<style>
    body {
        background: var(--green) !important;
        background-image: none !important;
    }
</style>
<div class="max-w-7xl mx-auto p-6">
    <h2 class="text-4xl font-bold text-[var(--choco-brown)] mb-8 font-kavoon">Administration</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8" role="region" aria-label="Statistiques de l'équipe">
        <article class="bg-[var(--choco-gold)] rounded-3xl p-4 sm:p-6 flex items-center gap-3 sm:gap-4 shadow-lg hover:shadow-xl transition" aria-labelledby="stat-utilisateurs">
            <div class="w-12 h-12 sm:w-16 sm:h-16 flex items-center justify-center flex-shrink-0">
                <img src="{{ asset('images/autre/seul_marron.svg') }}" alt="" class="w-full h-full object-contain" aria-hidden="true" />
            </div>
            <div>
                <p id="stat-utilisateurs" class="text-[var(--choco-brown)] font-bold text-base sm:text-lg">Utilisateurs</p>
                <p class="text-[var(--choco-brown)] text-xs sm:text-sm">actifs</p>
                <p class="text-2xl sm:text-3xl font-bold text-[var(--choco-brown)] mt-1 sm:mt-2" aria-label="{{ $stats['utilisateurs_actifs'] ?? 3 }} utilisateurs actifs">{{ $stats['utilisateurs_actifs'] ?? 3 }}</p>
            </div>
        </article>

        <article class="bg-[var(--choco)] rounded-3xl p-4 sm:p-6 flex items-center gap-3 sm:gap-4 shadow-lg hover:shadow-xl transition" aria-labelledby="stat-roles">
            <div class="w-12 h-12 sm:w-16 sm:h-16 flex items-center justify-center flex-shrink-0">
                <img src="{{ asset('images/autre/seul_vert.svg') }}" alt="" class="w-full h-full object-contain" aria-hidden="true" />
            </div>
            <div>
                <p id="stat-roles" class="text-white font-bold text-base sm:text-lg">Rôles</p>
                <p class="text-white text-xs sm:text-sm">définis</p>
                <p class="text-2xl sm:text-3xl font-bold text-white mt-1 sm:mt-2" aria-label="{{ $stats['roles'] ?? 7 }} rôles définis">{{ $stats['roles'] ?? 7 }}</p>
            </div>
        </article>

        <article class="bg-[var(--choco-gold)] rounded-3xl p-4 sm:p-6 flex items-center gap-3 sm:gap-4 shadow-lg hover:shadow-xl transition" aria-labelledby="stat-postes">
            <div class="w-12 h-12 sm:w-16 sm:h-16 flex items-center justify-center flex-shrink-0">
                <img src="{{ asset('images/autre/seul_marron.svg') }}" alt="" class="w-full h-full object-contain" aria-hidden="true" />
            </div>
            <div>
                <p id="stat-postes" class="text-[var(--choco-brown)] font-bold text-base sm:text-lg">Postes</p>
                <p class="text-[var(--choco-brown)] text-xs sm:text-sm">de travail affectés</p>
                <p class="text-2xl sm:text-3xl font-bold text-[var(--choco-brown)] mt-1 sm:mt-2" id="postesCount" aria-label="{{ $stats['postes'] ?? 5 }} postes de travail">{{ $stats['postes'] ?? 5 }}</p>
            </div>
        </article>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 sm:gap-6">
        <section class="bg-white rounded-3xl p-4 sm:p-6 shadow-lg" aria-labelledby="students-list-title">
            <h3 id="students-list-title" class="text-xl sm:text-2xl font-bold text-[var(--choco-brown)] mb-4 sm:mb-6 font-kavoon">Liste des étudiants</h3>

            <div class="flex flex-col sm:flex-row gap-3 mb-4 sm:mb-6">
                <div class="flex-1 relative">
                    <label for="searchInput" class="sr-only">Rechercher un étudiant</label>
                    <input type="text" id="searchInput" placeholder="Rechercher un étudiant" aria-label="Rechercher un étudiant" class="w-full px-4 py-2 rounded-full bg-[var(--green)] text-[var(--choco-brown)] placeholder-[var(--choco-brown)]/50 focus:outline-none focus:ring-2 focus:ring-[var(--green)]">
                    <svg class="w-5 h-5 absolute right-4 top-1/2 -translate-y-1/2 text-[var(--choco-brown)]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <button type="button" id="btnAddOperator" aria-label="Ajouter un opérateur" class="bg-[var(--choco-brown)] text-white px-4 sm:px-6 py-2 rounded-full font-bold hover:bg-[var(--choco)] transition flex items-center justify-center gap-2 w-full sm:w-auto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Ajouter</span>
                </button>
            </div>

            <ul class="space-y-3 max-h-96 overflow-y-auto" id="operatorsList" role="list" aria-label="Liste des étudiants">
                @forelse($etudiants ?? [] as $etudiant)
                    <li>
                        <button type="button" onclick="loadUserDetails({{ $etudiant['id'] }})" class="w-full flex items-center justify-between p-3 sm:p-4 bg-white rounded-2xl hover:bg-white/95 focus:outline-none transition cursor-pointer operator-item" data-user-id="{{ $etudiant['id'] }}" aria-label="Voir les détails de {{ $etudiant['prenom'] ?? 'Étudiant' }} {{ $etudiant['nom'] ?? '' }}">
                            <div class="flex items-center gap-2 sm:gap-3 flex-1 text-left">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-[var(--green)] rounded-full flex items-center justify-center p-2" aria-hidden="true">
                                    <img src="{{ asset('images/autre/seul_marron.svg') }}" alt="" class="w-full h-full object-contain" />
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="font-bold text-[var(--choco-brown)] text-sm sm:text-base truncate user-name">{{ $etudiant['prenom'] ?? 'Étudiant' }} {{ $etudiant['nom'] ?? '' }}</p>
                                    <p class="text-xs sm:text-sm text-[var(--choco-brown)]/70 truncate user-role">Rôle : {{ $etudiant['role_equipe']['nom'] ?? $etudiant['role']['nom'] ?? 'operateur' }}</p>
                                </div>
                            </div>
                            <div class="text-[var(--choco-brown)] hover:text-[var(--choco)] transition flex-shrink-0 arrow-icon" aria-hidden="true">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </button>
                    </li>
                @empty
                    <li class="text-center py-8 text-[var(--choco-brown)]/70" role="status">
                        <p>Aucun étudiant pour le moment</p>
                    </li>
                @endforelse
            </ul>
        </section>

        <section class="bg-white rounded-3xl p-4 sm:p-6 shadow-lg min-h-[500px] flex flex-col" id="userDetailsContainer" aria-labelledby="student-details-title" aria-live="polite">
            <div id="userDetailsContent" class="flex-1 flex flex-col">
                @if($selectedUser ?? false)
                    <h3 id="student-details-title" class="text-xl sm:text-2xl font-bold text-[var(--choco-brown)] mb-4 sm:mb-6 font-kavoon">Détail de l'étudiant</h3>

                    <div class="bg-[var(--choco-gold)] rounded-2xl p-3 sm:p-4 mb-4 sm:mb-6">
                        <div class="flex items-center gap-3 sm:gap-4 mb-3 sm:mb-4 flex-wrap">
                            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-[var(--choco-brown)] rounded-full flex items-center justify-center p-2" aria-hidden="true">
                                <img src="{{ asset('images/autre/seul_marron.svg') }}" alt="" class="w-full h-full object-contain" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-base sm:text-lg font-bold text-[var(--choco-brown)] truncate">{{ $selectedUser->prenom ?? '' }} {{ $selectedUser->nom ?? '' }}</h4>
                                <p class="text-xs sm:text-sm text-[var(--choco-brown)]/70 truncate">QLIO 2</p>
                            </div>
                            <a href="{{ route('admin.edit', $selectedUser) }}" class="bg-[var(--choco)] text-white px-4 sm:px-6 py-2 rounded-full font-bold hover:bg-[var(--choco-brown)] focus:outline-none focus:ring-2 focus:ring-[var(--choco)] transition w-full sm:w-auto text-center">
                                Modifier
                            </a>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-bold text-[var(--choco-brown)] block mb-2">Mail :</label>
                            <a href="mailto:{{ $selectedUser->email ?? '' }}" class="text-[var(--choco-brown)] underline">{{ $selectedUser->email ?? '' }}</a>
                        </div>

                        <div>
                            <label class="text-sm font-bold text-[var(--choco-brown)] block mb-2">Rôle :</label>
                            <div class="flex gap-2 flex-wrap">
                                @php
                                    $isOperateur = strtolower($selectedUser->role->nom ?? '') === 'operateur';
                                    $isSuperviseur = strtolower($selectedUser->role->nom ?? '') === 'superviseur';
                                @endphp
                                <span class="px-4 py-2 rounded-full font-bold {{ $isOperateur ? 'bg-[var(--choco)] text-white' : 'bg-[var(--choco-gold)] text-[var(--choco-brown)]' }}">
                                    Opérateur
                                </span>
                                <span class="px-4 py-2 rounded-full font-bold {{ $isSuperviseur ? 'bg-[var(--choco)] text-white' : 'bg-[var(--choco-gold)] text-[var(--choco-brown)]' }}">
                                    Superviseur
                                </span>
                            </div>
                        </div>

                        @if($selectedUser->usersEquipe)
                            <div>
                                <label class="text-sm font-bold text-[var(--choco-brown)] block mb-2">Poste :</label>
                                <div class="flex items-center gap-2">
                                    <span class="text-[var(--choco-brown)]">{{ $selectedUser->usersEquipe->poste->nom ?? 'Aucun poste' }}</span>
                                    <svg class="w-4 h-4 text-[var(--choco-brown)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="flex-1 flex items-center justify-center">
                        <div class="text-center">
                            <p class="text-[var(--choco-brown)] text-lg mb-4">Sélectionnez un étudiant pour voir ses détails</p>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
</div>

<div id="addOperatorModal" style="display:none" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" role="dialog" aria-labelledby="modal-title" aria-modal="true">
    <div class="bg-white rounded-3xl p-4 sm:p-6 md:p-8 max-w-3xl w-full mx-4 shadow-2xl max-h-[90vh] overflow-y-auto">
        <h3 id="modal-title" class="text-xl sm:text-2xl font-bold text-[var(--choco-brown)] mb-4 sm:mb-6 font-kavoon">Ajouter un opérateur</h3>

        <div class="relative mb-4 sm:mb-6">
            <label for="operatorSearch" class="sr-only">Rechercher un opérateur par nom</label>
            <input type="text" id="operatorSearch" placeholder="Rechercher par nom..." aria-label="Rechercher un opérateur par nom" class="w-full px-4 py-2 rounded-full bg-[var(--green)] text-[var(--choco-brown)] placeholder-[var(--choco-brown)]/50 focus:outline-none focus:ring-2 focus:ring-[var(--green)]">
            <svg class="w-5 h-5 absolute right-4 top-1/2 -translate-y-1/2 text-[var(--choco-brown)]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        <div id="availableOperatorsList" class="space-y-3 max-h-96 overflow-y-auto mb-6">
            <div class="text-center py-8 text-[var(--choco-brown)]/70">
                <p>Chargement des opérateurs disponibles...</p>
            </div>
        </div>

        <div class="flex gap-3 pt-4">
            <button type="button" id="btnCloseModal" aria-label="Fermer la modale" class="flex-1 bg-[var(--green)] text-[var(--choco-brown)] px-4 sm:px-6 py-2 rounded-full font-bold hover:bg-[var(--green)]/80 focus:outline-none focus:ring-2 focus:ring-[var(--choco)] transition">
                Fermer
            </button>
        </div>
    </div>
</div>

<div id="confirmModal" style="display:none" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" role="dialog" aria-labelledby="confirmTitle" aria-modal="true">
    <div class="bg-white rounded-3xl p-4 sm:p-6 md:p-8 max-w-md w-full mx-4 shadow-2xl">
        <h3 class="text-xl sm:text-2xl font-bold text-[var(--choco-brown)] mb-3 sm:mb-4 font-kavoon" id="confirmTitle">Confirmation</h3>
        <p class="text-sm sm:text-base text-[var(--choco-brown)] mb-4 sm:mb-6" id="confirmMessage"></p>

        <div class="flex flex-col sm:flex-row gap-3">
            <button type="button" onclick="confirmModalResolve(true)" aria-label="Confirmer l'action" class="flex-1 bg-[var(--choco)] text-white px-4 sm:px-6 py-3 rounded-full font-bold hover:bg-[var(--choco-brown)] focus:outline-none focus:ring-2 focus:ring-[var(--choco)] transition order-2 sm:order-1">
                OK
            </button>
            <button type="button" onclick="confirmModalResolve(false)" aria-label="Annuler l'action" class="flex-1 bg-[var(--green)] text-[var(--choco-brown)] px-4 sm:px-6 py-3 rounded-full font-bold hover:bg-[var(--green)]/80 focus:outline-none focus:ring-2 focus:ring-[var(--choco)] transition order-1 sm:order-2">
                Annuler
            </button>
        </div>
    </div>
</div>

{{-- Modal d'alerte personnalisée --}}
<div id="alertModal" style="display:none" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" role="alertdialog" aria-labelledby="alertTitle" aria-modal="true">
    <div class="bg-white rounded-3xl p-4 sm:p-6 md:p-8 max-w-md w-full mx-4 shadow-2xl">
        <h3 class="text-xl sm:text-2xl font-bold text-[var(--choco-brown)] mb-3 sm:mb-4 font-kavoon" id="alertTitle">Information</h3>
        <p class="text-sm sm:text-base text-[var(--choco-brown)] mb-4 sm:mb-6" id="alertMessage"></p>

        <div class="flex justify-center">
            <button type="button" onclick="alertModalResolve()" aria-label="Fermer l'alerte" class="bg-[var(--choco)] text-white px-6 sm:px-8 py-3 rounded-full font-bold hover:bg-[var(--choco-brown)] focus:outline-none focus:ring-2 focus:ring-[var(--choco)] transition min-w-[120px] sm:min-w-[150px]">
                OK
            </button>
        </div>
    </div>
</div>

<script>
    // Initialisation des données
    let allOperators = @json($etudiants ?? []);
    const roles = @json($roles ?? []);
    const postes = @json($postes ?? []);
    const currentUserId = {{ auth()->id() }};
    const isGlobalSupervisor = @json($isGlobalSupervisor ?? false);

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
        console.log('Chargement des détails pour l\'utilisateur:', userId);

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
            console.log('Détails utilisateur reçus:', user);

            updateUserDetailsDisplay(user.user, user.postes, user.poste_actuel, user.role_actuel);

            document.querySelectorAll('.operator-item').forEach(item => {
                item.classList.remove('!bg-[#8E5442]');
                item.classList.add('bg-white');
                const nameEl = item.querySelector('.user-name');
                const roleEl = item.querySelector('.user-role');
                const arrowEl = item.querySelector('.arrow-icon');
                if (nameEl) {
                    nameEl.classList.remove('!text-white');
                    nameEl.classList.add('text-[var(--choco-brown)]');
                }
                if (roleEl) {
                    roleEl.classList.remove('!text-white');
                    roleEl.classList.add('text-[var(--choco-brown)]/70');
                }
                if (arrowEl) {
                    arrowEl.classList.remove('!text-white');
                }
            });
            const selectedItem = document.querySelector(`[data-user-id="${userId}"]`);
            if (selectedItem) {
                selectedItem.classList.add('!bg-[#8E5442]');
                selectedItem.classList.remove('bg-white');
                const nameEl = selectedItem.querySelector('.user-name');
                const roleEl = selectedItem.querySelector('.user-role');
                const arrowEl = selectedItem.querySelector('.arrow-icon');
                if (nameEl) {
                    nameEl.classList.add('!text-white');
                    nameEl.classList.remove('text-[var(--choco-brown)]');
                }
                if (roleEl) {
                    roleEl.classList.add('!text-white');
                    roleEl.classList.remove('text-[var(--choco-brown)]/70');
                }
                if (arrowEl) {
                    arrowEl.classList.add('!text-white');
                }
            }

        } catch (error) {
            console.error('Erreur loadUserDetails:', error);
            await showAlert('Erreur lors du chargement des détails', 'Erreur');
        }
    }

    function updateUserDetailsDisplay(user, postes, posteActuel, roleActuel) {
        const container = document.getElementById('userDetailsContent');
        if (!container) return;

        console.log('updateUserDetailsDisplay - roleActuel:', roleActuel);
        console.log('updateUserDetailsDisplay - user:', user);

        const initial = (user.prenom?.[0] || 'e').toLowerCase();

        const isOperateur = roleActuel ? (roleActuel.nom || '').toLowerCase() === 'operateur' : false;
        const isSuperviseur = roleActuel ? (roleActuel.nom || '').toLowerCase() === 'superviseur' : false;

        console.log('isOperateur:', isOperateur, 'isSuperviseur:', isSuperviseur);

        let postesOptions = '<option value="">Sélectionner un poste</option>';
        if (postes && postes.length > 0) {
            postes.forEach(poste => {
                const selected = posteActuel && posteActuel.id === poste.id ? 'selected' : '';
                postesOptions += `<option value="${poste.id}" ${selected}>${poste.nom}</option>`;
            });
        }

        const posteNom = posteActuel?.nom || 'Aucun poste';
        const isCurrentUser = user.id === currentUserId && isGlobalSupervisor;
        const canModify = !isCurrentUser;

        container.innerHTML = `
            <h3 id="student-details-title" class="text-xl sm:text-2xl font-bold text-[var(--choco-brown)] mb-4 sm:mb-6 font-kavoon">Détail de l'étudiant</h3>

            <div class="bg-[var(--choco-gold)] rounded-2xl p-4 mb-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-[var(--choco-brown)] rounded-full flex items-center justify-center p-2">
                        <img src="{{ asset('images/autre/seul_marron.svg') }}" alt="" class="w-full h-full object-contain" />
                    </div>
                    <div class="flex-1">
                        <h4 class="text-lg font-bold text-[var(--choco-brown)]">${user.prenom || ''} ${user.nom || ''}</h4>
                        <p class="text-sm text-[var(--choco-brown)]/70">QLIO 2</p>
                        ${isCurrentUser ? '<p class="text-xs text-[var(--choco)] font-bold mt-1">Vous (Superviseur)</p>' : ''}
                    </div>
                    ${isCurrentUser || !canModify ? '' : `<button onclick="deleteUser(${user.id})" class="bg-[var(--choco)] text-white px-6 py-2 rounded-full font-bold hover:bg-[var(--choco-brown)] transition">
                        Supprimer
                    </button>`}
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="text-sm font-bold text-[var(--choco-brown)] block mb-2">Mail :</label>
                    <a href="mailto:${user.email || ''}" class="text-[var(--choco-brown)] underline">${user.email || ''}</a>
                </div>

                <div>
                    <label class="text-sm font-bold text-[var(--choco-brown)] block mb-2">Rôle (dans cette équipe) :</label>
                    ${isCurrentUser || !canModify ? `<p class="text-[var(--choco-brown)]">${roleActuel?.nom || 'Superviseur'} (non modifiable)</p>` : `<div class="flex gap-2 flex-wrap">
                        <button onclick="changeUserRole(${user.id}, 2)" class="px-4 py-2 rounded-full font-bold transition hover:opacity-80 ${isOperateur ? 'bg-[var(--choco)] text-white' : 'bg-[var(--choco-gold)] text-[var(--choco-brown)]'}">
                            Opérateur
                        </button>
                        <button onclick="changeUserRole(${user.id}, 1)" class="px-4 py-2 rounded-full font-bold transition hover:opacity-80 ${isSuperviseur ? 'bg-[var(--choco)] text-white' : 'bg-[var(--choco-gold)] text-[var(--choco-brown)]'}">
                            Superviseur
                        </button>
                    </div>`}
                </div>

                ${isCurrentUser || !canModify ? '' : `<div>
                    <label class="text-sm font-bold text-[var(--choco-brown)] block mb-2">Poste :</label>
                    <select onchange="changeUserPoste(${user.id}, this.value)" class="w-full px-4 py-2 rounded-full bg-[var(--green)] text-[var(--choco-brown)] focus:outline-none focus:ring-2 focus:ring-[var(--green)] cursor-pointer">
                        ${postesOptions}
                    </select>
                </div>`}
            </div>
        `;
    }

    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM chargé');

        renderOperators(allOperators);

        @if($selectedUser ?? false)
            loadUserDetails({{ $selectedUser->id }});
        @endif

        const btnAdd = document.getElementById('btnAddOperator');
        if (btnAdd) {
            btnAdd.addEventListener('click', function() {
                console.log('Clic sur Ajouter');
                const modal = document.getElementById('addOperatorModal');
                if (modal) {
                    modal.style.display = 'flex';
                    loadAvailableOperators();
                } else {
                    console.error('Modal non trouvé');
                }
            });
            console.log('Event listener attaché au bouton');
        } else {
            console.error('Bouton btnAddOperator non trouvé !');
        }

        // Event listener pour bouton Fermer
        const btnClose = document.getElementById('btnCloseModal');
        if (btnClose) {
            btnClose.addEventListener('click', function() {
                document.getElementById('addOperatorModal').style.display = 'none';
            });
        }

        const modal = document.getElementById('addOperatorModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.style.display = 'none';
                }
            });
        }

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
            listDiv.innerHTML = '<div class="text-center py-8 text-[var(--choco-brown)]/70"><p>Aucun opérateur trouvé</p></div>';
            return;
        }

        listDiv.innerHTML = operators.map(op => `
            <div onclick="loadUserDetails(${op.id})" class="operator-item flex items-center justify-between p-4 bg-white rounded-2xl hover:bg-white/95 transition cursor-pointer" data-user-id="${op.id}">
                <div class="flex items-center gap-3 flex-1">
                    <div class="w-12 h-12 bg-gradient-to-br from-[#D4A574] to-[#B8860B] rounded-full flex items-center justify-center text-white font-bold">
                        ${(op.prenom?.charAt(0) || 'e').toLowerCase()}
                    </div>
                    <div>
                        <p class="user-name font-bold text-[var(--choco-brown)]">${op.prenom || ''} ${op.nom || ''}</p>
                        <p class="text-sm text-[var(--choco-brown)]/70 user-role">Rôle : ${op.role_equipe?.nom || op.role?.nom || 'operateur'}</p>
                    </div>
                </div>
                <div class="arrow-icon text-[var(--choco-brown)] hover:text-[var(--choco)] transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
        `).join('');
    }

    async function loadAvailableOperators() {
        console.log('Chargement des opérateurs disponibles...');
        try {
            const response = await fetch('/admin/available-operators');
            console.log('Réponse:', response);
            if (!response.ok) {
                throw new Error('Erreur HTTP: ' + response.status);
            }
            availableOperatorsData = await response.json();
            console.log('Opérateurs chargés:', availableOperatorsData);
            filterAvailableOperators();
        } catch (error) {
            console.error('Erreur loadAvailableOperators:', error);
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
            listDiv.innerHTML = '<div class="text-center py-8 text-[var(--choco-brown)]/70"><p>Aucun opérateur disponible</p></div>';
            return;
        }

        listDiv.innerHTML = operators.map(op => `
            <div class="flex items-center justify-between p-4 bg-white rounded-2xl hover:bg-white/95 transition cursor-pointer">
                <div class="flex items-center gap-3 flex-1">
                    <div class="w-12 h-12 bg-gradient-to-br from-[#D4A574] to-[#B8860B] rounded-full flex items-center justify-center text-white font-bold">
                        ${op.prenom?.charAt(0) || 'E'}
                    </div>
                    <div>
                        <p class="font-bold text-[var(--choco-brown)]">${op.prenom || ''} ${op.nom || ''}</p>
                        <p class="text-sm text-[var(--choco-brown)]/70">${op.email || ''}</p>
                    </div>
                </div>
                <button type="button" class="bg-[var(--choco-brown)] text-white px-4 py-2 rounded-full font-bold hover:bg-[var(--choco-brown)] transition" onclick="addOperatorToTeam(${op.id})">
                    Ajouter
                </button>
            </div>
        `).join('');
    }

    async function addOperatorToTeam(userId) {
        try {
            console.log('Ajout opérateur:', userId);
            const response = await fetch(`/admin/operators/${userId}/add`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();
            console.log('Réponse serveur:', data);

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
            console.error('Erreur addOperatorToTeam:', error);
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
                    const roleText = operatorItem.querySelector('.user-role');
                    if (roleText) {
                        roleText.textContent = 'Rôle : ' + data.role.nom;
                    }
                }
            } else {
                await showAlert(data.message || 'Erreur lors de la modification du rôle', 'Erreur');
            }
        } catch (error) {
            console.error('Erreur changeUserRole:', error);
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

                // Mettre à jour le compteur de postes
                if (data.nb_postes !== undefined) {
                    console.log('Mise à jour du compteur de postes:', data.nb_postes);
                    const postesCountElement = document.getElementById('postesCount');
                    if (postesCountElement) {
                        postesCountElement.textContent = data.nb_postes;
                        postesCountElement.setAttribute('aria-label', `${data.nb_postes} postes de travail`);
                        console.log('Compteur mis à jour');
                    } else {
                        console.error('Élément postesCount non trouvé');
                    }
                }
            } else {
                await showAlert(data.message || 'Erreur lors de la modification du poste', 'Erreur');
            }
        } catch (error) {
            console.error('Erreur changeUserPoste:', error);
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

                // Retirer l'utilisateur de allOperators
                allOperators = allOperators.filter(op => op.id !== userId);

                // Supprimer l'élément de la liste
                const operatorItem = document.querySelector(`[data-user-id="${userId}"]`);
                if (operatorItem) {
                    operatorItem.remove();
                }

                // Recharger la liste des opérateurs disponibles si la modale est ouverte
                const modal = document.getElementById('addOperatorModal');
                if (modal && modal.style.display === 'flex') {
                    await loadAvailableOperators();
                }

                // Réinitialiser l'affichage des détails
                document.getElementById('userDetailsContent').innerHTML = `
                    <div class="flex-1 flex items-center justify-center">
                        <div class="text-center">
                            <p class="text-[var(--choco-brown)] text-lg mb-4">Sélectionnez un étudiant pour voir ses détails</p>
                        </div>
                    </div>
                `;
            } else {
                await showAlert(data.message || 'Erreur lors de la suppression', 'Erreur');
            }
        } catch (error) {
            console.error('Erreur deleteUser:', error);
            await showAlert('Erreur lors de la suppression de l\'utilisateur', 'Erreur');
        }
    }
</script>

@endsection
