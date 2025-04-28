<?php

namespace App\DataFixtures;

use App\Entity\ProductImage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductImagesFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $productImages = [
            ['product' => 1, 'image' => 1],
            ['product' => 1, 'image' => 2],
            ['product' => 1, 'image' => 3],
            ['product' => 1, 'image' => 4],
        ];

        foreach ($productImages as $data) {
            $productImage = new ProductImage();
            $productImage->setProduct($data['product']);
            $productImage->setImage($data['image']);
            $manager->persist($productImage);
        }

        $manager->flush();
    }
}
