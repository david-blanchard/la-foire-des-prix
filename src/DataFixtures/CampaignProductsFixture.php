<?php

namespace App\DataFixtures;

use App\Entity\Campaign;
use App\Entity\CampaignProduct;
use App\Entity\Product;
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

        $campaignRepository = $manager->getRepository(Campaign::class);
        $productRepository = $manager->getRepository(Product::class);

        foreach ($data as $item) {
            $campaign = $campaignRepository->find($item['campaign']);
            $product = $productRepository->find($item['product']);
            $campaignProduct = new CampaignProduct();
            $campaignProduct->setCampaign($campaign);
            $campaignProduct->setProduct($product);
            $manager->persist($campaignProduct);
        }

        $manager->flush();
    }
}
