@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto p-8">

    <!-- Header -->
    <div class="mb-12">
        <h1 class="font-kavoon text-5xl text-[var(--choco-brown)] mb-2">
            Frigo
        </h1>
        <p class="text-lg text-[var(--choco)]">
            Gestion des stocks
        </p>
    </div>

    <!-- Frigo container -->
    <div class="bg-[var(--choco-brown)] rounded-3xl p-8 shadow-2xl">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach($stocks as $stock)

            @php
                $pourcentage = max(0, min(100, $stock->quantite));
            @endphp

            <div class="bg-[var(--green)] rounded-2xl p-6 shadow-lg relative">

                <!-- Nom -->
                <h2 class="font-kavoon text-xl text-[var(--choco-brown)] mb-4 text-center">
                    🍫 {{ $stock->nom }}
                </h2>

                <!-- Icône produit -->
                <div class="flex justify-center mb-4">
                    <div class="w-20 h-20 rounded-full bg-[var(--choco)] flex items-center justify-center text-4xl shadow-inner">
                        🍩
                    </div>
                </div>

                <!-- Stock -->
                <p class="text-center text-sm font-semibold text-[var(--choco-brown)] mb-2">
                    {{ $stock->quantite }} / 100 en stock
                </p>

                <!-- Progress bar -->
                <div class="w-full h-3 bg-[var(--choco-beige)] rounded-full overflow-hidden mb-4">
                    <div
                        class="h-full transition-all duration-300
                        @if($stock->quantite <= 0)
                            bg-red-500
                        @elseif($stock->quantite <= $stock->seuil_min)
                            bg-orange-400
                        @else
                            bg-[var(--caramel)]
                        @endif"
                        style="width: {{ $pourcentage }}%"
                    ></div>
                </div>

                <!-- Etat -->
                <div class="text-center mb-5">
                    @if($stock->quantite <= 0)
                        <span class="text-red-600 font-bold">❌ Rupture</span>
                    @elseif($stock->quantite <= $stock->seuil_min)
                        <span class="text-orange-600 font-bold">⚠️ Stock faible</span>
                    @else
                        <span class="text-green-700 font-bold">✅ OK</span>
                    @endif
                </div>

                <!-- Seuil minimum -->
                <form method="POST" action="{{ route('stocks.update.seuil') }}"
                    class="flex items-center justify-center gap-2 mb-4">
                    @csrf
                    <input type="hidden" name="stock_id" value="{{ $stock->id }}">

                    <label class="text-sm font-semibold text-[var(--choco-brown)]">
                        Seuil
                    </label>

                    <input
                        type="number"
                        name="seuil_min"
                        min="0"
                        value="{{ $stock->seuil_min }}"
                        class="w-16 text-center rounded-lg border border-[var(--choco)] bg-white"
                    >

                    <button
                        type="submit"
                        class="px-3 py-1 rounded-lg text-sm font-bold text-white bg-[var(--choco)] hover:bg-[var(--caramel-dark)] transition"
                    >
                        ✔
                    </button>
                </form>

                <!-- Form QR -->
                <form method="POST" action="{{ route('stocks.add.qr') }}" class="flex items-center justify-center gap-3">
                    @csrf
                    <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                    <input type="hidden" name="qr_code" value="STOCK_ID={{ $stock->id }}">

                    <input
                        type="number"
                        name="quantite"
                        min="1"
                        value="1"
                        class="w-16 text-center rounded-lg border border-[var(--choco)] bg-white"
                    >

                    <button
                        type="submit"
                        class="px-4 py-2 rounded-lg font-bold text-white bg-[var(--caramel)] hover-caramel transition"
                    >
                        ➕ Ajouter
                    </button>
                </form>

            </div>

            @endforeach

        </div>
    </div>
</div>
@endsection
