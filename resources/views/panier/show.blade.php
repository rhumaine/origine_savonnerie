{{-- resources/views/panier/show.blade.php --}}
@section('title',  'Mon panier')

<x-app-layout>
    <h1 class="panierName">Votre Panier</h1>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p>{{ session('error') }}</p>
    @endif


    @if(count($panier) > 0)
    
        <div class="containerPanier flex-column flex-lg-row">
            <!-- Tableau des produits dans le panier -->
            <div class="table-container mb-2 me-0 mb-lg-0 me-lg-4 bg-white p-2 rounded-lg shadow flex-shrink-0">
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
                                    <td class="ps-0 ps-sm-4">{{ $item['nom'] ?? 'Nom non disponible' }}</td>
                                    <td>{{ isset($item['prix']) ? number_format($item['prix'], 2, ',', ' ') : 'Prix non disponible' }} €</td>
                                    <td>{{ $item['quantite'] ?? 'Quantité non disponible' }}</td>
                                    <td>{{ isset($item['prix']) && isset($item['quantite']) ? number_format($item['prix'] * $item['quantite'], 2, ',', ' ') : 'Total non disponible' }} €</td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                @else
                    <p>Votre panier est vide.</p>
                @endif
            </div>
            <!-- Résumé et actions -->
            <div class="summary-container  bg-white p-2 rounded-lg shadow flex-shrink-0">
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
                <form action="{{ route('panier.vider') }}" method="POST" style="margin-top: 10px;">
                    @csrf
                    <button type="submit" class="btn btn-danger">Vider le panier</button>
                </form>
            </div>
        </div>
    @else
        <p>Votre panier est vide.</p>
    @endif
</x-app-layout>