<?php

namespace App\DataFixtures;

use App\DataFixtures\Fixture\AdminFixture;
use App\DataFixtures\Fixture\BillFixture;
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
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $adminFixture = new AdminFixture($this->passwordHasher);
        $adminFixture->execute($manager);

        $userFixture = new UserFixture($this->passwordHasher);
        $userFixture->execute($manager);

        $brandsFixture = new BrandsFixture();
        $brandsFixture->execute($manager);

        $imagesFixture = new ImagesFixture();
        $imagesFixture->execute($manager);

        $productsFixture = new ProductsFixture();
        $productsFixture->execute($manager);

        $productImagesFixture = new ProductImagesFixture();
        $productImagesFixture->execute($manager);

        $campaignsFixture = new CampaignsFixture();
        $campaignsFixture->execute($manager);

        $campaignProductsFixture = new CampaignProductsFixture();
        $campaignProductsFixture->execute($manager);

        $billFixture = new BillFixture();
        $billFixture->execute($manager);
    }
}
