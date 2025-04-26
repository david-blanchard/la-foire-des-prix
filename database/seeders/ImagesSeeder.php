<?php

namespace Database\Seeders;

use App\Models\Images;
use Illuminate\Database\Seeder;

class ImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Images::create([
            'url' => "/assets/images/articles/veste-en-jean-cintree-manches-longues-femme-bleu-1.webp",
            'alt' => "Veste en jean cintrée manches longues femme bleue 1/4",
            'title' => "Veste en jean bleu cintrée manches longues pour femme, pas chère",
        ]);
        Images::create([
            'url' => "/assets/images/articles/veste-en-jean-cintree-manches-longues-femme-bleu-2.webp",
            'alt' => "Veste en jean cintrée manches longues femme bleue 2/4",
            'title' => "Veste en jean bleu cintrée manches longues pour femme, pas chère",
        ]);
        Images::create([
            'url' => "/assets/images/articles/veste-en-jean-cintree-manches-longues-femme-bleu-3.webp",
            'alt' => "Veste en jean cintrée manches longues femme bleue 3/4",
            'title' => "Veste en jean bleu cintrée manches longues pour femme, pas chère",
        ]);
        Images::create([
            'url' => "/assets/images/articles/veste-en-jean-cintree-manches-longues-femme-bleu-4.webp",
            'alt' => "Veste en jean cintrée manches longues femme bleue 4/4",
            'title' => "Veste en jean bleu cintrée manches longues pour femme, pas chère",
        ]);
        Images::create([
            'url' => "/assets/images/articles/robe-courte-eponge-jodie-reedition-1.webp",
            'alt' => "Robe courte éponge Jodie Réédition 1/5",
            'title' => "Robe éponge courte pas chère Jodie Réédition",
        ]);
        Images::create([
            'url' => "/assets/images/articles/robe-courte-eponge-jodie-reedition-2.webp",
            'alt' => "Robe courte éponge Jodie Réédition 2/5",
            'title' => "Robe éponge courte pas chère Jodie Réédition",
        ]);
        Images::create([
            'url' => "/assets/images/articles/robe-courte-eponge-jodie-reedition-3.webp",
            'alt' => "Robe courte éponge Jodie Réédition 3/5",
            'title' => "Robe éponge courte pas chère Jodie Réédition",
        ]);
        Images::create([
            'url' => "/assets/images/articles/robe-courte-eponge-jodie-reedition-4.webp",
            'alt' => "Robe courte éponge Jodie Réédition 4/5",
            'title' => "Robe éponge courte pas chère Jodie Réédition",
        ]);
        Images::create([
            'url' => "/assets/images/articles/robe-courte-eponge-jodie-reedition-5.webp",
            'alt' => "Robe courte éponge Jodie Réédition 5/5",
            'title' => "Robe éponge courte pas chère Jodie Réédition",
        ]);
        Images::create([
            'url' => "/assets/images/articles/tee-shirt-uni-a-bretelles-maille-elastique-femme-noir-1.webp",
            'alt' => "T-shirt uni à bretelles noir maille élastique pour femme 1/3",
            'title' => "T-shirt uni à bretelles noir pas cher maille élastique ",
        ]);
        Images::create([
            'url' => "/assets/images/articles/tee-shirt-uni-a-bretelles-maille-elastique-femme-noir-2.webp",
            'alt' => "T-shirt uni à bretelles noir maille élastique pour femme 2/3",
            'title' => "T-shirt uni à bretelles noir pas cher maille élastique ",
        ]);
        Images::create([
            'url' => "/assets/images/articles/tee-shirt-uni-a-bretelles-maille-elastique-femme-noir-3.webp",
            'alt' => "T-shirt uni à bretelles noir maille élastique pour femme 3/3",
            'title' => "T-shirt uni à bretelles noir pas cher maille élastique ",
        ]);
    }
}
