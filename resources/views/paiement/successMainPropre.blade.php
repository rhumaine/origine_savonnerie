{{-- resources/views/paiement/successMainPropre.blade.blade.php --}}
@section('title',  'Confirmation de commande')

<x-app-layout>
    <h1 class="panierName">Votre commande est confirmée.</h1>
    <p>Vous allez recevoir par email un récapitulatif de votre commande</p>

    <!-- Résumé de la Commande -->
    <h2>Résumé de la Commande</h2>
    <!-- Détails de l'achat -->
    <h3>Détails de l'achat</h3>
    <p class="ps-2"><strong>Montant total :</strong> {{ $total }} €</p>

    <!-- Adresse de livraison -->
    <h3>Adresse de livraison</h3>
    <p class="ps-2"><strong>Nom :</strong> {{ Auth::user()->name }} {{ Auth::user()->prenom }}</p>
    <p class="ps-2"><strong>Adresse :</strong> {{ Auth::user()->address }},  {{ Auth::user()->code_postal }} {{ Str::upper(Auth::user()->ville) }}</p>
    <br>    
    <!-- Liens associés -->
    <p><strong>Lien de la commande :</strong> <a href="{{ route('commandes.show', $commande_id) }}">Voir la commande</a></p>

</x-app-layout>