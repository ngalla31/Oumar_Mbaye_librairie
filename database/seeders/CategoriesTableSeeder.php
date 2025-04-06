<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Définir un tableau de catégories de livres possibles
        $categories = [
            'Science-fiction',
            'Fantasy',
            'Romance',
            'Historique',
            'Thriller',
            'Policier',
            'Biographies',
            'Philosophie',
            'Développement personnel',
            'Jeunesse'
        ];

        // Créer une instance de Faker
        $faker = Faker::create();

        // Créer 10 catégories fictives
        for ($i = 0; $i < 10; $i++) {
            DB::table('categories')->insert([
                'nom' => $faker->randomElement($categories), // Sélectionne un élément aléatoire dans le tableau des catégories
            ]);
        }
    }
}
