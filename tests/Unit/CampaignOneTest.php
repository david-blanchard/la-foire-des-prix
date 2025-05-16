<?php

namespace App\Tests\Unit;

use App\DataFixtures\Fixture\CampaignsFixture;
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
     * Test si une campagne avec l'ID 1 existe.
     */
    public function testCampaignOneExists(): void
    {
        $campaign = $this->entityManager->getRepository(Campaign::class)->findOneBy(['name' => CampaignsFixture::CAMPAIGN_LABEL_1]);

        $this->assertNotNull($campaign);
    }

    /**
     * Test si la campagne de réduction de printemps est de 15%.
     */
    public function testCampaignOneDiscountRateIs15Percents(): void
    {
        $campaign = $this->entityManager->getRepository(Campaign::class)->findOneBy(['name' => CampaignsFixture::CAMPAIGN_LABEL_1]);

        $this->assertEquals(15, $campaign->getDiscount());
    }
}
