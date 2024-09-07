@section('title',  'Récapitulatif de la commande')

<x-app-layout>
    <div class="container my-4">
        <h1 class="panierName mb-4">Votre récapitulatif</h1>

        @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger mt-3">
                {{ session('error') }}
            </div>
        @endif
        
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="bg-white p-4 rounded shadow-sm mb-4">
                    <h2>Vos informations</h2>
                    <div class="user-info">
                        <h3><strong>Adresse email </strong></h3>
                        <p class="ps-3"> {{ Auth::user()->email }}</p>

                        <h3><strong>Téléphone</strong></h3>
                        <p class="ps-3"> {{ Auth::user()->telephone }}</p>

                        <h3><strong>Expédié à</strong> </h3>
                        <p>{{ Auth::user()->name }} {{ Auth::user()->prenom }}, {{ Auth::user()->address }},  {{ Auth::user()->code_postal }} {{ Str::upper(Auth::user()->ville) }}</p>
                    </div>
                </div>

                <div class="flex flex-column bg-white p-2 rounded-lg shadow mb-4">
                    <h2>Mode de paiement</h2>
                    <div class="containerRecap flex flex-column flex-lg-row">
                        <!--<a class="btnCb me-0 me-lg-2 mb-2 mb-lg-0 text-center" href="#">Carte bancaire</a>-->
                        <a class="btnPaypal me-0 me-lg-2 mb-2 mb-lg-0" href="{{ route('paypal.payment') }}"><img class="mx-auto" src="{{ asset('/images/paypal.svg')}}" role="presentation"></a>
                        <a class="btnMainPropre text-center" href="{{ route('paiement.mainpropre') }}">Paiement et remise en main propre</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="bg-white p-4 rounded shadow-sm">
                    <h2>Vos produits</h2>
                    @foreach($panierMisAJour as $id => $item)
                    <div class="panier-item d-flex align-items-center mb-3">
                        <div class="image-container me-3">
                            <img src="{{ asset('images/produits/' . $item['image']) }}" class="img-fluid rounded" alt="{{ $item['nom'] }}" style="width: 80px; height: auto;">
                        </div>
                        <div class="details-container flex-grow-1">
                            <p class="fw-bold mb-0">{{ Str::upper($item['nom']) }}</p>
                            <p class="mb-0">Quantité : {{ $item['quantite'] }}</p>
                        </div>
                        <div class="prix-container">
                            <p class="fw-bold mb-0">{{ number_format($item['prix'], 2, ',', ' ') }} €</p>
                            <p class="mb-0">{{ number_format($item['sous_total'], 2, ',', ' ') }} €</p>
                        </div>
                    </div>
                    @endforeach
                    <div class="panier-total mt-4">
                        <div class="total d-flex justify-content-between fw-bold fs-5">
                            <p>Total</p>
                            <p>{{ number_format($total, 2, ',', ' ') }} €</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
