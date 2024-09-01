@section('title',  'Récapitulatif de la commande')

<x-app-layout>
    <h1 class="panierName mb-4">Votre récapitulatif</h1>

    @if (session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
        <div class="alert alert-error mt-3">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="flex flex-column bg-white p-2 rounded-lg shadow mb-4">
        <h2>Vos produits</h2>
        <div class="containerPanier">
            <div class="table-container ">
                <table>
                    <thead>
                        <tr>
                            <th>Nom du produit</th>
                            <th>Prix unitaire</th>
                            <th>Quantité</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalGeneral = 0; 
                        @endphp

                        @foreach($panier as $id => $item)
                            @php
                                // Calcul du total pour chaque produit
                                $totalProduit = $item['prix'] * $item['quantite'];
                                // Ajout au total général
                                $totalGeneral += $totalProduit;
                            @endphp

                            <tr>
                                <td>{{ $item['nom'] }}</td>
                                <td>{{ number_format($item['prix'], 2, ',', ' ') }} €</td>
                                <td>{{ $item['quantite'] }}</td>
                                <td>{{ number_format($totalProduit, 2, ',', ' ') }} €</td>
                            </tr>
                        @endforeach
                        
                        <!-- Ligne du total général -->
                        <tr>
                            <td colspan="3" style="text-align:right; font-weight:bold;">Total à payer</td>
                            <td style="font-weight:bold;">{{ number_format($totalGeneral, 2, ',', ' ') }} €</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="flex flex-column bg-white p-2 rounded-lg shadow mb-4">
        <h2>Vos informations</h2>
        <div class="user-info containerRecap">
            <p><strong>Nom :</strong> {{ Auth::user()->name }}</p>
            <p><strong>Prénom :</strong> {{ Auth::user()->prenom }}</p>
            <p><strong>Email :</strong> {{ Auth::user()->email }}</p>
            <p><strong>Téléphone :</strong> {{ Auth::user()->telephone }}</p>
            <p><strong>Adresse :</strong> {{ Auth::user()->address }}</p>
            <p><strong>Code postal :</strong> {{ Auth::user()->code_postal }}</p>
            <p><strong>Ville :</strong> {{ Auth::user()->ville }}</p>
        </div>
    </div>

    <div class="flex flex-column bg-white p-2 rounded-lg shadow mb-4">
        <h2>Mode de paiement</h2>
        <div class="containerRecap flex flex-column flex-lg-row">
            <a class="btnCb me-0 me-lg-2 mb-2 mb-lg-0 text-center" href="#">Carte bancaire</a>
            <a class="btnPaypal me-0 me-lg-2 mb-2 mb-lg-0" href="{{ route('paypal.payment') }}"><img class="mx-auto" src="{{ asset('/images/paypal.svg')}}" role="presentation"></a>
            <a class="btnMainPropre text-center" href="#">Remise en main propre</a>
        </div>
    </div>
    
</x-app-layout>