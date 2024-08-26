<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;

class AdminController extends Controller
{
    public function dashboard(Request $request){

        $commandes = Commande::with('user')->get();

        return view('admin.dashboard', [
            'user' => $request->user(),
            'commandes' => $commandes,
        ]);
    }

    public function updateStatus(Request $request, Commande $commande)
    {
        $statut = $request->input('statut');
        $date = now()->toDateTimeString(); // Date au format ISO 8601

        // Ajouter le nouveau statut à l'historique
        $historique = $commande->historique_statuts;
        $historique[] = ['statut' => $statut, 'date' => $date];
        $commande->historique_statuts = $historique;
        $commande->save();

        return response()->json(['message' => 'Statut mis à jour avec succès']);
    }
}
