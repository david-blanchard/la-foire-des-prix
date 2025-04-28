<?php

namespace Tests\Unit;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CampaignOneTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
    }

    /**
     * Test si une campagne avec l'ID 1 existe
     */
    public function test_campaignOneExists(): void
    {
        $query = $this->entityManager->createQuery('SELECT c.id FROM App\Entity\Campaign c WHERE c.id = 1');
        $result = $query->getOneOrNullResult();

        $this->assertNotNull($result);
        $this->assertEquals(1, $result['id']);
    }

    /**
     * Test si la campagne de réduction de printemps est de 15%
     */
    public function test_campaignOneDiscountRateIs_15_percents(): void
    {
        $query = $this->entityManager->createQuery('SELECT c.discount FROM App\Entity\Campaign c WHERE c.id = 1');
        $result = $query->getOneOrNullResult();

        $this->assertNotNull($result);
        $this->assertEquals(15, $result['discount']);
    }
}
