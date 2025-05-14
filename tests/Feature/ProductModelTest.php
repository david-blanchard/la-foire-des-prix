<?php

namespace App\Tests\Feature;

use App\DataFixtures\Fixture\BrandsFixture;
use App\DataFixtures\Fixture\ImagesFixture;
use App\Entity\Image;
use App\Entity\Product\ClothProduct;
use App\Entity\ProductImage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductModelTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;

    private const string PRODUCT_NAME = 'Pantalon été toile légère Blanc';

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
    }

    public function test_productPantalonIsCreatedWithoutImage(): void
    {
        $brandRepository = $this->entityManager->getRepository(\App\Entity\Brand::class);
        $brand3 = $brandRepository->findOneBy(['name' => BrandsFixture::BRAND_LABEL_3]) ?? null;

        $product = new ClothProduct();
        $product->setName(self::PRODUCT_NAME)
            ->setDescription("Pantalon été toile légère Blanc. Petites poches pratiques. Fermeture à boutons simili ivoire.")
            ->setMoreInfo("Lavage à 30°;100% coton")
            ->setPrice(29.9)
            ->setBrand($brand3);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $repository = $this->entityManager->getRepository(ClothProduct::class);
        $product = $repository->findOneBy(['name' => self::PRODUCT_NAME]);

        $this->assertStringContainsString("toile", $product?->getName());
    }

    public function test_productPantalonWithoutImageIsDeleted(): void
    {
        $repository = $this->entityManager->getRepository(Product::class);
        $product = $repository->findOneBy(['name' => self::PRODUCT_NAME]);

        if ($product) {
            $this->entityManager->remove($product);
            $this->entityManager->flush();
        }

        $product = $repository->findOneBy(['name' => self::PRODUCT_NAME]);
        $this->assertNull($product);
    }

    public function test_productPantalonIsCreatedWithImages(): void
    {
        $brandRepository = $this->entityManager->getRepository(\App\Entity\Brand::class);
        $brand3 = $brandRepository->findOneBy(['name' => BrandsFixture::BRAND_LABEL_3]) ?? null;

        $product = new ClothProduct();
        $product->setName(self::PRODUCT_NAME)
            ->setDescription("Pantalon été toile légère Blanc. Petites poches pratiques. Fermeture à boutons simili ivoire.")
            ->setMoreInfo("Lavage à 30°;100% coton")
            ->setPrice(29.9)
            ->setBrand($brand3);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $imageRepository = $this->entityManager->getRepository(Image::class);
        $image1 = $imageRepository->findOneBy(['alt' => ImagesFixture::IMAGE_LABEL_1]) ?? null;
        $image2 = $imageRepository->findOneBy(['alt' => ImagesFixture::IMAGE_LABEL_2]) ?? null;
        $image3 = $imageRepository->findOneBy(['alt' => ImagesFixture::IMAGE_LABEL_3]) ?? null;

        $productImage1 = new ProductImage();
        $productImage1->setProduct($product)->setImage($image1);

        $productImage2 = new ProductImage();
        $productImage2->setProduct($product)->setImage($image2);

        $productImage3 = new ProductImage();
        $productImage3->setProduct($product)->setImage($image3);

        $this->entityManager->persist($productImage1);
        $this->entityManager->persist($productImage2);
        $this->entityManager->persist($productImage3);
        $this->entityManager->flush();

        $repository = $this->entityManager->getRepository(ProductImage::class);
        $images = $repository->findBy(['product' => $product]);

        $this->assertCount(3, $images);
    }

    public function test_productPantalonWithImagesIsDeleted(): void
    {
        $repository = $this->entityManager->getRepository(ClothProduct::class);
        $product = $repository->findOneBy(['name' => self::PRODUCT_NAME]);

        if ($product) {
            $this->entityManager->remove($product);
            $this->entityManager->flush();
        }

        $product = $repository->findOneBy(['name' => self::PRODUCT_NAME]);
        $this->assertNull($product);
    }
}
