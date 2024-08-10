<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PanierController extends Controller
{
    public function ajouter(Request $request, $id)
    {
        $panier = Session::get('panier', []);

        $produit = Produit::find($id);

        if ($produit) {
            if (isset($panier[$id])) {
                $panier[$id]['quantite'] += $request->input('quantite', 1);
            } else {
                $panier[$id] = [
                    'produit' => $produit,
                    'quantite' => $request->input('quantite', 1),
                ];
            }

            Session::put('panier', $panier);

            return redirect()->back()->with('success', 'Produit ajouté au panier !');
        }
        
        return redirect()->back()->with('error', 'Produit non trouvé.');
    }
}
