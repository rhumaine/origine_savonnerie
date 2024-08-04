<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Produit;

class ProduitsController extends Controller
{
    //
    public function show($id){
        $produit = Produit::find($id);

        if(!$produit){
            abord(404, 'Produit non trouvé');
        }

        return view('produits.show', compact('produit'));
    }
}
