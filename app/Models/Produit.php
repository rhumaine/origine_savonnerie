<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $table = 'produits';

    protected $fillable = ['nom', 'description', 'prix'];

    public function commande()
    {
        return $this->belongsToMany(Commande::class, 'commande_produit')
                    ->using(CommandeProduit::class)
                    ->withPivot('quantite', 'prix_unitaire')
                    ->withTimestamps();
    }
}
