{{-- resources/views/paiement/success.blade.php --}}
@section('title',  'Confirmation de commande')

<x-app-layout>
    <h1 class="panierName">Votre commande est confirmée.</h1>
    <p>Vous allez recevoir par email un récapitulatif de votre commande</p>

    <!-- Résumé de la Commande -->
    <h2>Résumé de la Commande</h2>
    <!-- Détails de l'achat -->
    <h3>Détails de l'achat</h3>
    <p><strong>Montant total :</strong> {{ $result['purchase_units'][0]['payments']['captures'][0]['amount']['value'] }} {{ $result['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'] }}</p>

    <!-- Adresse de livraison -->
    <h3>Adresse de livraison</h3>
    <p><strong>Nom :</strong> {{ $result['purchase_units'][0]['shipping']['name']['full_name'] }}</p>
    <p><strong>Adresse :</strong></p>
    <ul>
        <li>{{ $result['purchase_units'][0]['shipping']['address']['address_line_1'] }}</li>
        <li>{{ $result['purchase_units'][0]['shipping']['address']['admin_area_2'] }}</li>
        <li>{{ $result['purchase_units'][0]['shipping']['address']['postal_code'] }}</li>
        <li>{{ $result['purchase_units'][0]['shipping']['address']['country_code'] }}</li>
    </ul>

    <!-- Liens associés -->
    <h3>Liens associés</h3>
    <p><strong>Lien de la commande :</strong> <a href="{{ route('commandes.show', $commande_id) }}">Voir la commande</a></p>

</x-app-layout>