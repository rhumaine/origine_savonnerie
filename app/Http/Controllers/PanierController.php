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
        $panier = $request->session()->get('panier', []);
        
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

            $request->session()->put('panier', $panier);

\Log::info('Panier sauvegardé dans la session:', $request->session()->get('panier'));
            return redirect()->back()->with('success', 'Produit ajouté au panier !');
        }
        
        return redirect()->back()->with('error', 'Produit non trouvé.');
    }


    public function show(Request $request)
    {
        $panier = $request->session()->get('panier', []);
        $total = 0;

        // Calculer le total de la commande
        foreach ($panier as $item) {
            $total += $item['produit']->prix * $item['quantite'];
        }
        echo "<pre>";
print_r( $request->session()->get('panier', []) );
echo "</pre>";
        return view('panier.show',  ['panier' => $panier, 'total' => $total]); 
    }

    public function vider(Request $request)
    {
        $request->session()->forget('panier');
        return redirect()->route('panier.show')->with('success', 'Le panier a été vidé.');
    }
}
