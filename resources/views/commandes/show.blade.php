<x-app-layout>
    <div class="commande container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Détail de la Commande #{{ $commande->num_commande }}</h1>

        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="bg-white p-4 rounded shadow-sm mb-4">
                    <div class="user-info">
                        <h3><strong>Adresse email </strong></h3>
                        <p class="ps-3"> {{ Auth::user()->email }}</p>

                        <h3><strong>Téléphone</strong></h3>
                        <p class="ps-3"> {{ Auth::user()->telephone }}</p>

                        <h3><strong>Expédié à</strong> </h3>
                        <p>{{ Auth::user()->name }} {{ Auth::user()->prenom }}, {{ Auth::user()->address }},  {{ Auth::user()->code_postal }} {{ Str::upper(Auth::user()->ville) }}</p>
                    </div>
                </div>

                <div class="bg-white p-4 rounded shadow-sm mb-4">
                    <p>Date de commande : {{ $commande->date_commande->format('d/m/Y') }}</p>
                    <p>Mode de paiement : {{ ucfirst($commande->mode_paiement) }}</p>
                    @php
                        $historique = is_string($commande->historique_statuts) ? json_decode($commande->historique_statuts, true) : $commande->historique_statuts;
                        $dernierStatut = !empty($historique) ? end($historique)['statut'] : 'Aucun statut disponible';
                    @endphp

                    <p>Statut : {{ $dernierStatut }}</p>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="bg-white p-4 rounded shadow-sm">
                    <h2>Vos produits</h2>
                    @foreach($commande->produit as $produit)
                    <div class="panier-item d-flex align-items-center mb-3">
                        <div class="image-container me-3">
                            <img src="{{ asset('images/produits/' . $produit['url_image']) }}" class="img-fluid rounded" alt="{{ $produit['nom'] }}" style="width: 80px; height: auto;">
                        </div>
                        <div class="details-container flex-grow-1">
                            <p class="fw-bold mb-0">{{ Str::upper($produit['nom']) }}</p>
                            <p class="mb-0">Quantité : {{ $produit->pivot->quantite }}</p>
                        </div>
                        <div class="prix-container">
                            <p class="fw-bold mb-0">{{ number_format($produit['prix'], 2, ',', ' ') }} €</p>
                            <p class="mb-0">{{ number_format($produit->pivot->prix_unitaire * $produit->pivot->quantite, 2, ',', ' ') }} €</p>
                        </div>
                    </div>
                    @endforeach
                    <div class="panier-total mt-4">
                        <div class="total d-flex justify-content-between fw-bold fs-5">
                            <p>Total</p>
                            <p>{{ number_format($commande->total, 2, ',', ' ') }} €</p>
                        </div>
                    </div>
                </div>
            </div>      
        </div>
    </div>
</x-app-layout>