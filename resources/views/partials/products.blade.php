<div class="d-flex flex-wrap justify-content-start gap-3 pt-5">

    @foreach($produits as $p)
        @if (!isset($produit->id) || $produit->id != $p->id)
            <div class="card mb-5" style="flex: 1 1 calc(33% - 1rem); max-width: 33%;">
                <a href="{{ url('/produits/'.$p->id) }}">
                    <div class="image-container">
                    @if($p->url_image)
                        <img class="card-img-top zoomable-image" style="width:100%" src="{{ asset('images/produits/' . $p->url_image) }}" alt="{{ $p->nom }}">
                    @else
                        <img class="card-img-top zoomable-image" style="width:300px;height:400px" src="{{ asset('images/produits/300x400.png') }}" alt="Image par défault">
                    @endif
                    </div>
                    <div class="card-body">
                        <p class="card-text text-center">{{ Str::upper($p->nom) }}</p>
                        <p class="card-text text-center">{{ $p->prix }} € TTC</p>
                    </div>
                </a>
            </div>
        @endif
    @endforeach
</div>