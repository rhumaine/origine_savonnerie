<?php

namespace Database\Seeders;

use App\Models\Produit;
use Illuminate\Database\Seeder;

class ProduitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Crée 10 produits de test
       Produit::factory()->count(10)->create([
        'url_image' => '600x900.png'
       ]);
        
    }
}
