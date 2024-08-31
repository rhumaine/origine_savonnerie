<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Enregistrer un view composer pour l'en-tête
        View::composer('*', function ($view) {
            $panier = request()->session()->get('panier', []);
            $totalProduits = count($panier);

            $view->with('totalProduits', $totalProduits);
        });
    }
}
