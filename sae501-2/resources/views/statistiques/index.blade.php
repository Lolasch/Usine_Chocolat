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
                        <p class="font-medium font-kavoon text-[var(--choco)] text-xl">
                            {{ $tauxRotationStocks }} %
                        </p>
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
                    <p class="text-md font-bold text-[var(--choco-brown)] pb-4">Taux de conformité</p>
                    <!-- GRAPHIQUE CIRCULAIRE -->
                    <div class="flex justify-center mb-4">
                        <div class="w-36 h-36 relative">
                            <canvas id="conformiteChart"></canvas>

                            <!-- TEXTE AU CENTRE -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="font-kavoon text-xl text-[var(--choco-brown)]">
                                    {{ $tauxConformite }}%
                                </span>
                            </div>
                        </div>
                    </div>

                    <p class="font-kavoon text-4xl text-[var(--choco-brown)]">
                        {{ $tauxConformite }} %
                    </p>
                </div>

                <!-- DÉTAILS -->
                <div class="space-y-3 text-sm">

                    <div class="flex justify-between items-center bg-[var(--choco)] rounded-xl px-4 py-3">
                        <span class="font-medium text-[var(--green)]">
                            Commandes conformes
                        </span>
                        <span class="font-bold text-[var(--green)] text-lg">
                            {{ $commandesConformes }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center bg-[var(--choco)] rounded-xl px-4 py-3">
                        <span class="font-medium text-[var(--caramel)]">
                            Commandes non conformes
                        </span>
                        <span class="font-bold text-[var(--caramel)] text-lg">
                            {{ $commandesNonConformes }}
                        </span>
                    </div>

                </div>

            </div>



            <!-- STOCKS  -->
            <div class="lg:col-span-2 bg-[var(--choco-beige)] rounded-2xl shadow p-4">

                <h2 class="font-kavoon text-lg text-[var(--choco-brown)] mb-3">
                    Détail des stocks
                </h2>

                <div class="space-y-2 text-sm">

                    @forelse($stocks as $stock)

                        @php
                            $ratio = $stock->seuil_min > 0
                                ? min(100, round(($stock->quantite / $stock->seuil_min) * 100))
                                : 0;

                            if ($stock->quantite <= 0) {
                                $etat = 'Critique';
                                $color = 'bg-red-600';
                            } elseif ($stock->quantite <= $stock->seuil_min) {
                                $etat = 'Attention';
                                $color = 'bg-[var(--caramel-dark)]';
                            } else {
                                $etat = 'OK';
                                $color = 'bg-[var(--green)]';
                            }
                        @endphp

                        <div class="bg-white rounded-lg px-3 py-2 border-2 border-[var(--caramel)]">

                            <div class="flex justify-between items-center mb-1">
                                <span class="font-medium text-[var(--choco-brown)] truncate">
                                    {{ $stock->nom }}
                                </span>

                                <span class="{{ $color }} text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                                    {{ $etat }}
                                </span>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="text-xs text-[var(--choco-brown)] whitespace-nowrap">
                                    <span class="font-semibold">{{ $stock->quantite }}</span>
                                    /
                                    <span class="opacity-70">{{ $stock->seuil_min }}</span>
                                </div>

                                <div class="flex-1 h-1.5 bg-[var(--choco)]/20 rounded-full overflow-hidden">
                                    <div class="h-full {{ $color }}" style="width: {{ $ratio }}%"></div>
                                </div>
                            </div>

                        </div>

                    @empty
                        <p class="text-center text-[var(--choco-brown)] italic text-sm">
                            Aucun stock enregistré
                        </p>
                    @endforelse

                </div>
            </div>


        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const ctx = document.getElementById('conformiteChart');

    if (!ctx) return;

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Conformes', 'Non conformes'],
            datasets: [{
                data: [
                    {{ $commandesConformes }},
                    {{ $commandesNonConformes }}
                ],
                backgroundColor: [
                    'rgb(110, 226, 182)',
                    'rgb(238, 131, 23)'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            cutout: '70%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#3b2a20',
                    titleColor: '#f5f0e6',
                    bodyColor: '#f5f0e6'
                }
            }
        }
    });

});
</script>



@endsection
