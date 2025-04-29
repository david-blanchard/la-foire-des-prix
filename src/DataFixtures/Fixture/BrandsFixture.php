<?php

namespace App\DataFixtures\Fixture;

use App\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BrandsFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $brands = [
            'Venca',
            'Jodie',
            'Le Vestiaire',
        ];

        foreach ($brands as $brandName) {
            $brand = new Brand();
            $brand->setName($brandName);
            $manager->persist($brand);
        }

        $manager->flush();
    }
}
