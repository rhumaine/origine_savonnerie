{{-- resources/views/produits/show.blade.php --}}
<x-app-layout>
    <h1 class="panierName">Votre Panier</h1>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p>{{ session('error') }}</p>
    @endif


    @if(count($panier) > 0)
    
        <div class="containerPanier">
            <!-- Tableau des produits dans le panier -->
            <div class="table-container">
                @if(count($panier) > 0)
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
                            @foreach($panier as $id => $item)
                                <tr>
                                    <td>{{ $item['produit']->nom }}</td>
                                    <td>{{ number_format($item['produit']->prix, 2, ',', ' ') }} €</td>
                                    <td>{{ $item['quantite'] }}</td>
                                    <td>{{ number_format($item['produit']->prix * $item['quantite'], 2, ',', ' ') }} €</td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                @else
                    <p>Votre panier est vide.</p>
                @endif
            </div>

            <!-- Résumé et actions -->
            <div class="summary-container">
                <h2>Total de la commande</h2>
                <p class="total mt-2">{{ number_format($total, 2, ',', ' ') }} €</p>

                @auth
                    <!-- Bouton pour passer à la caisse -->
                    <a href="{{ route('recap.show') }}" class="btn mt-3">Valider le panier</a>
                @else
                <!-- Bouton pour passer à la caisse -->
                    <a href="#" class="btn mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Valider le panier</a>
                @endauth
                <!-- Bouton pour vider le panier -->
                <form action="{{ route('panier.vider') }}" method="POST" style="margin-top: 20px;">
                    @csrf
                    <button type="submit" class="btn btn-danger">Vider le panier</button>
                </form>
            </div>
        </div>
        
        @include('panier.modalValide')

    @else
        <p>Votre panier est vide.</p>
    @endif
</x-app-layout>