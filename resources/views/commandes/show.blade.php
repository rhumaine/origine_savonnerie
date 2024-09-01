<x-app-layout>
    <div class="commande container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Détail de la Commande #{{ $commande->num_commande }}</h1>

        <div class="bg-white shadow-md rounded-lg mb-3 p-4">
            <h2 class="text-xl font-semibold">Informations de la commande</h2>
            <p>Nom : {{ $commande->user->name }}</p>
            <p>Prenom : {{ $commande->user->prenom }}</p>
            <p>Télephone : {{ $commande->user->telephone }}</p>
            <p>Adresse : {{ $commande->user->address }}</p>
            <p>Code postal : {{ $commande->user->code_postal }}</p>
            <p>Ville : {{ $commande->user->ville }}</p>
            </br>
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
                <table class="w-100">
                    <thead>
                        <tr>
                            <th style="width:200px">Nom du produit</th>
                            <th style="width:100px">P.U</th>
                            <th style="width:100px">Quantité</th>
                            <th style="width:100px">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($commande->produit as $produit)
                        <tr>
                            <td class="ps-0 ps-sm-4">{{ $produit->nom }}</td>
                            <td>{{ number_format($produit->pivot->prix_unitaire, 2, ',', ' ') }} €</td>
                            <td>{{ $produit->pivot->quantite }}</td>
                            <td>{{ number_format($produit->pivot->prix_unitaire * $produit->pivot->quantite, 2, ',', ' ') }} €</td>
                        </tr> 
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
