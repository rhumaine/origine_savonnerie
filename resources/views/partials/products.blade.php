<div class="flex flex-wrap justify-content-around pt-5">

    @for ($i =0; $i <= 10 ; $i++) 
        <div class="card mb-5" style="width: 18rem;">
            <a href="">
                <div class="image-container">
                    <img class="card-img-top zoomable-image" src="{{ asset('images/produits/300x400.png') }}" alt="Card image cap">
                </div>
                <div class="card-body">
                    <p class="card-text text-center">Produit 1</p>
                    <p class="card-text text-center">Prix 1</p>
                </div>
            </a>
        </div>
    @endfor 
</div>