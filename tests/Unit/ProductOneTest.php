<?php

namespace Tests\Unit;

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
        $query = $this->entityManager->createQuery('SELECT p.id FROM App\Entity\Product p WHERE p.id = 1');
        $result = $query->getOneOrNullResult();

        $this->assertNotNull($result);
        $this->assertEquals(1, $result['id']);
    }

    /**
     * Test si le nom du produit 1 est "Veste en jean"
     */
    public function test_productOneIsVesteEnJean(): void
    {
        $query = $this->entityManager->createQuery('SELECT p.name FROM App\Entity\Product p WHERE p.id = 1');
        $result = $query->getOneOrNullResult();

        $this->assertNotNull($result);
        $this->assertStringContainsString('Veste en jean', $result['name']);
    }

    /**
     * Test si le nom du produit 1 ne contient pas "Robe"
     */
    public function test_productOneIsNotRobe(): void
    {
        $query = $this->entityManager->createQuery('SELECT p.name FROM App\Entity\Product p WHERE p.id = 1');
        $result = $query->getOneOrNullResult();

        $this->assertNotNull($result);
        $this->assertStringNotContainsString('Robe', $result['name']);
    }

    /**
     * Test si le prix de "Veste en jean" est de 37.99 euros
     */
    public function test_productOnePriceIs_38_euros(): void
    {
        $query = $this->entityManager->createQuery('SELECT p.price FROM App\Entity\Product p WHERE p.id = 1');
        $result = $query->getOneOrNullResult();

        $this->assertNotNull($result);
        $this->assertEquals(37.99, $result['price']);
    }
}
