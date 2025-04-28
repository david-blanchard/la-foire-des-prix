<?php

namespace App\DataFixtures;

use App\Entity\Image;
use App\Entity\Product;
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

        $imageRepository = $manager->getRepository(Image::class);
        $productRepository = $manager->getRepository(Product::class);

        foreach ($productImages as $data) {
            $product = $productRepository->find($productImages['product']);
            $image = $imageRepository->find($productImages['image']);

            $productImage = new ProductImage();
            $productImage->setProduct($product);
            $productImage->setImage($image);
            $manager->persist($productImage);
        }

        $manager->flush();
    }
}
