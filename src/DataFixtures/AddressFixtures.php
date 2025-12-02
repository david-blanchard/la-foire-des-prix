<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AddressFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Récupérer toutes les villes
        $cities = $manager->getRepository(City::class)->findAll();

        foreach ($cities as $city) {
            // Générer 10 adresses par ville
            for ($i = 0; $i < 10; $i++) {
                $address = new Address();

                // Générer une adresse française réaliste
                $streetNumber = $faker->numberBetween(1, 200);
                $streetName = $faker->streetName();

                $address->setLine1($streetNumber . ' ' . $streetName);

                // Ajouter parfois une ligne 2 (appartement, étage, etc.)
                if ($faker->boolean(30)) {
                    $line2Options = [
                        'Appartement ' . $faker->numberBetween(1, 50),
                        'Bâtiment ' . $faker->randomLetter() . ', Apt ' . $faker->numberBetween(1, 20),
                        $faker->numberBetween(1, 5) . 'ème étage',
                        'Résidence ' . $faker->firstName(),
                        'Chez ' . $faker->lastName()
                    ];
                    $address->setLine2($faker->randomElement($line2Options));
                }

                // Ajouter parfois des détails
                if ($faker->boolean(20)) {
                    $details = $faker->randomElement([
                        'Code d\'accès: ' . $faker->numberBetween(1000, 9999),
                        'Interphone: ' . $faker->lastName(),
                        'Porte bleue',
                        'Au fond de la cour',
                        'Derrière la pharmacie',
                        'À côté du parking'
                    ]);
                    $address->setDetails($details);
                }

                $address->setCity($city);

                $manager->persist($address);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CityFixtures::class,
        ];
    }
}
