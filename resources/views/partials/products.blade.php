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