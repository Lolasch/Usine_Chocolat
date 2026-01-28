@extends('layouts.app')

@section('content')

<div class="bg-[var(--choco-gold)] font-kavoon">
    <div class="max-w-[1400px] mx-auto p-6">

        {{-- HEADER --}}
        <div class="bg-[var(--choco)] rounded-full px-6 py-4 text-white mb-6">
            <div class="grid grid-cols-1 gap-4 items-center sm:grid-cols-3 sm:gap-0 sm:text-center">

                <div class="flex items-center gap-4 sm:justify-start">
                    <div class="w-10 h-10">
                        <img src="/images/autre/seul_vert.svg" alt="Avatar" class="w-full h-full">
                    </div>
                    <span class="text-xl whitespace-nowrap">Objectif :</span>
                </div>

                <div class="flex flex-col items-center gap-2">
                    <span class="text-sm">62 / 100 commandes</span>
                    <div class="w-full max-w-xs h-2 bg-[var(--green)] rounded-full overflow-hidden">
                        <div class="h-full w-[62%] bg-white"></div>
                    </div>
                </div>

                <div class="flex sm:justify-end justify-start">
                    <button class="w-12 h-12 flex items-center justify-center hover:brightness-110 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                             class="w-12 h-12 text-[var(--caramel)]">
                            <path fill-rule="evenodd"
                                  d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75
                                     9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0
                                     0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5
                                     0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        {{-- TITRE --}}
        <h1 class="text-3xl text-center mb-6 text-[var(--choco-brown)]">
            Liste des commandes
        </h1>

        {{-- CONTENT --}}
        <div class="flex gap-6 items-stretch">

            {{-- COLONNE GAUCHE --}}
            <div class="w-56 flex flex-col gap-3">

                <aside class="bg-[var(--choco-brown)] text-white rounded-3xl p-4 flex-1">
                    <h2 class="text-lg mb-4">Étapes</h2>

                    <ul class="space-y-2">
                        <li class="bg-[var(--caramel-dark)] px-4 py-2 rounded-2xl flex justify-between items-center">
                            Non traitées <span>✕</span>
                        </li>
                        <li class="px-4 py-2 rounded-2xl opacity-80">Fonte</li>
                        <li class="px-4 py-2 rounded-2xl opacity-80">Moulage</li>
                        <li class="px-4 py-2 rounded-2xl opacity-80">Démoulage</li>
                        <li class="px-4 py-2 rounded-2xl opacity-80">Livraison</li>
                    </ul>
                </aside>

            </div>

            {{-- COLONNE DROITE --}}
            <main class="flex-1 flex flex-col">

                <div class="bg-[var(--choco-beige)] rounded-3xl p-6 flex-1">

                    {{-- SEARCH / ACTIONS --}}
                    <div class="flex gap-4 mb-4">
                        <div class="flex items-center gap-2 bg-[var(--green)] px-4 py-2 rounded-full flex-1">
                            🔍
                            <input type="text"
                                   placeholder="Rechercher une commande"
                                   class="bg-transparent outline-none w-full text-sm">
                        </div>

                        <button class="bg-white px-4 py-2 rounded-full flex items-center gap-2">
                            ⚙️ Filtrer
                        </button>

                        <button class="bg-[var(--caramel)] px-4 py-2 rounded-full flex items-center gap-2 text-white">
                            ⚠️ Signaler une panne
                        </button>
                    </div>

                    {{-- STATS --}}
                    <div class="text-sm text-gray-600 mb-4">
                        <p>Temps moyen de l’étape “Non traitées” : 13.51</p>
                        <p>Nombre de commandes pour l’étape “Non traitées” : 17</p>
                    </div>

                    {{-- COMMANDES --}}
                    <div class="space-y-4 overflow-y-auto max-h-[420px] pr-2">

                        <div class="bg-white rounded-3xl p-4 flex items-center justify-between shadow">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-[var(--choco)] rounded-full flex items-center justify-center text-white">
                                    🍫
                                </div>
                                <div>
                                    <div class="flex gap-2 mb-1">
                                        <span class="bg-[var(--caramel)] text-xs px-3 py-1 rounded-full">HZ0H6AZ</span>
                                        <span class="bg-[var(--caramel-dark)] text-xs px-3 py-1 rounded-full text-white">
                                            Temps dans l’étape : 15.02 minutes
                                        </span>
                                    </div>
                                    <p class="font-bold">Chocolat au lait aux amandes</p>
                                    <p class="text-sm text-gray-500">Nom de commande : Lola SCHMITT</p>
                                </div>
                            </div>
                            <span class="text-[var(--caramel-dark)] text-xl">⚠️</span>
                        </div>

                        <div class="bg-white rounded-3xl p-4 flex items-center justify-between shadow">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-[var(--choco)] rounded-full flex items-center justify-center text-white">
                                    🍫
                                </div>
                                <div>
                                    <div class="flex gap-2 mb-1">
                                        <span class="bg-[var(--caramel)] text-xs px-3 py-1 rounded-full">HZP83FU</span>
                                        <span class="bg-[var(--caramel-dark)] text-xs px-3 py-1 rounded-full text-white">
                                            Temps dans l’étape : 8.49 minutes
                                        </span>
                                    </div>
                                    <p class="font-bold">Chocolat au lait aux amandes</p>
                                    <p class="text-sm text-gray-500">Nom de commande : Lola SCHMITT</p>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </main>

        </div>
    </div>
</div>

@endsection
