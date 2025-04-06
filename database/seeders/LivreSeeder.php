<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Livre;
class LivreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Insérer 5 livres avec des données statiques
         Livre::create([
            'titre' => 'Le Voyage Extraordinaire',
            'auteur' => 'Jean Dupont',
            'prix' => 19.99,
            'stock' => 15,
            'idCategorie' => 24, // Remplacez avec un id valide de catégorie
        ]);

        Livre::create([
            'titre' => 'La Magie des Mots',
            'auteur' => 'Marie Curie',
            'prix' => 25.50,
            'stock' => 8,
            'idcategorie' => 23, // Remplacez avec un id valide de catégorie
        ]);
    }
}
