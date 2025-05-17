<?php

namespace App\DataFixtures;

use App\Entity\Campaign;
use App\Entity\Product\ClothProduct;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CampaignProductsFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $campaignRepository = $manager->getRepository(Campaign::class);
        $productRepository = $manager->getRepository(ClothProduct::class);

        $data = [
            ['campaign' => CampaignsFixture::CAMPAIGN_LABEL_1, 'product' => ProductsFixture::PRODUCT_LABEL_1],
            ['campaign' => CampaignsFixture::CAMPAIGN_LABEL_2, 'product' => ProductsFixture::PRODUCT_LABEL_1],
            ['campaign' => CampaignsFixture::CAMPAIGN_LABEL_2, 'product' => ProductsFixture::PRODUCT_LABEL_2],
        ];

        foreach ($data as $item) {
            $campaign = $campaignRepository->findOneBy(['name' => $item['campaign']]);
            $product = $productRepository->findOneBy(['name' => $item['product']]);
            $campaignProduct = new Campaign\ClothProductCampaign();
            $campaignProduct->setCampaign($campaign);
            $campaignProduct->setProduct($product);
            $campaignProduct->setProductId((int) $product?->getId());
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
