<?php

namespace App\DataFixtures;

use App\Entity\Campaign;
use App\Entity\CampaignProduct;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CampaignProductsFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $campaignProducts = [
            ['campaign' => CampaignsFixture::CAMPAIGN_LABEL_1, 'product' => ProductsFixture::PRODUCT_LABEL_1],
            ['campaign' => CampaignsFixture::CAMPAIGN_LABEL_2, 'product' => ProductsFixture::PRODUCT_LABEL_1],
            ['campaign' => CampaignsFixture::CAMPAIGN_LABEL_2, 'product' => ProductsFixture::PRODUCT_LABEL_2],
        ];

        $campaignRepository = $manager->getRepository(Campaign::class);
        $productRepository = $manager->getRepository(Product::class);

        foreach ($campaignProducts as $key => $data) {
            $campaign = $campaignRepository->findOneBy(['name' => $data['campaign']]) ?? null;
            $product = $productRepository->findOneBy(['name' => $data['product']]) ?? null;

            $campaignProduct = new CampaignProduct();
            $campaignProduct->setCampaign($campaign);
            $campaignProduct->setProduct($product);

            //            $campaign->addCampaignProduct($campaignProduct);

            $manager->persist($campaignProduct);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CampaignsFixture::class,
            ProductsFixture::class,
        ];
    }
}
