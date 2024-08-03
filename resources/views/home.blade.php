{{-- resources/views/pages/home.blade.php --}}
@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
    @include('partials.carrousel')

    @include('partials.products')
@endsection

