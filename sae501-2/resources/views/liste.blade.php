<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Liste des commandes</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3>Liste des commandes (à développer)</h3>
                    <p>Bonjour {{ auth()->user()->prenom }} {{ auth()->user()->nom }} !</p>

                    {{-- Tes vraies données --}}
                    @if(class_exists('App\Models\Commande'))
                        @php $commandes = \App\Models\Commande::latest()->paginate(10); @endphp
                        <div class="mt-6">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr><th>N°</th><th>Client</th><th>Chocolat</th><th>Statut</th></tr>
                                </thead>
                                <tbody>
                                    @foreach($commandes as $c)
                                        <tr>
                                            <td>{{ $c->numerocommande }}</td>
                                            <td>{{ $c->visiteur->prenom ?? '' }}</td>
                                            <td>{{ $c->chocolat->nom ?? '' }}</td>
                                            <td>{{ $c->statut }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $commandes->links() }}
                        </div>
                    @else
                        <p>Aucune commande (crée modèle Commande)</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
