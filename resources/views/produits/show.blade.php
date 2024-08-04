{{-- resources/views/produits/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Détails du Produit')

@section('content')
    <h1>{{ $produit->nom }}</h1>
    <p>Description : {{ $produit->description }}</p>
    <p>Prix : {{ $produit->prix }} €</p> 
@endsection