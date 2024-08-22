{{-- resources/views/produits/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Confirmation paiement')

@section('content')
    <h1 class="panierName">Votre commande est confirmée.</h1>
    <p>Vous allez recevoir par email un récapitulatif de votre commande</p>

    {{ $result }}

@endsection