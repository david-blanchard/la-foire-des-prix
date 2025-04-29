<?php

namespace App\DataFixtures;

use App\DataFixtures\Fixture\AdminFixture;
use App\DataFixtures\Fixture\BrandsFixture;
use App\DataFixtures\Fixture\CampaignProductsFixture;
use App\DataFixtures\Fixture\CampaignsFixture;
use App\DataFixtures\Fixture\ImagesFixture;
use App\DataFixtures\Fixture\ProductImagesFixture;
use App\DataFixtures\Fixture\ProductsFixture;
use App\DataFixtures\Fixture\UserFixture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class DatabaseFixture extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $adminFixture = new AdminFixture($this->passwordHasher);
        $adminFixture->load($manager);

//        $userFixture = new UserFixture($this->passwordHasher);
//        $userFixture->load($manager);
//
//        $brandsFixture = new BrandsFixture();
//        $brandsFixture->load($manager);
//
//        $imagesFixture = new ImagesFixture();
//        $imagesFixture->load($manager);
//
//        $productsFixture = new ProductsFixture();
//        $productsFixture->load($manager);
//
//        $productImagesFixture = new ProductImagesFixture();
//        $productImagesFixture->load($manager);
//
//        $campaignsFixture = new CampaignsFixture();
//        $campaignsFixture->load($manager);
//
//        $campaignProductsFixture = new CampaignProductsFixture();
//        $campaignProductsFixture->load($manager);

//        $manager->flush();
    }
}
