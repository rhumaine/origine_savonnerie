<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Détail de la Commande #{{ $commande->num_commande }}</h1>

        <div class="bg-white shadow-md rounded-lg mb-6 p-4">
            <h2 class="text-xl font-semibold">Informations de la commande</h2>
            <p>Date de commande : {{ $commande->date_commande->format('d/m/Y') }}</p>
            <p>Mode de paiement : {{ ucfirst($commande->mode_paiement) }}</p>
            @php
                $historique = is_string($commande->historique_statuts) ? json_decode($commande->historique_statuts, true) : $commande->historique_statuts;
                $dernierStatut = !empty($historique) ? end($historique)['statut'] : 'Aucun statut disponible';
            @endphp

            <p>Statut : {{ $dernierStatut }}</p>
            <p>Total : {{ number_format($commande->total, 2) }} €</p>
        </div>

        <div class="bg-white shadow-md rounded-lg p-4">
            <h3 class="text-lg font-semibold">Produits commandés</h3>
            <ul class="list-disc ml-6 mt-2">
                @foreach($commande->produit as $produit)
                    <li class="mb-2">
                        <span class="font-bold">{{ $produit->nom }}</span> -
                        {{ $produit->pivot->quantite }} x {{ number_format($produit->pivot->prix_unitaire, 2) }} € =
                        {{ number_format($produit->pivot->quantite * $produit->pivot->prix_unitaire, 2) }} €
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
