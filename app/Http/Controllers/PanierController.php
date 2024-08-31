<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Produit;

class PanierController extends Controller
{
    public function ajouter(Request $request, $id)
    {

        $request->validate([
            'quantite' => 'required|integer|min:1',
        ]);

        $quantite = $request->input('quantite', 1);
        $panier = Session::get('panier', []);
        
        $produit = Produit::find($id);

        if ($produit) {
            if (isset($panier[$id])) {
                $panier[$id]['quantite'] += $quantite;
            } else {
                $panier[$id] = [
                    'produit' => $produit,
                    'quantite' => $quantite,
                ];
            }

            Session::put('panier', $panier);
            dd(Session::get('panier', []));
            return redirect()->back()->with('success', 'Produit ajouté au panier !');
        }
        
        return redirect()->back()->with('error', 'Produit non trouvé.');
    }


    public function show(Request $request)
    {
        $panier = Session::get('panier', []);
        $total = 0;

        // Calculer le total de la commande
        foreach ($panier as $item) {
            $total += $item['produit']->prix * $item['quantite'];
        }
        
        return view('panier.show',  ['panier' => $panier, 'total' => $total]); 
    }

    public function vider()
    {
        Session::forget('panier');
        return redirect()->route('panier.show')->with('success', 'Le panier a été vidé.');
    }
}
