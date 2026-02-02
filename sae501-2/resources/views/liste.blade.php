@extends('layouts.app')

@section('title', 'Liste des commandes | L\'Usine Chocolat 2026')

@section('content')

<div class="bg-[var(--choco-gold)] min-h-screen">
    <div class="max-w-[1400px] mx-auto p-6">
        {{-- HEADER --}}
        <div class="bg-[var(--choco)] rounded-full px-6 py-4 text-[var(--choco-beige)] mb-6">
            <div class="grid grid-cols-1 gap-4 items-center sm:grid-cols-3 sm:gap-0 sm:text-center">

                <div class="flex items-center gap-4 sm:justify-start">
                    <div class="w-10 h-10">
                        <img src="/images/autre/seul_vert.svg" alt="Avatar" class="w-full h-full">
                    </div>
                    <span class="text-xl whitespace-nowrap  font-kavoon font-medium">Objectif :</span>
                </div>

                <div class="flex flex-col items-center gap-2">
                    <span class="text-md  font-kavoon font-medium">{{ $commandesAujourdhui ?? 0 }} / {{ $objectifValeur ?? 100 }} commandes à la journée</span>
                    <div class="w-full max-w-xs h-2  bg-[var(--choco-beige)] rounded-full overflow-hidden">
                        <div class="h-full w-[{{ $pourcentage ?? 0 }}%] bg-[var(--green)] transition-all duration-300"></div>
                    </div>
                </div>


                <div class="flex sm:justify-end justify-start">
                    <form method="POST" action="{{ route('objectifs.store') }}" class="flex gap-2 items-center">
                        @csrf
                        <input type="number"
                            name="objectif_commandes"
                            value="{{ $objectifValeur ?? 100 }}"
                            min="1" max="999"
                            class="px-3 py-2 rounded bg-white/20 text-white w-20 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-white/50">
                        <button type="submit" class="w-12 h-12 flex items-center justify-center hover:brightness-110 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-12 h-12 text-[var(--caramel)]">
                                <path fill-rule="evenodd"
                                    d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 00-1.5 0v2.25H9a.75.75 0 000 1.5h2.25V15a.75.75 0 001.5 0v-2.25H15a.75.75 0 000-1.5h-2.25V9Z"
                                    clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>


        {{-- TITRE --}}
        <h1 class="text-3xl text-center mb-6 text-[var(--choco-brown)] font-kavoon font-medium">
            Liste des commandes
        </h1>

        {{-- CONTENT --}}
    <div class="max-w-[1400px] mx-auto">
        <div class="flex gap-6 items-stretch">
            {{-- COLONNE GAUCHE --}}
            <div class=" w-full sm:w-[35%] lg:w-[25%] xl:w-[20%] flex flex-col gap-3 font-kavoon">

                <aside class="bg-[var(--choco-brown)] text-[var(--choco-beige)] rounded-3xl p-4 flex-1">
                    <h2 class="text-lg mb-4">Étapes</h2>

                                <ul class="space-y-2" id="etapesList">
                    @foreach ($etapes as $etape)
                        <li
                            class="
                                px-4 py-2 rounded-2xl flex justify-between items-center cursor-pointer
                                transition etape-item
                                {{ $loop->first ? 'bg-[var(--caramel-dark)] text-[var(--choco-beige)] active' : 'opacity-80 bg-[var(--choco-brown)] text-[var(--choco-beige)]' }}
                            "
                            data-poste-id="{{ $etape->id }}"
                        >
                            {{ $etape->nom }}
                        </li>
                    @endforeach
                </ul>

                <script>
                    let searchCommande = '';
                    let filtreChocolat = '';
                    const commandesData = @json($commandesParPoste);
                    let refreshInterval;

                    function afficherCommandes(posteId) {
                        const poste = commandesData.find(p => p.id == posteId);
                        const container = document.querySelector('.space-y-4');

                        if (!poste || !poste.commandes.length) {
                            container.innerHTML = `
                                <div class="w-full flex justify-center py-8">
                                    <div class="bg-white rounded-3xl p-4 border border-[var(--choco)] shadow-[4px_4px_0_var(--choco)] w-fit mx-auto">
                                        <p class="text-[var(--choco-brown)] font-kavoon text-base font-medium m-0 px-4 text-center">Aucune commande pour ce poste</p>
                                    </div>
                                </div>
                            `;
                            return;
                        }

                            const commandesFiltrees = poste.commandes.filter(cmd => {

                                const matchSearch = !searchCommande ||
                                    (cmd.numero_commande || '').toLowerCase().includes(searchCommande) ||
                                    (cmd.visiteur?.nom || '').toLowerCase().includes(searchCommande) ||
                                    (cmd.visiteur?.prenom || '').toLowerCase().includes(searchCommande);

                                const matchChocolat = !filtreChocolat || cmd.chocolat.nom === filtreChocolat;

                                return matchSearch && matchChocolat;
                            });


                        if (!commandesFiltrees.length) {
                            container.innerHTML = `
                                <div class="w-full flex justify-center py-8">
                                    <div class="bg-white rounded-3xl p-4 border border-[var(--choco)] shadow-[4px_4px_0_var(--choco)] w-fit mx-auto">
                                        <p class="text-[var(--choco-brown)] font-kavoon text-base font-medium m-0 px-4 text-center">
                                            Aucune commande trouvée
                                        </p>
                                    </div>
                                </div>
                            `;
                            return;
                        }

                        container.innerHTML = commandesFiltrees.map(cmd => {
                            // Vérifier si c'est le dernier poste
                            const estDernierPoste = !commandesData.find(p => p.ordre > poste.ordre);

                        return `
                        <div class="bg-white rounded-3xl p-5 border border-[var(--choco)] shadow-sm flex justify-between items-center">

                            <!-- GAUCHE -->
                            <div class="flex gap-4 items-center flex-1">

                                <!-- IMAGE -->
                                <div class="w-14 h-14 flex items-center justify-center shrink-0">
                                    ${
                                        cmd.chocolat?.image
                                            ? `<img src="/images/choco_seul/${cmd.chocolat.image}"
                                                alt="${cmd.chocolat.nom}"
                                                class="max-h-14 w-auto object-contain">`
                                            : `<div class="w-14 h-14 bg-[var(--choco)] rounded-full"></div>`
                                    }
                                </div>

                                <!-- TEXTE -->
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="bg-[var(--caramel)] text-xs font-bold px-3 py-1 rounded-full w-fit text-[var(--choco-brown)]">
                                            ${cmd.numero_commande}
                                        </span>

                                        ${cmd.allergie ? `
                                            <span class="bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-full">
                                                Allergie : ${cmd.allergie}
                                            </span>
                                        ` : ''}
                                    </div>

                                    <p class="text-lg font-kavoon text-[var(--choco-brown)] leading-tight">
                                        ${cmd.chocolat.nom}
                                    </p>

                                    <p class="text-sm text-[var(--choco-brown)] font-medium">
                                        Nom de commande :
                                        <span class="font-kavoon">${cmd.visiteur.nom} ${cmd.visiteur.prenom}</span>
                                    </p>
                                </div>
                            </div>

                            <!-- DROITE : ACTIONS -->
                            <div class="flex gap-3 ml-4 shrink-0">
                                        <!-- Bouton Finaliser ou Suivant -->
                                        <button onclick="${estDernierPoste ? 'finaliserCommande(' + cmd.id + ')' : 'prochainPoste(' + cmd.id + ')'}"
                                                class="flex items-center justify-center ${estDernierPoste ? 'w-24 px-2' : 'w-12'} bg-[var(--green)] hover:brightness-95 rounded-tl-[2.25rem] rounded-tr-[2.25rem] rounded-bl-3xl rounded-br-3xl transition text-xs font-kavoon text-[var(--choco)]"
                                                aria-label="${estDernierPoste ? 'Finaliser' : 'Suivant'}">
                                            ${estDernierPoste ? 'Finaliser' :
                                                '<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[var(--choco-brown)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>'
                                            }
                                        </button>

                                        <!-- Bouton Supprimer -->
                                        <button onclick="supprimerCommande(${cmd.id})" class="w-12 h-12 flex items-center justify-center bg-[var(--green)] rounded-tl-[2.25rem] rounded-tr-[2.25rem] rounded-bl-3xl rounded-br-3xl hover:brightness-95 transition" aria-label="Supprimer">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-6 h-6 text-[var(--choco-brown)]"
                                                fill="none"
                                                viewBox="0 0 20 20"
                                                stroke="currentColor"
                                                stroke-width="2">
                                                <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                                            </svg>
                                        </button>

                            </div>
                        </div>
                        `;

                        }).join('');
                    }

                    function mettreAJourAffichage() {
                        searchCommande = document
                            .getElementById('searchCommandeInput')
                            .value
                            .toLowerCase();

                        const activeEtape = document.querySelector('.etape-item.active');
                        if (activeEtape) {
                            afficherCommandes(activeEtape.dataset.posteId);
                            mettreAJourStats(activeEtape.dataset.posteId);
                        }
                    }

                    // Nouvelle fonction pour finaliser
                    function finaliserCommande(commandeId) {
                        showCustomConfirm('Finaliser la commande',
                            'Confirmez-vous la finalisation et la livraison au client ?',
                            () => {
                                fetch(`/commande/${commandeId}/finaliser`, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                        'Content-Type': 'application/json'
                                    }
                                }).then(r => r.json()).then(data => {
                                    if (data.success) {
                                        showSuccessPopup(data.message);
                                        rafraichirDonnees();
                                    } else {
                                        alert(data.message);
                                    }
                                });
                            }
                        );
                    }

                    function showCustomConfirm(titre, message, onConfirm) {
                        const popup = document.createElement('div');
                        popup.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                        popup.innerHTML = `
                            <div class="bg-white rounded-3xl p-8 max-w-md w-full mx-4 shadow-2xl">
                                <h3 class="text-2xl font-kavoon text-center text-[var(--choco-brown)] mb-4 font-bold">${titre}</h3>
                                <p class="text-center text-[var(--choco-brown)] mb-8 font-medium">${message}</p>
                                <div class="flex gap-4">
                                    <button id="cancelBtn" class="flex-1 bg-[var(--choco-brown)] hover:bg-[var(--choco)] text-[var(--choco-beige)] py-3 px-6 rounded-2xl font-kavoon transition-all duration-200">
                                        Annuler
                                    </button>
                                    <button id="confirmBtn" class="flex-1 bg-[var(--caramel)] hover:bg-green-600 text-[var(--choco-beige)] py-3 px-6 rounded-2xl font-kavoon transition-all duration-200">
                                        Confirmer
                                    </button>
                                </div>
                            </div>
                        `;
                        document.body.appendChild(popup);

                        // ✅ Écouteurs d'événements (solution propre !)
                        document.getElementById('cancelBtn').onclick = () => popup.remove();
                        document.getElementById('confirmBtn').onclick = () => {
                            popup.remove();
                            onConfirm(); // Appel direct de la fonction
                        };
                    }


                    // Fonction pour afficher le popup de succès
                    function showSuccessPopup(message) {
                        // Créer le popup
                        const popup = document.createElement('div');
                        popup.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                        popup.innerHTML = `
                            <div class="bg-white rounded-3xl p-8 max-w-md w-full mx-4 shadow-2xl animate-pulse [animation-duration:3s]">
                                <div class="w-20 h-20  bg-[var(--green)]  rounded-2xl flex items-center justify-center mx-auto mb-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-[var(--choco-beige)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-kavoon text-center text-[var(--choco-brown)] mb-4 font-bold">Commande Finalisée !</h3>
                                <p class="text-center text-[var(--choco-brown)] mb-8 font-medium">${message}</p>
                                <button onclick="this.parentElement.parentElement.remove()"
                                        class="w-full  bg-[var(--caramel-dark)]  text-[var(--choco-beige)] py-3 px-6 rounded-2xl font-kavoon text-lg transition-all duration-200 transform hover:scale-[1.02]">
                                    Fermer
                                </button>
                            </div>
                        `;

                        document.body.appendChild(popup);

                        // Auto-fermeture après 5 secondes
                        setTimeout(() => {
                            if (popup.parentElement) {
                                popup.remove();
                            }
                        }, 5000);
                    }

                    function supprimerCommande(commandeId) {
                        showCustomConfirm('Supprimer la commande',
                            'Cette action est irréversible. Confirmez-vous la suppression ?',
                            () => {
                                fetch(`/commande/${commandeId}/supprimer`, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                        'Content-Type': 'application/json'
                                    }
                                }).then(r => r.json()).then(data => {
                                    if (data.success) {
                                        rafraichirDonnees();
                                    }
                                });
                            }
                        );
                    }

                    function prochainPoste(commandeId) {
                        fetch(`/commande/${commandeId}/prochainPoste`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            }
                        }).then(r => r.json()).then(data => {
                            if (data.success) {
                                rafraichirDonnees();
                            } else {
                                alert(data.message);
                            }
                        });
                    }

                    function rafraichirDonnees() {
                        fetch('/api/commandes')
                            .then(r => r.json())
                            .then(data => {
                                // Mettre à jour commandesData globalement
                                Object.assign(commandesData, data);

                                // Rafraîchir l'affichage du poste actif
                                const activeEtape = document.querySelector('.etape-item.active');
                                if (activeEtape) {
                                    afficherCommandes(activeEtape.dataset.posteId);
                                    mettreAJourStats(activeEtape.dataset.posteId);
                                    mettreAJourFiltreAffichage();
                                }
                            })
                            .catch(err => console.error('Erreur rafraîchissement:', err));
                    }
                    function mettreAJourStats(posteId) {
                        const poste = commandesData.find(p => p.id == posteId);

                        if (poste) {
                            const nbCmd = poste.commandes.length;
                            const tempsMoyen = poste.commandes.length > 0
                                ? (poste.commandes.reduce((acc, cmd) => acc + (cmd.temps_moyen || 0), 0) / nbCmd).toFixed(2)
                                : '0.00';

                            document.getElementById('etapeNameStats').textContent = poste.nom;
                            document.getElementById('etapeNameStats2').textContent = poste.nom;
                            document.getElementById('nbCommandes').textContent = nbCmd;
                            document.getElementById('tempsMoyen').textContent = tempsMoyen;
                        }
                    }
                    document.addEventListener('DOMContentLoaded', function() {
                        document.querySelectorAll('.etape-item').forEach(item => {
                            item.addEventListener('click', function() {
                                document.querySelectorAll('.etape-item').forEach(el => el.classList.remove('active', 'bg-[var(--caramel-dark)]', 'text-[var(--choco-beige)]'));
                                document.querySelectorAll('.etape-item').forEach(el => el.classList.add('opacity-80', 'bg-[var(--choco-brown)]', 'text-[var(--choco-beige)]'));

                                this.classList.add('active', 'bg-[var(--caramel-dark)]', 'text-[var(--choco-beige)]');
                                this.classList.remove('opacity-80', 'bg-[var(--choco-brown)]');

                                afficherCommandes(this.dataset.posteId);
                                mettreAJourStats(this.dataset.posteId);
                            });
                        });

                        const firstEtape = document.querySelector('.etape-item');
                        if (firstEtape) {
                            firstEtape.click();
                        }

                        mettreAJourFiltreAffichage();

                        // Rafraîchir les données toutes les 2 secondes
                        refreshInterval = setInterval(rafraichirDonnees, 2000);
                    });

                    // Arrêter le refresh si l'utilisateur quitte la page
                    window.addEventListener('beforeunload', () => {
                        clearInterval(refreshInterval);
                    });

                    function ouvrirFiltrePopup() {

                        // Récupérer tous les chocolats uniques
                        const chocolats = [...new Set(
                            commandesData.flatMap(p =>
                                p.commandes.map(c => c.chocolat.nom)
                            )
                        )];

                        const popup = document.createElement('div');
                        popup.className = 'fixed inset-0 bg-black/50 flex items-center justify-center z-50';

                        popup.innerHTML = `
                            <div class="bg-white rounded-3xl p-6 w-full max-w-sm">
                                <h3 class="text-xl font-kavoon text-center text-[var(--choco-brown)] mb-4">
                                    Filtrer par chocolat
                                </h3>

                                <select id="filtreChocolatSelect"
                                        class="w-full p-3 rounded-xl border mb-6">
                                    <option value="">Tous les chocolats</option>
                                    ${chocolats.map(c => `
                                        <option value="${c}" ${c === filtreChocolat ? 'selected' : ''}>
                                            ${c}
                                        </option>
                                    `).join('')}
                                </select>

                                <div class="flex gap-3">
                                    <button class="flex-1 bg-[var(--choco-brown)] text-[var(--choco-beige)]
                                                py-3 rounded-xl font-kavoon"
                                            onclick="this.closest('.fixed').remove()">
                                        Annuler
                                    </button>

                                    <button class="flex-1 bg-[var(--caramel)] text-[var(--choco-beige)]
                                                py-3 rounded-xl font-kavoon"
                                            onclick="appliquerFiltreChocolat()">
                                        Appliquer
                                    </button>
                                </div>
                            </div>
                        `;

                        document.body.appendChild(popup);
                    }
                    function appliquerFiltreChocolat() {
                        filtreChocolat = document
                            .getElementById('filtreChocolatSelect')
                            .value;

                        mettreAJourFiltreAffichage();

                        document.querySelector('.fixed').remove();

                        const activeEtape = document.querySelector('.etape-item.active');
                        if (activeEtape) {
                            afficherCommandes(activeEtape.dataset.posteId);
                            mettreAJourStats(activeEtape.dataset.posteId);
                            mettreAJourFiltreAffichage();
                        }
                    }

                    function mettreAJourFiltreAffichage() {
                        const filtreText = document.getElementById('filtreActifText');

                        if (!filtreChocolat) {
                            filtreText.textContent = 'Aucun filtre actif';
                        } else {
                            filtreText.textContent = `Filtre actif : ${filtreChocolat}`;
                        }
                    }

                </script>

                </aside>

            </div>

            {{-- COLONNE DROITE --}}
            <div class="flex flex-col gap-6 items-stretch flex-1">
                <div class="bg-[var(--choco-beige)] rounded-3xl p-6 flex-1">

                    {{-- SEARCH / ACTIONS --}}
                    <div class="flex flex-col lg:flex-row gap-4 mb-4">
                        <div class="flex items-center gap-4 bg-[var(--green)] px-6 py-3 rounded-full flex-1
                                    border-2 border-[var(--choco-brown)]">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6 text-[var(--choco-brown)] flex-shrink-0"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-4.35-4.35m1.85-5.4a7.25 7.25 0 11-14.5 0 7.25 7.25 0 0114.5 0z" />
                            </svg>

                            <input
                                type="text"
                                id="searchCommandeInput"
                                placeholder="Rechercher par nom, prénom ou numéro de commande"
                                class="bg-transparent w-full text-[15px] font-medium
                                    text-[var(--choco-brown)]
                                    placeholder:text-[var(--choco-brown)] placeholder:opacity-80
                                    border-0 outline-none focus:ring-0 focus:outline-none"
                                onkeyup="mettreAJourAffichage()"
                            />
                        </div>
                        <div class="flex gap-3 shrink-0">
                            <button onclick="ouvrirFiltrePopup()"
                                    class="bg-white text-[var(--choco-brown)] px-4 py-2 rounded-full
                                        flex items-center gap-2 border-2 border-[var(--choco-brown)]">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor" class="size-5">
                                    <path fill-rule="evenodd"
                                        d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 0 1 .628.74v2.288a2.25 2.25 0 0 1-.659 1.59l-4.682 4.683a2.25 2.25 0 0 0-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 0 1 8 18.25v-5.757a2.25 2.25 0 0 0-.659-1.591L2.659 6.22A2.25 2.25 0 0 1 2 4.629V2.34a.75.75 0 0 1 .628-.74Z"
                                        clip-rule="evenodd" />
                                </svg>
                                Filtrer
                            </button>

                            @auth
                            @if(auth()->user()->role->nom === 'superviseur')
                                <button onclick="ouvrirPopupPanne()"
                                        class="bg-[var(--caramel-dark)] px-4 py-2 rounded-full
                                            flex items-center gap-2 text-white">
                                    Signaler une panne
                                </button>
                            @endif
                            @endauth
                        </div>

                    </div>

                    {{-- STATS --}}
                    <div class="text-md text-[var(--choco-brown)] mb-4 font-medium">
                        <p id="filtreActifText" class="mb-1 italic font-kavoon">Aucun filtre actif</p>
                        <p>Temps moyen de l'étape "<span id="etapeNameStats" class="font-kavoon">Non traitées</span>" : <span id="tempsMoyen">--</span></p>
                        <p>Nombre de commandes pour l'étape "<span id="etapeNameStats2" class="font-kavoon">Non traitées</span>" : <span id="nbCommandes">--</span></p>
                    </div>

                    {{-- COMMANDES --}}
                    <div class="space-y-4 overflow-y-auto max-h-[420px] pr-2">
                    </div>

                </div>
            </main>
            </div>
        </div>
    </div>
