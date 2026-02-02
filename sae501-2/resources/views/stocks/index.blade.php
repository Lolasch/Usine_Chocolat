@extends('layouts.app')

@section('title', 'Stocks | L\'Usine Chocolat 2026')

@section('content')
<div class="w-full h-full bg-[var(--choco-gold)] flex-1">
    <div class="max-w-7xl mx-auto px-6 py-6">

        <!-- Titre -->
        <h1 class="font-kavoon text-4xl text-[var(--choco-brown)] mb-6">
            Stocks
        </h1>

        <!-- Zone principale : stocks + graphique -->
        <div class="flex flex-col lg:flex-row gap-6 items-stretch">

            <!-- LISTE DES STOCKS -->
            <div class="lg:w-[65%] bg-[var(--choco-brown)] rounded-2xl p-5 shadow-xl">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

                    @foreach($stocks as $stock)

                        @php
                            // Calcul du pourcentage pour la barre
                            $reference = max($stock->seuil_min * 2, 1);
                            $pourcentage = min(100, ($stock->quantite / $reference) * 100);
                        @endphp

                        <div class="bg-[var(--green)] rounded-xl p-4 shadow">

                            <!-- Nom du stock -->
                            <h2 class="font-kavoon text-sm text-[var(--choco-brown)] mb-2 text-center">
                                {{ $stock->nom }}
                            </h2>

                            <!-- Image ou icône -->
                            <div class="flex justify-center mb-2">
                                @if($stock->chocolat && $stock->chocolat->image)
                                    <img
                                        src="{{ asset('images/choco_seul/' . $stock->chocolat->image) }}"
                                        alt="{{ $stock->chocolat->nom }}"
                                        class="w-12 h-auto object-contain"
                                    >
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[var(--choco-beige)]"
                                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M12 8v8m-4-4h8"/>
                                    </svg>
                                @endif
                            </div>

                            <!-- Quantité -->
                            <p class="text-center text-xs font-semibold text-[var(--choco-brown)] mb-1">
                                {{ $stock->quantite }} en stock
                            </p>

                            <!-- Barre de progression -->
                            <div class="w-full h-2 bg-[var(--choco-beige)] rounded-full overflow-hidden mb-2">
                                <div
                                    class="h-full transition-all duration-300
                                        @if($stock->quantite <= 0)
                                            bg-red-500
                                        @elseif($stock->quantite <= $stock->seuil_min)
                                            bg-orange-400
                                        @else
                                            bg-[var(--caramel)]
                                        @endif"
                                    style="width: {{ $pourcentage }}%">
                                </div>
                            </div>

                            <!-- État du stock -->
                            <div class="flex items-center justify-center gap-1 text-xs mb-2 h-4">
                                @if($stock->quantite <= 0)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600"
                                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <circle cx="12" cy="12" r="9" />
                                        <path stroke-linecap="round" d="M9 9l6 6M15 9l-6 6" />
                                    </svg>
                                    <span class="font-bold text-red-600">Rupture</span>

                                @elseif($stock->quantite <= $stock->seuil_min)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-500"
                                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M12 9v4m0 4h.01" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M10.29 3.86l-8.09 14a1 1 0 00.86 1.5h18a1 1 0 00.86-1.5l-8.09-14a1 1 0 00-1.72 0z" />
                                    </svg>
                                    <span class="font-bold text-orange-600">Faible</span>
                                @endif
                            </div>

                            <!-- Modification du seuil -->
                            <form method="POST" action="{{ route('stocks.update.seuil') }}"
                                  class="flex items-center justify-center gap-1 mb-2">
                                @csrf
                                <input type="hidden" name="stock_id" value="{{ $stock->id }}">

                                <span class="text-xs font-semibold text-[var(--choco-brown)]">
                                    Changer le seuil
                                </span>

                                <input
                                    type="number"
                                    name="seuil_min"
                                    min="0"
                                    value="{{ $stock->seuil_min }}"
                                    class="w-12 text-center text-xs rounded border border-[var(--choco)] bg-white"
                                >

                                <button type="submit"
                                        class="w-7 h-7 flex items-center justify-center bg-[var(--caramel-dark)]
                                               rounded-tl-[2.25rem] rounded-tr-[2.25rem]
                                               rounded-bl-3xl rounded-br-3xl transition">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="w-4 h-4 text-[var(--choco-beige)]"
                                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M5 13l4 4L19 7"/>
                                    </svg>
                                </button>
                            </form>

                            <!-- Ajout de stock -->
                            <form method="POST" action="{{ route('stocks.add.qr') }}"
                                  class="flex items-center justify-center gap-1">
                                @csrf
                                <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                                <input type="hidden" name="qr_code" value="STOCK_ID={{ $stock->id }}">

                                <span class="text-xs font-semibold text-[var(--choco-brown)]">
                                    Ajouter du stock
                                </span>

                                <input
                                    type="number"
                                    name="quantite"
                                    min="1"
                                    value="1"
                                    class="w-10 text-center text-xs rounded border border-[var(--choco)] bg-white"
                                >

                                <button type="submit"
                                        class="w-7 h-7 flex items-center justify-center bg-[var(--caramel-dark)]
                                               rounded-tl-[2.25rem] rounded-tr-[2.25rem]
                                               rounded-bl-3xl rounded-br-3xl transition">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="w-4 h-4 text-[var(--choco-beige)]"
                                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M12 5v14M5 12h14"/>
                                    </svg>
                                </button>
                            </form>

                        </div>
                    @endforeach

                </div>
            </div>

            <!-- GRAPHIQUE -->
            <div class="lg:w-[35%] bg-[var(--choco-beige)] rounded-2xl p-4 shadow-xl flex flex-col">
                <h2 class="font-kavoon text-lg text-[var(--choco-brown)] mb-3 text-center">
                    Niveau des stocks
                </h2>

                <div class="relative flex-1 min-h-[220px]">
                    <canvas id="stocksChart"></canvas>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const labels = @json($stocks->pluck('nom'));
    const quantites = @json($stocks->pluck('quantite'));
    const seuils = @json($stocks->pluck('seuil_min'));

    new Chart(document.getElementById('stocksChart'), {
        type: 'bar',
        data: {
            labels,
            datasets: [
                {
                    label: 'Stock',
                    data: quantites,
                    backgroundColor: '#F4A261'
                },
                {
                    label: 'Seuil',
                    data: seuils,
                    backgroundColor: '#5A4A42'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Rafraîchissement auto
    setInterval(() => {
        location.reload();
    }, 10000);
</script>
@endsection
