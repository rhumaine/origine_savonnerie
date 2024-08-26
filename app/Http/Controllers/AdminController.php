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
}