</div>

<script>
let panneActive = false;
let popupPanne = null;

function ouvrirPopupPanne() {
    const popup = document.createElement('div');
    popup.className = 'fixed inset-0 bg-black/50 flex items-center justify-center z-[9999]';

    popup.innerHTML = `
        <div class="bg-white rounded-3xl p-8 max-w-md w-full mx-4 shadow-2xl">

            <!-- ICONE -->
            <div class="w-20 h-20 bg-red-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-12 h-12 text-white"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 9v4m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                </svg>
            </div>

            <!-- TITRE -->
            <h3 class="text-2xl font-kavoon text-center text-[var(--choco-brown)] mb-4">
                Signaler une panne
            </h3>

            <!-- TEXTE -->
            <p class="text-center text-[var(--choco-brown)] font-medium mb-4">
                Décris clairement le problème rencontré.
            </p>

            <!-- INPUT -->
            <textarea id="messagePanne"
                      rows="4"
                      placeholder="Ex : Machine HS, arrêt production poste 3…"
                      class="w-full p-4 rounded-2xl border border-[var(--choco)]
                             text-[var(--choco-brown)]
                             focus:outline-none focus:ring-2 focus:ring-[var(--caramel)]
                             mb-6 resize-none"></textarea>

            <!-- ACTIONS -->
            <div class="flex gap-4">
                <button id="annulerPanne"
                        class="flex-1 bg-[var(--choco-brown)]
                               text-[var(--choco-beige)]
                               py-3 rounded-2xl font-kavoon">
                    Annuler
                </button>

                <button id="confirmerPanne"
                        class="flex-1 bg-[var(--caramel-dark)]
                               text-[var(--choco-beige)]
                               py-3 rounded-2xl font-kavoon hover:brightness-95 transition">
                    Signaler
                </button>
            </div>

        </div>
    `;

    document.body.appendChild(popup);
    document.body.classList.add('overflow-hidden');

    // Annuler
    popup.querySelector('#annulerPanne').onclick = () => {
        popup.remove();
        document.body.classList.remove('overflow-hidden');
    };

    // Confirmer
    popup.querySelector('#confirmerPanne').onclick = () => {
        const message = popup.querySelector('#messagePanne').value.trim();

        if (!message) {
            popup.querySelector('#messagePanne').focus();
            return;
        }

        fetch('/alerte/panne', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ message })
        })
        .then(r => r.json())
        .then(data => {
            if (!data.success) {
                alert(data.message || 'Impossible de signaler la panne');
            } else {
                popup.remove();
                document.body.classList.remove('overflow-hidden');
                verifierPanne(); // synchro immédiate
            }
        });
    };
}


