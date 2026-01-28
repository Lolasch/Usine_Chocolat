<x-app-layout>
{{-- Liste commandes --}}
<div class="bg-[#F5E8C7] rounded-3xl p-6 shadow-xl border-4 border-[#D4B384]">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-bold text-[#3C2B28]">Liste des commandes</h3>
        <div class="flex items-center space-x-3 text-sm text-[#8B4513]">
            <span>Temps réel : 14h51</span> |
            <select class="bg-transparent border border-[#D4B384] rounded-lg px-3 py-1">
                <option>Toutes les étapes</option>
            </select>
            <button class="bg-[#D4B384] px-4 py-1 rounded-lg text-[#3C2B28] font-semibold text-sm">Signer une pause</button>
        </div>
    </div>

    <div class="space-y-4">
        @php $commandes = collect([]); @endphp
        @if(class_exists('App\Models\Commande'))
            @php
                try {
                    $commandes = \App\Models\Commande::with(['visiteur', 'chocolat'])->latest()->limit(3)->get();
                } catch(Exception $e) {}
            @endphp
        @endif

        @forelse($commandes as $commande)
            <div class="flex items-center space-x-4 p-4 bg-white/50 rounded-2xl border-r-8 border-[#D4B384]">
                <div class="w-16 h-16 bg-[#D4B384] rounded-xl flex items-center justify-center text-xl shadow-lg">
                    🍫 {{ strtoupper(substr(($commande->chocolat->nom ?? 'CHOCO'), 0, 4)) }}
                </div>
                <div class="flex-1">
                    <div class="font-bold text-[#3C2B28]">{{ $commande->chocolat->nom ?? 'Chocolat' }} - 15 min</div>
                    <div class="text-sm text-[#8B4513]">N° {{ $commande->numerocommande ?? 'N/A' }}</div>
                </div>
                <div class="text-xl">⚠️</div>
            </div>
        @empty
            <div class="p-8 text-center text-[#8B4513]">
                <span class="text-4xl block mb-4">🍫</span>
                Aucune commande
            </div>
        @endforelse
    </div>
</div>

</x-app-layout>
