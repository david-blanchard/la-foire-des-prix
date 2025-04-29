<?php

namespace App\Tests\Unit;

use App\Entity\Campaign;
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
        $campaign = $this->entityManager->getRepository(Campaign::class)->find(1);

        $this->assertNotNull($campaign);
        $this->assertEquals(1, $campaign->getId());
    }

    /**
     * Test si la campagne de réduction de printemps est de 15%
     */
    public function test_campaignOneDiscountRateIs_15_percents(): void
    {
        $campaign = $this->entityManager->getRepository(Campaign::class)->find(1);

        $this->assertNotNull($campaign);
        $this->assertEquals(15, $campaign->getDiscount());
    }
}
