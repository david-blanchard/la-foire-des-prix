<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BrandsFixture extends Fixture
{
    public const string BRAND_LABEL_1 = 'Venca';
    public const string BRAND_LABEL_2 = 'Jodie';
    public const string BRAND_LABEL_3 = 'Le Vestiaire';

    public function load(ObjectManager $manager): void
    {
        $brands = [
            self::BRAND_LABEL_1,
            self::BRAND_LABEL_2,
            self::BRAND_LABEL_3,
        ];

        foreach ($brands as $brandName) {
            $brand = new Brand();
            $brand->setName($brandName);
            $manager->persist($brand);
        }

        $manager->flush();
    }
}
