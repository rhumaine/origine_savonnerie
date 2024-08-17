{{-- resources/views/produits/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Détails du Produit')

@section('content')
        <section class="product-detail">
            <div class="product-image">

                @if($produit->url_image)
                    <img src="{{ asset('images/produits/' . $produit->url_image) }}" alt="{{ $produit->nom }}">
                @else
                    <img src="{{ asset('images/produits/600x900.png') }}" alt="Image par défault">
                @endif


            </div>
            <div class="product-info">
                <h2 class="name">{{ $produit->nom }}</h2>
                <p class="description">{{ $produit->description }}</p>
                <p class="price">{{ $produit->prix }} €</p>
                <p class="taxe">Taxes incluses. Frais d'expédition calculés à l'étape de paiement.</p>

                <form action="{{ route('panier.ajouter', $produit->id) }}" method="POST">
                    @csrf
                    <!-- Composant de contrôle de quantité -->
                    <div class="quantity-input">
                        <button class="quantity_button" type="button" onclick="changeQuantity(-1)">-</button>
                        <input class="quantity_input" type="text" name="quantite" id="quantite" min="1" value="1">
                        <button class="quantity_button" type="button" onclick="changeQuantity(1)">+</button>
                    </div>

                    <!-- Ajouter des boutons ou des formulaires pour acheter, ajouter au panier, etc. -->
                    <button class="add_panier" type="submit">Ajouter au panier</button>
                </form>

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
            </div>
        </section>

        <div class="flex flex-wrap justify-content-around pt-5">
            @foreach($produits as $produit)
                <div class="card mb-5" style="width: 18rem;">
                    <a href="{{ url('/produits/'.$produit->id) }}">
                        <div class="image-container">
                        @if($produit->url_image)
                            <img class="card-img-top zoomable-image" style="width:300px;height:400px" src="{{ asset('images/produits/' . $produit->url_image) }}" alt="{{ $produit->nom }}">
                        @else
                            <img class="card-img-top zoomable-image" style="width:300px;height:400px" src="{{ asset('images/produits/300x400.png') }}" alt="Image par défault">
                        @endif
                        </div>
                        <div class="card-body">
                            <p class="card-text text-center">{{ $produit->nom }}</p>
                            <p class="card-text text-center">{{ $produit->prix }} €</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
@endsection