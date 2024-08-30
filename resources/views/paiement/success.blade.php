{{-- resources/views/paiement/success.blade.php --}}
@section('title',  'Confirmation de commande')

<x-app-layout>
    <h1 class="panierName">Votre commande est confirmée.</h1>
    <p>Vous allez recevoir par email un récapitulatif de votre commande</p>

    {{ $result }}

</x-app-layout>