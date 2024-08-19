<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class OrderSummaryController extends Controller
{
    public function show(Request $request)
    {
        
        $panier = Session::get('panier', []);
        $total = 0;
        if(count($panier) > 0){
            // Calculer le total de la commande
            foreach ($panier as $item) {
                $total += $item['produit']->prix * $item['quantite'];
            }
            
            return view('recap.show',  ['panier' => $panier, 'total' => $total]);
        }else{
            return Redirect::route('panier.show');
        }
    }

    // Méthode pour gérer le paiement
    public function payment(Request $request)
    {
        // Logique pour traiter le paiement
        // Validation, communication avec le système de paiement, etc.
        return redirect()->route('payment.success');
    }

}
