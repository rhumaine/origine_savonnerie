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
            $panier = json_decode(request()->cookie('panier', '[]'), true);
            $totalProduits = count($panier);

            $total = 0;
  
            // Calculer le total de la commande
            foreach ($panier as $item) {
                // Assurez-vous que les clés 'prix' et 'quantite' existent
                if (isset($item['prix']) && isset($item['quantite'])) {
                    $total += $item['prix'] * $item['quantite'];
                }
            } 

            $view->with(['totalProduits'=> $totalProduits, 'panier' =>$panier, 'totalPrix' => $total]);
        });
    }
}
