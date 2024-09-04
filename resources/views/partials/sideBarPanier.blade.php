<div id="cart-sidebar" class="close">
    <a href="javascript:void(0)" id="close-cart" style="position: absolute; top: 20px; right: 25px; font-size: 36px;">&times;</a>
    
    <div class="mx-auto">
        <p class="text-center">Total</p>
        <p class="text-center">{{ $totalPrix }} €</p>
        <hr>
        
        @if (count($panier) > 0)
            @foreach ($panier as $p)
                <div class="pb-2">
                    <p>{{ $p['nom'] }}</p>
                    <p class="ps-5">Quantité : {{ $p['quantite'] }}</p>
                    <p class="ps-5">Sous-total : {{ $p['prix'] * $p['quantite'] }} €</p>
                </div>
                @if (!$loop->last)
                    <hr>
                @endif
            @endforeach
            <div class="containerPanier flex flex-column p-2">
                @auth
                    <!-- Bouton pour passer à la caisse -->
                    <a href="{{ route('recap.show') }}" class="btn mt-3">Valider le panier</a>
                @else
                <!-- Bouton pour passer à la caisse -->
                    <a href="#" class="btn mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Valider le panier</a>
                @endauth
                <form action="{{ route('panier.vider') }}" method="POST" style="margin-top: 10px;">
                    @csrf
                    <button type="submit" class="btn btn-danger">Vider le panier</button>
                </form>
            </div>
        @else
            <p class="text-center">Panier vide</p>
        @endif
    </div>
</div>
