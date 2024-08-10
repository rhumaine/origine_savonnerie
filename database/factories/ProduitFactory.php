<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produit>
 */
class ProduitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->word, // Génère un mot aléatoire pour le nom
            'description' => $this->faker->text, // Génère un texte aléatoire pour la description
            'prix' => $this->faker->randomFloat(2, 10, 100), // Génère un prix aléatoire entre 10 et 100
            'url_image' => $this->faker->text
        ];
    }
}
