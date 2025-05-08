<?php

namespace App\DataFixtures\Fixture;

use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;

class ImagesFixture implements CustomFixtureInterface
{

    public const IMAGE_LABEL_1 = 'Veste en jean cintrée manches longues femme bleue 1/4';
    public const IMAGE_LABEL_2 = 'Veste en jean cintrée manches longues femme bleue 2/4';
    public const IMAGE_LABEL_3 = 'Veste en jean cintrée manches longues femme bleue 3/4';
    public const IMAGE_LABEL_4 = 'Veste en jean cintrée manches longues femme bleue 4/4';

    public function execute(ObjectManager $manager): void
    {
        $images = [
            [
                'url' => "/build/images/articles/veste-en-jean-cintree-manches-longues-femme-bleu-1.webp",
                'alt' => self::IMAGE_LABEL_1,
                'title' => "Veste en jean bleu cintrée manches longues pour femme, pas chère",
            ],
            [
                'url' => "/build/images/articles/veste-en-jean-cintree-manches-longues-femme-bleu-2.webp",
                'alt' => self::IMAGE_LABEL_2,
                'title' => "Veste en jean bleu cintrée manches longues pour femme, pas chère",
            ],
            [
                'url' => "/build/images/articles/veste-en-jean-cintree-manches-longues-femme-bleu-3.webp",
                'alt' => self::IMAGE_LABEL_3,
                'title' => "Veste en jean bleu cintrée manches longues pour femme, pas chère",
            ],
            [
                'url' => "/build/images/articles/veste-en-jean-cintree-manches-longues-femme-bleu-4.webp",
                'alt' => self::IMAGE_LABEL_4,
                'title' => "Veste en jean bleu cintrée manches longues pour femme, pas chère",
            ],
            [
                'url' => "/build/images/articles/robe-courte-eponge-jodie-reedition-1.webp",
                'alt' => "Robe courte éponge Jodie Réédition 1/5",
                'title' => "Robe éponge courte pas chère Jodie Réédition",
            ],
            [
                'url' => "/build/images/articles/robe-courte-eponge-jodie-reedition-2.webp",
                'alt' => "Robe courte éponge Jodie Réédition 2/5",
                'title' => "Robe éponge courte pas chère Jodie Réédition",
            ],
            [
                'url' => "/build/images/articles/robe-courte-eponge-jodie-reedition-3.webp",
                'alt' => "Robe courte éponge Jodie Réédition 3/5",
                'title' => "Robe éponge courte pas chère Jodie Réédition",
            ],
            [
                'url' => "/build/images/articles/robe-courte-eponge-jodie-reedition-4.webp",
                'alt' => "Robe courte éponge Jodie Réédition 4/5",
                'title' => "Robe éponge courte pas chère Jodie Réédition",
            ],
            [
                'url' => "/build/images/articles/robe-courte-eponge-jodie-reedition-5.webp",
                'alt' => "Robe courte éponge Jodie Réédition 5/5",
                'title' => "Robe éponge courte pas chère Jodie Réédition",
            ],
            [
                'url' => "/build/images/articles/tee-shirt-uni-a-bretelles-maille-elastique-femme-noir-1.webp",
                'alt' => "T-shirt uni à bretelles noir maille élastique pour femme 1/3",
                'title' => "T-shirt uni à bretelles noir pas cher maille élastique ",
            ],
            [
                'url' => "/build/images/articles/tee-shirt-uni-a-bretelles-maille-elastique-femme-noir-2.webp",
                'alt' => "T-shirt uni à bretelles noir maille élastique pour femme 2/3",
                'title' => "T-shirt uni à bretelles noir pas cher maille élastique ",
            ],
            [
                'url' => "/build/images/articles/tee-shirt-uni-a-bretelles-maille-elastique-femme-noir-3.webp",
                'alt' => "T-shirt uni à bretelles noir maille élastique pour femme 3/3",
                'title' => "T-shirt uni à bretelles noir pas cher maille élastique ",
            ],
        ];

        foreach ($images as $key => $data) {
            $image = new Image();
            $image->setUrl($data['url']);
            $image->setAlt($data['alt']);
            $image->setTitle($data['title']);
            $manager->persist($image);
        }

        $manager->flush();
    }
}
