<?php

namespace App\Tests\Unit;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductOneTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
    }

    /**
     * Test si un produit avec l'ID 1 existe
     */
    public function test_productOneExists(): void
    {
        $product = $this->entityManager->getRepository(Product::class)->find(1);

        $this->assertNotNull($product);
        $this->assertEquals(1, $product->getId());
    }

    /**
     * Test si le nom du produit 1 est "Veste en jean"
     */
    public function test_productOneIsVesteEnJean(): void
    {
        $product = $this->entityManager->getRepository(Product::class)->find(1);

        $this->assertNotNull($product);
        $this->assertStringContainsString('Veste en jean', $product->getName());
    }

    /**
     * Test si le nom du produit 1 ne contient pas "Robe"
     */
    public function test_productOneIsNotRobe(): void
    {
        $product = $this->entityManager->getRepository(Product::class)->find(1);

        $this->assertNotNull($product);
        $this->assertStringNotContainsString('Robe', $product->getName());
    }

    /**
     * Test si le prix de "Veste en jean" est de 37.99 euros
     */
    public function test_productOnePriceIs_38_euros(): void
    {
        $product = $this->entityManager->getRepository(Product::class)->find(1);

        $this->assertNotNull($product);
        $this->assertEquals(37.99, $product->getPrice());
    }
}
