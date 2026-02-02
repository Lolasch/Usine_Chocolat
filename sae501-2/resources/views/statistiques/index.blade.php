@extends('layouts.app')

@section('title', 'Statistiques | L\'Usine Chocolat 2026')


@section('content')
<div class="bg-[var(--caramel)] min-h-screen py-8">

    <div
            class="
                mx-auto
                px-4
                sm:px-6
                lg:px-[8%]
                xl:px-[12%]
                2xl:px-[15%]
            "
        >

        <!-- TITRE -->
        <h1 class="font-kavoon text-3xl text-[var(--choco-brown)] mb-4">
            Statistiques
        </h1>

        <!-- KPI -->
        <div class="p-4 mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                <!-- KPI 1 -->
                <div class="flex items-center justify-center gap-4 bg-[var(--green)] rounded-full px-6 py-4 shadow-lg">
                    <span class="font-kavoon text-2xl text-[var(--choco-brown)]">1.</span>
                    <div class="text-center">
                        <p class="font-bold text-md text-[var(--choco-brown)]">Lead Time</p>
                        <p class="font-medium font-kavoon text-[var(--choco)] text-xl">35 minutes</p>
                    </div>
                </div>

                <!-- KPI 2 -->
                <div class="flex items-center justify-center gap-4 bg-[var(--green)] rounded-full px-6 py-4 shadow-lg">
                    <span class="font-kavoon text-2xl text-[var(--choco-brown)]">2.</span>
                    <div class="text-center">
                        <p class="font-bold text-md text-[var(--choco-brown)]">Non conformités</p>
                        <p class="font-medium font-kavoon text-[var(--choco)] text-xl">
                            {{ $nbNonConformes }} pièce{{ $nbNonConformes > 1 ? 's' : '' }}
                        </p>
                    </div>
                </div>

                <!-- KPI 3 -->
                <div class="flex items-center justify-center gap-4 bg-[var(--green)] rounded-full px-6 py-4 shadow-lg">
                    <span class="font-kavoon text-2xl text-[var(--choco-brown)]">3.</span>
                    <div class="text-center">
                        <p class="font-bold text-md text-[var(--choco-brown)]">Taux rotation des stocks</p>
                        <p class="font-medium font-kavoon text-[var(--choco)] text-xl">17,3 %</p>
                    </div>
                </div>

            </div>
        </div>


        <!-- ZONE GRAPHIQUES -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- LEAD TIME -->
            <div class="lg:col-span-3 bg-[var(--choco-beige)] rounded-2xl shadow-lg p-4">
                <h2 class="font-kavoon text-lg text-[var(--choco-brown)] mb-3">
                    Lead-time par étape
                </h2>

                <div class="h-56 flex items-end gap-6 px-4">
                    <div class="w-10 bg-[var(--choco)] h-1/4 rounded-t-lg"></div>
                    <div class="w-10 bg-[var(--caramel-dark)] h-2/4 rounded-t-lg"></div>
                    <div class="w-10 bg-[var(--choco)] h-3/4 rounded-t-lg"></div>
                    <div class="w-10 bg-[var(--caramel-dark)] h-1/3 rounded-t-lg"></div>
                    <div class="w-10 bg-[var(--choco)] h-2/3 rounded-t-lg"></div>
                </div>

                <div class="flex justify-between text-xs text-[var(--choco-brown)] mt-2 px-4">
                    <span>Étape 1</span>
                    <span>Étape 2</span>
                    <span>Étape 3</span>
                    <span>Étape 4</span>
                    <span>Étape 5</span>
                </div>
            </div>

            <!-- QUALITÉ / CONFORMITÉ -->
            <div class="lg:col-span-1 bg-[var(--choco-beige)] rounded-2xl shadow-lg p-5 flex flex-col justify-between">

                <h2 class="font-kavoon text-lg text-[var(--choco-brown)] mb-4">
                    Qualité / Conformité
                </h2>

                <!-- TAUX GLOBAL -->
                <div class="text-center mb-4">
                    <p class="text-sm text-[var(--choco-brown)]">Taux de conformité</p>
                    <p class="font-kavoon text-4xl text-[var(--caramel-dark)]">
                        {{ $tauxConformite }} %
                    </p>
                </div>

                <!-- DÉTAILS -->
                <div class="space-y-3 text-sm">

                    <div class="flex justify-between items-center bg-[var(--choco)] rounded-xl px-4 py-3">
                        <span class="font-medium text-[var(--choco-beige)]">
                            Commandes conformes
                        </span>
                        <span class="font-bold text-[var(--green)] text-lg">
                            {{ $commandesConformes }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center bg-[var(--choco)] rounded-xl px-4 py-3">
                        <span class="font-medium text-[var(--choco-beige)]">
                            Commandes non conformes
                        </span>
                        <span class="font-bold text-[var(--caramel)] text-lg">
                            {{ $commandesNonConformes }}
                        </span>
                    </div>

                </div>

            </div>



            <!-- STOCKS CRITIQUES -->
            <div class="lg:col-span-2 bg-[var(--choco-beige)] rounded-2xl shadow-lg p-4">
                <h2 class="font-kavoon text-lg text-[var(--choco-brown)] mb-3">
                    Stocks critiques
                </h2>

                <div class="space-y-3 text-sm">

                    @forelse($stocks as $stock)

                        <div class="flex justify-between items-center">

                            <!-- Nom du stock -->
                            <span class="font-medium text-[var(--choco-brown)]">
                                {{ $stock->nom }}
                            </span>

                            <!-- État -->
                            @if($stock->quantite <= 0)
                                <span class="bg-red-600 text-white px-3 py-1 rounded-full text-xs font-bold">
                                    Critique
                                </span>

                            @elseif($stock->quantite <= $stock->seuil_min)
                                <span class="bg-[var(--caramel-dark)] text-white px-3 py-1 rounded-full text-xs font-bold">
                                    Attention
                                </span>

                            @else
                                <span class="bg-[var(--green)] text-[var(--choco-brown)] px-3 py-1 rounded-full text-xs font-bold">
                                    OK
                                </span>
                            @endif

                        </div>

                    @empty
                        <p class="text-center text-[var(--choco-brown)] text-sm italic">
                            Aucun stock enregistré
                        </p>
                    @endforelse

                </div>
            </div>


        </div>

        <!-- BOUTON -->
        <div class="flex justify-center mt-6">
            <button class="bg-[var(--choco-brown)] text-[var(--choco-beige)] px-6 py-2 rounded-full shadow hover-caramel transition">
                Récupérer les données sous forme de tableau
            </button>
        </div>
    </div>
</div>


@endsection
