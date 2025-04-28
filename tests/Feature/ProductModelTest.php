<?php

namespace Tests\Feature;

use App\Entity\Product;
use App\Entity\ProductImage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductModelTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
    }

    public function test_productPantalonIsCreatedWithoutImage(): void
    {
        $product = new Product();
        $product->setName("Pantalon été toile légère Blanc")
            ->setDescription("Pantalon été toile légère Blanc. Petites poches pratiques. Fermeture à boutons simili ivoire.")
            ->setMoreInfos("Lavage à 30°;100% coton")
            ->setPrice(29.9)
            ->setBrand(3);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $repository = $this->entityManager->getRepository(Product::class);
        $products = $repository->findBy(['name' => 'Pantalon été toile légère Blanc']);
        $product = $products[0] ?? null;

        $this->assertNotNull($product);
        $this->assertStringContainsString("toile", $product->getName());
    }

    public function test_productPantalonWithoutImageIsDeleted(): void
    {
        $repository = $this->entityManager->getRepository(Product::class);
        $product = $repository->findOneBy(['name' => 'Pantalon été toile légère Blanc']);

        if ($product) {
            $this->entityManager->remove($product);
            $this->entityManager->flush();
        }

        $product = $repository->findOneBy(['name' => 'Pantalon été toile légère Blanc']);
        $this->assertNull($product);
    }

    public function test_productPantalonIsCreatedWithImages(): void
    {
        $product = new Product();
        $product->setName("Pantalon été toile légère Blanc")
            ->setDescription("Pantalon été toile légère Blanc. Petites poches pratiques. Fermeture à boutons simili ivoire.")
            ->setMoreInfos("Lavage à 30°;100% coton")
            ->setPrice(29.9)
            ->setBrand(3);

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $productImage1 = new ProductImage();
        $productImage1->setProduct($product)->setImage(10);

        $productImage2 = new ProductImage();
        $productImage2->setProduct($product)->setImage(11);

        $productImage3 = new ProductImage();
        $productImage3->setProduct($product)->setImage(12);

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
        $repository = $this->entityManager->getRepository(Product::class);
        $product = $repository->findOneBy(['name' => 'Pantalon été toile légère Blanc']);

        if ($product) {
            $this->entityManager->remove($product);
            $this->entityManager->flush();
        }

        $product = $repository->findOneBy(['name' => 'Pantalon été toile légère Blanc']);
        $this->assertNull($product);
    }
}
