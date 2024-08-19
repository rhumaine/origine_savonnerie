{{-- resources/views/produits/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Détails du Produit')

@section('content')

    <h1 class="panierName">Votre Panier</h2>

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

            <!-- Bouton pour passer à la caisse -->
            <a href="#" class="btn mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Valider le panier</a>

            <!-- Bouton pour vider le panier -->
            <form action="{{ route('panier.vider') }}" method="POST" style="margin-top: 20px;">
                @csrf
                <button type="submit" class="btn btn-danger">Vider le panier</button>
            </form>
        </div>
    </div>
    @else
        <p>Votre panier est vide.</p>
    @endif


     <!-- Modal -->
     <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Left -->
                <div class="modal-section modal-left">
                    <h5 class="text-center">Pas encore inscrit ?</h5>
                    <div class="text-center mb-3">
                        <a href="#" class="btn mt-3">Achat rapide</a>
                    </div>
                    <div class="text-center">
                        <a href="/register" class="btn mt-3">S'inscrire</a>
                    </div>
                </div>
                <!-- Modal Right -->
                <div class="modal-section modal-right">
                    <h5 class="text-center">Connexion</h5>
                    <form>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Entrez votre email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="password" placeholder="Entrez votre mot de passe" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Se connecter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection