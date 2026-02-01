@extends('layouts.app')

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
        <div class="bg-[var(--choco-beige)] rounded-2xl shadow-lg p-4 grid grid-cols-3 gap-4 mb-6">

            <div class="bg-[var(--green)] rounded-full px-6 py-4 shadow text-center">
                <span class="font-kavoon text-lg text-[var(--choco-brown)]">1.</span>
                <p class="font-semibold">Lead Time</p>
                <p class="font-bold text-[var(--choco)]">35 minutes</p>
            </div>

            <div class="bg-[var(--green)] rounded-full px-6 py-4 shadow text-center">
                <span class="font-kavoon text-lg text-[var(--choco-brown)]">2.</span>
                <p class="font-semibold">Non conformités</p>
                <p class="font-bold text-[var(--choco)]">7 pièces</p>
            </div>

            <div class="bg-[var(--green)] rounded-full px-6 py-4 shadow text-center">
                <span class="font-kavoon text-lg text-[var(--choco-brown)]">3.</span>
                <p class="font-semibold">Taux rotation des stocks</p>
                <p class="font-bold text-[var(--choco)]">17,3 %</p>
            </div>

        </div>

        <!-- ZONE GRAPHIQUES -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- LEAD TIME -->
            <div class="col-span-2 bg-[var(--choco-beige)] rounded-2xl shadow-lg p-4">
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

            <!-- NON CONFORMITÉS -->
            <div class="bg-[var(--choco-beige)] rounded-2xl shadow-lg p-4">
                <h2 class="font-kavoon text-lg text-[var(--choco-brown)] mb-3">
                    Non-conformités
                </h2>

                <div class="flex items-center gap-4">
                    <div class="w-24 h-24 rounded-full border-8 border-[var(--green)] border-r-[var(--choco)]"></div>

                    <div class="space-y-2 text-sm">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-[var(--green)] rounded-full"></span> Qualité
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-[var(--choco)] rounded-full"></span> Poids
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-[var(--caramel-dark)] rounded-full"></span> Nombre
                        </div>
                    </div>
                </div>
            </div>

            <!-- STOCKS CRITIQUES -->
            <div class="col-span-3 bg-[var(--choco-beige)] rounded-2xl shadow-lg p-4">
                <h2 class="font-kavoon text-lg text-[var(--choco-brown)] mb-3">
                    Stocks critiques
                </h2>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between items-center">
                        <span>Chocolat lait noisette</span>
                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs">Critique</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span>Chocolat noir nature</span>
                        <span class="bg-[var(--caramel)] text-white px-3 py-1 rounded-full text-xs">Attention</span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span>Chocolat noir amandes</span>
                        <span class="bg-[var(--green)] text-[var(--choco-brown)] px-3 py-1 rounded-full text-xs">OK</span>
                    </div>
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
