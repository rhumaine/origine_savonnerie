<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;

class ProduitsController extends Controller
{
    //
    public function show($id){
        $produits = Produit::inRandomOrder()->limit(5)->get();

        $produit = Produit::find($id);

        if(!$produit){
            abort(404, 'Produit non trouvé');
        }

        return view('produits.show', compact('produit', 'produits'));
    }
}
