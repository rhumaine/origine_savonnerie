<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Produit;
use Illuminate\Support\Facades\Cookie;

class PanierController extends Controller
{
    public function ajouter(Request $request, $id)
    {
        $request->validate([
            'quantite' => 'required|integer|min:1',
        ]);
    
        $quantite = $request->input('quantite', 1);
        $panier = json_decode($request->cookie('panier', '[]'), true);
    
        $produit = Produit::find($id);
    
        if ($produit) {
            // Si le produit est déjà dans le panier, mettre à jour la quantité
            if (isset($panier[$id])) {
                $panier[$id]['quantite'] += $quantite;
            } else {
                // Ajouter le produit au panier avec les détails nécessaires
                $panier[$id] = [
                    'id' => $id,
                    'nom' => $produit->nom,
                    'prix' => $produit->prix,
                    'quantite' => $quantite,
                ];
            }
    
            Cookie::queue(Cookie::make('panier', json_encode($panier), 120)); // Expiration en minutes

    
            return redirect()->back()->with('success', 'Produit ajouté au panier !');
        }
    
        return redirect()->back()->with('error', 'Produit non trouvé.');
    }


    public function show(Request $request)
    {
      // Récupérer le panier depuis le cookie
      $panier = json_decode($request->cookie('panier', '[]'), true);
  
      $total = 0;
  
      // Calculer le total de la commande
      foreach ($panier as $item) {
          // Assurez-vous que les clés 'prix' et 'quantite' existent
          if (isset($item['prix']) && isset($item['quantite'])) {
              $total += $item['prix'] * $item['quantite'];
          }
      }
  
      return view('panier.show', ['panier' => $panier, 'total' => $total]);
    }

    public function vider(Request $request)
    {
        $request->session()->forget('panier');
        Cookie::queue(Cookie::forget('panier'));
        return redirect()->route('panier.show')->with('success', 'Le panier a été vidé.');
    }
}