// Vérifie l'état serveur
function verifierPanne() {
    fetch('/api/alerte-active')
        .then(r => r.json())
        .then(data => {

            // panne détectée
            if (data.active && !panneActive) {
                panneActive = true;
                afficherPopupPanne(data.alerte);
            }

            // panne levée
            if (!data.active && panneActive) {
                panneActive = false;
                retirerPopupPanne();
            }
        });
}


// Affiche le popup UNE SEULE FOIS
function afficherPopupPanne(alerte) {
    if (popupPanne) return;

    popupPanne = document.createElement('div');
    popupPanne.className = 'fixed inset-0 bg-black/50 flex items-center justify-center z-[9999]';

    popupPanne.innerHTML = `
        <div class="bg-white rounded-3xl p-8 max-w-md w-full mx-4 shadow-2xl text-center">

            <!-- ICONE -->
            <div class="w-20 h-20 bg-red-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-12 h-12 text-white"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 9v4m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                </svg>
            </div>

            <!-- TITRE -->
            <h2 class="text-2xl font-kavoon text-[var(--choco-brown)] mb-3">
                Panne en cours
            </h2>

            <!-- MESSAGE -->
            <p class="text-[var(--choco-brown)] font-medium mb-8">
                ${alerte.message}
            </p>

            <!-- ACTIONS -->
            ${
                isSuperviseur()
                ? `
                    <button onclick="leverPanne()"
                            class="w-full bg-[var(--green)]
                                   text-[var(--choco-brown)]
                                   py-3 px-6 rounded-2xl
                                   font-kavoon text-lg
                                   transition-all duration-200
                                   hover:brightness-95">
                        Lever la panne
                    </button>
                `
                : `
                    <p class="italic text-sm text-[var(--choco-brown)] opacity-70">
                        En attente d’un superviseur…
                    </p>
                `
            }

        </div>
    `;

    document.body.appendChild(popupPanne);
    document.body.classList.add('overflow-hidden');
}


// Retire le popup
function retirerPopupPanne() {
    if (popupPanne) popupPanne.remove();
    popupPanne = null;
    document.body.classList.remove('overflow-hidden');
}

// Lever la panne = ACTION SERVEUR
function leverPanne() {
    fetch('/alerte/panne/resoudre', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(() => {
        // 🔥 on force un refresh immédiat
        verifierPanne();
    });
}

// Rôle
function isSuperviseur() {
    return @json(auth()->check() && auth()->user()->role->nom === 'superviseur');
}

// Polling
setInterval(verifierPanne, 2000);
verifierPanne();
</script>



@endsection
