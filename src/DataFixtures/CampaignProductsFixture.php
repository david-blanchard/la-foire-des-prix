<?php

namespace App\DataFixtures;

use App\Entity\CampaignProduct;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CampaignProductsFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            ['campaign' => 1, 'product' => 1],
            ['campaign' => 2, 'product' => 1],
            ['campaign' => 2, 'product' => 2],
        ];

        foreach ($data as $item) {
            $campaignProduct = new CampaignProduct();
            $campaignProduct->setCampaign($item['campaign']);
            $campaignProduct->setProduct($item['product']);
            $manager->persist($campaignProduct);
        }

        $manager->flush();
    }
}
