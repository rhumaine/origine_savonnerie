{{-- resources/views/produits/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Détails du Produit')

@section('content')
        <section class="product-detail mb-5">
            <div class="product-image">

                @if($produit->url_image)
                    <img src="{{ asset('images/produits/' . $produit->url_image) }}" alt="{{ $produit->nom }}">
                @else
                    <img src="{{ asset('images/produits/600x900.png') }}" alt="Image par défault">
                @endif


            </div>
            <div class="product-info">

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
                
                <h2 class="name">{{ Str::upper($produit->nom) }}</h2>
                <p class="description text-center"> {!! nl2br(e($produit->description)) !!}</p>
                <p class="price">{{ $produit->prix }} € TTC</p>
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
            </div>
        </section>

        <section class="mb-5">
            <h2 class="text-center mb-3">Conseils d'utilisation : </h2>
            <p class="text-center">Humidifier la peau et le savon, faire mousser, se laver puis rincer abondamment.</p>
            <p class="text-center">Les savons peuvent être utilisés pour l’hygiène des mains, du corps, du visage, de manière quotidienne. Lorsque vous avez commencé à vous en servir, pensez à le rincer après chaque utilisation et le conserver au sec entre deux utilisations, soit sur le porte savon en aimanté soit dans le sac en sisal.</p>
            <p class="text-center"> Ne pas ingérer ou mettre dans les yeux. Ne pas utiliser sur une plaie ouverte.</p>
        </section>

        <section>
            <h2 class="text-center">Retrouvez nos autres produits</h2>
            @include('partials.products')
        </section>
@endsection