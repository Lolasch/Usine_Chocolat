@extends('layouts.app')

@section('title', 'Statistiques | L\'Usine Chocolat 2026')

@section('content')
    <!-- Conteneur principal -->
    <div class="bg-[var(--caramel)] min-h-screen py-8">

        <div class="mx-auto px-4 sm:px-6 lg:px-[8%] xl:px-[12%] 2xl:px-[15%]">

            <h1 class="font-kavoon text-3xl text-[var(--choco-brown)] mb-4">
                Statistiques
            </h1>

            <div class="p-4 mb-6">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                    <!-- Temps moyen d'une commande -->
                    <div class="flex items-center justify-center gap-4 bg-[var(--green)] rounded-full px-6 py-4 shadow-lg">
                        <span class="font-kavoon text-2xl text-[var(--choco-brown)]">1.</span>

                        <div class="text-center">
                            <p class="font-bold text-md text-[var(--choco-brown)]">
                                Temps moyen d'une commande
                            </p>

                            <p class="font-kavoon text-2xl text-[var(--choco)]">
                                {{ $tempsMoyenCommande }} min
                            </p>
                        </div>
                    </div>

                    <!-- Nombre de non-conformités -->
                    <div class="flex items-center justify-center gap-4 bg-[var(--green)] rounded-full px-6 py-4 shadow-lg">
                        <span class="font-kavoon text-2xl text-[var(--choco-brown)]">2.</span>
                        <div class="text-center">
                            <p class="font-bold text-md text-[var(--choco-brown)]">Non conformités</p>
                            <p class="font-medium font-kavoon text-[var(--choco)] text-xl">
                                {{ $nbNonConformes }} pièce{{ $nbNonConformes > 1 ? 's' : '' }}
                            </p>
                        </div>
                    </div>

                    <!-- Taux de rotation des stocks -->
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


        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- TEMPS MOYEN  -->
            @php
                $maxLeadTime = max($leadTimesParPoste->pluck('lead_time_moyen')->toArray() ?: [1]);

                $colors = [
                    1 => 'bg-[var(--caramel-dark)]',
                    2 => 'bg-[var(--choco)]',
                    3 => 'bg-[var(--green)]',
                    4 => 'bg-[var(--caramel)]',
                    5 => 'bg-[var(--choco-brown)]',
                    6 => 'bg-[var(--caramel-dark)]',
                    7 => 'bg-[var(--choco)]',
                    8 => 'bg-[var(--green)]',
                    9 => 'bg-[var(--caramel)]',
                    10 => 'bg-[var(--choco-brown)]',
                ];
            @endphp

            <div class="lg:col-span-2 bg-[var(--choco-beige)] rounded-2xl shadow-lg p-6">
                <h2 class="font-kavoon text-lg text-[var(--choco-brown)] mb-4 text-start">
                    Temps moyen par poste
                </h2>

                <div class="h-64 flex items-end justify-between gap-8 px-6">
                    @foreach($leadTimesParPoste as $poste)
                        @php
                            $height = $maxLeadTime > 0
                                ? ($poste->lead_time_moyen / $maxLeadTime) * 100
                                : 0;

                            $color = $colors[$poste->id] ?? 'bg-[var(--choco)]';
                        @endphp

                        <div class="flex flex-col items-center justify-end w-full">

                            <div class="w-10 h-44 bg-[var(--choco)]/20 flex items-end">
                                <div class="w-full {{ $color }} rounded-md transition-all duration-500"
                                    style="height: {{ max($height, 3) }}%">
                                </div>
                            </div>

                            <span class="text-sm font-semibold text-[var(--choco-brown)] mt-2">
                                {{ round($poste->lead_time_moyen) }} min
                            </span>

                            <span class="text-xs text-center text-[var(--choco-brown)] mt-1">
                                {{ $poste->nom }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="lg:col-span-1 bg-[var(--choco-beige)] rounded-2xl shadow-lg p-6 flex flex-col justify-between">

                <div>
                    <h2 class="font-kavoon text-lg text-[var(--choco-brown)] text-start mb-1">
                        Avancement des commandes
                    </h2>
                    <p class="text-xs text-center text-[var(--choco-brown)] mb-4">
                        Suivi global de la production
                    </p>
                </div>

                <!-- POURCENTAGE CENTRAL -->
                <div class="text-center mb-5">
                    <p class="font-kavoon text-4xl text-[var(--green)]">
                        {{ round(($commandesLivrees / max($totalCommandes,1)) * 100) }}%
                    </p>
                    <p class="text-xs text-[var(--choco-brown)]">
                        commandes livrées
                    </p>
                </div>


                <!-- BARRE PROGRESSION -->
                <div class="w-full h-5 bg-[var(--choco)]/20 rounded-full overflow-hidden flex mb-4">
                    <div
                        class="bg-[var(--caramel-dark)]"
                        style="width: {{ round((($totalCommandes - $commandesLivrees) / max($totalCommandes,1)) * 100) }}%">
                    </div>

                    <div
                        class="bg-[var(--green)]"
                        style="width: {{ round(($commandesLivrees / max($totalCommandes,1)) * 100) }}%">
                    </div>
                </div>

                <div class="flex justify-center gap-6 text-xs text-[var(--choco-brown)] mb-4">
                    <div class="flex items-center gap-1">
                        <span class="w-3 h-3 rounded-full bg-[var(--caramel-dark)]"></span>
                        En cours
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="w-3 h-3 rounded-full bg-[var(--green)]"></span>
                        Livrées
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 text-center text-sm font-semibold">
                    <div class="bg-[var(--choco)]/10 rounded-xl py-3">
                        <p class="text-[var(--caramel-dark)] text-lg">
                            {{ $totalCommandes - $commandesLivrees }}
                        </p>
                        <p class="text-xs text-[var(--choco-brown)]">
                            En cours
                        </p>
                    </div>

                    <div class="bg-[var(--choco)]/10 rounded-xl py-3">
                        <p class="text-[var(--green)] text-lg">
                            {{ $commandesLivrees }}
                        </p>
                        <p class="text-xs text-[var(--choco-brown)]">
                            Livrées
                        </p>
                    </div>
                </div>

            </div>


            <!-- CONFORMITÉ -->
            <div class="lg:col-span-1 bg-[var(--choco-beige)] rounded-2xl shadow-lg p-5 flex flex-col justify-between">

                <h2 class="font-kavoon text-lg text-[var(--choco-brown)] mb-4">
                    Qualité / Conformité
                </h2>

                <!-- TAUX GLOBAL -->
                <div class="text-center mb-4">
                    <p class="text-md font-bold text-[var(--choco-brown)] pb-4">Taux de conformité</p>

                    <div class="flex justify-center mb-4">
                        <div class="w-36 h-36 relative">
                            <canvas id="conformiteChart"></canvas>

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

    if (ctx) {
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
    }

    const livraisonCtx = document.getElementById('livraisonChart');
    if (livraisonCtx) {
        new Chart(livraisonCtx, {
            type: 'doughnut',
            data: {
                labels: ['Livrées', 'Non livrées'],
                datasets: [{
                    data: [
                        {{ $commandesLivrees }},
                        {{ $totalCommandes - $commandesLivrees }}
                    ],
                    backgroundColor: [
                        '#6BCF9B', // vert
                        '#E76F51'  // rouge
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '70%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => `${ctx.label} : ${ctx.raw}`
                        }
                    }
                }
            }
        });
    }

});
</script>




@endsection
