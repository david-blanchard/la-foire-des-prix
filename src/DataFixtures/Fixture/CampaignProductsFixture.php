<?php

namespace App\DataFixtures\Fixture;

use App\Entity\Campaign;
use App\Entity\CampaignProduct;
use App\Entity\Product\ClothProduct;
use Doctrine\Persistence\ObjectManager;

class CampaignProductsFixture implements CustomFixtureInterface
{
    public function execute(ObjectManager $manager): void
    {
        $campaignRepository = $manager->getRepository(Campaign::class);
        $productRepository = $manager->getRepository(ClothProduct::class);

        $data = [
            ['campaign' => CampaignsFixture::CAMPAIGN_LABEL_1, 'product' => ProductsFixture::PRODUCT_LABEL_1],
            ['campaign' => CampaignsFixture::CAMPAIGN_LABEL_2, 'product' => ProductsFixture::PRODUCT_LABEL_1],
            ['campaign' => CampaignsFixture::CAMPAIGN_LABEL_2, 'product' => ProductsFixture::PRODUCT_LABEL_2],
        ];

        foreach ($data as $item) {
            $campaign = $campaignRepository->findOneBy(['name' => $item['campaign']]) ?? null;
            $product = $productRepository->findOneBy(['name' => $item['product']]) ?? null;
            $campaignProduct = new CampaignProduct();
            $campaignProduct->setCampaign($campaign);
            $campaignProduct->setProduct($product);
            $manager->persist($campaignProduct);
        }

        $manager->flush();
    }
}
