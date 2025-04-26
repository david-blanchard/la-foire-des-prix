<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Products::create([
            'name' => "Veste en jean cintrée manches longues",
            'description' => "Veste. Col chemise. Fermeture par boutons métalliques. Manches longues avec poignets et boutons. Poches plaquées à rabats sur poitrine. Poches passepoilées sur les côtés. Empiècements.",
            'more_infos' => "Ne pas nettoyer à sec;lavage à 30°;100% coton",
            'price' => 37.99,
            'brand' => 1,
        ]);

        Products::create([
            'name' => "Robe courte éponge Jodie Réédition",
            'description' => "Pièce maitresse des années 80, la robe éponge fait son comeback ! On ne l’espérait plus et pourtant, chez 3 SUISSES, nous l’avons fait. La robe blanche éponge revient sur le devant de la scène cette saison. Confortable, abordable et abordable, elle deviendra vite pour chouchou de l’été que vous ne voudrez plus quitter ! Robe en éponge manches courtes, resserrée à la taille, col V.",
            'more_infos' => "Lavage 30°;Repassage faible température;Blanchiment interdit;Pas de séchage en tambour;100% Coton",
            'price' => 39.99,
            'brand' => 2,
        ]);

        Products::create([
            'name' => "Tee-shirt uni à bretelles maille élastique",
            'description' => " Ce tee-shirt à fines bretelles, indispensable en toutes saisons, se porte seul ou associé à d'autres tenues. Tee-shirt uni. Encolure arrondie. Fines bretelles. En maille jersey élastique. Longueur 60 cm environ.",
            'more_infos' => "Lavage 30°;Repassage faible température;Pas de séchage en tambour;95% coton, 5% élasthanne",
            'price' => 13.99,
            'brand' => 3,
        ]);
        
    }
}
