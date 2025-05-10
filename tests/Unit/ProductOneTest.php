<?php

namespace App\Tests\Unit;

use App\DataFixtures\Fixture\ProductsFixture;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductOneTest extends KernelTestCase
{
    private ProductRepository $productRepository;


    protected function setUp(): void
    {
        self::bootKernel();
        $entityManager = self::getContainer()->get(EntityManagerInterface::class);
        $this->productRepository = $entityManager->getRepository(Product::class);
    }

    /**
     * Test si un produit avec l'ID 1 existe
     */
    public function test_productOneExists(): void
    {

        $product1 = $this->productRepository->findOneBy(['name' => ProductsFixture::PRODUCT_LABEL_1]);

        $this->assertNotNull($product1);
    }

    /**
     * Test si le nom du produit 1 est "Veste en jean"
     */
    public function test_productOneIsVesteEnJean(): void
    {
        $product = $this->productRepository->findOneBy(['name' => ProductsFixture::PRODUCT_LABEL_1]);

        $this->assertStringContainsString('Veste en jean', $product?->getName());
    }

    /**
     * Test si le nom du produit 1 ne contient pas "Robe"
     */
    public function test_productOneIsNotRobe(): void
    {
        $product = $this->productRepository->findOneBy(['name' => ProductsFixture::PRODUCT_LABEL_1]);

        $this->assertStringNotContainsString('Robe', $product?->getName());
    }

    /**
     * Test si le prix de "Veste en jean" est de 37.99 euros
     */
    public function test_productOnePriceIs38Euros(): void
    {
        $product = $this->productRepository->findOneBy(['name' => ProductsFixture::PRODUCT_LABEL_1]);

        $this->assertEquals(37.99, $product?->getPrice());
    }
}
