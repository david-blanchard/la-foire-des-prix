<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DatabaseFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $adminFixture = new AdminFixture();
        $adminFixture->load($manager);

        $userFixture = new UserFixture();
        $userFixture->load($manager);

        $brandsFixture = new BrandsFixture();
        $brandsFixture->load($manager);

        $imagesFixture = new ImagesFixture();
        $imagesFixture->load($manager);

        $productsFixture = new ProductsFixture();
        $productsFixture->load($manager);

        $productImagesFixture = new ProductImagesFixture();
        $productImagesFixture->load($manager);

        $campaignsFixture = new CampaignsFixture();
        $campaignsFixture->load($manager);

        $campaignProductsFixture = new CampaignProductsFixture();
        $campaignProductsFixture->load($manager);
    }
}
