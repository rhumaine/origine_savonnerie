<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

     protected $table = 'commande';

     protected $fillable = [
         'num_commande',
         'date_commande',
         'total',
         'mode_paiement',
         'date_livraison_prevue',
         'date_livraison_reelle',
         'commentaires',
         'historique_statuts',
         'user_id',
     ];
 

     protected $casts = [
         'date_commande' => 'datetime',
         'date_livraison_prevue' => 'datetime',
         'date_livraison_reelle' => 'datetime',
         'historique_statuts' => 'array', 
     ];
 
     public function user()
     {
         return $this->belongsTo(User::class, 'user_id');
     }
}
