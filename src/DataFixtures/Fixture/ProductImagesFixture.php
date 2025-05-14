<?php

namespace App\DataFixtures\Fixture;

use App\Entity\Image;
use App\Entity\Product\ClothProduct;
use App\Entity\ProductImage;
use Doctrine\Persistence\ObjectManager;

class ProductImagesFixture implements CustomFixtureInterface
{
    public function execute(ObjectManager $manager): void
    {
        $productImages = [
            ['product' => ProductsFixture::PRODUCT_LABEL_1, 'image' => ImagesFixture::IMAGE_LABEL_1],
            ['product' => ProductsFixture::PRODUCT_LABEL_1, 'image' => ImagesFixture::IMAGE_LABEL_2],
            ['product' => ProductsFixture::PRODUCT_LABEL_1, 'image' => ImagesFixture::IMAGE_LABEL_3],
            ['product' => ProductsFixture::PRODUCT_LABEL_1, 'image' => ImagesFixture::IMAGE_LABEL_4],
        ];

        $imageRepository = $manager->getRepository(Image::class);
        $productRepository = $manager->getRepository(ClothProduct::class);

        foreach ($productImages as $key => $data) {
            $product = $productRepository->findOneBy(['name' => $data['product']]) ?? null;
            $image = $imageRepository->findOneBy(['alt' => $data['image']]) ?? null;

            $productImage = new ProductImage();
            $productImage->setProduct($product);
            $productImage->setImage($image);
            $manager->persist($productImage);
        }

        $manager->flush();
    }
}
