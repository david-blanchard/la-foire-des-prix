<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CountryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        // This fixture is intentionally left blank.
        // You can implement country loading logic here if needed.
        foreach ($this->listOfCountries() as $countryData) {
            $existingCountry = $manager->getRepository(Country::class)->findOneBy([
                'code' => $countryData['code']
            ]);
            if (!$existingCountry) {
                $country = new Country();
                $country->setCode($countryData['code']);
                $country->setName($countryData['name']);
                $manager->persist($country);
            }
        }
        $manager->flush();
    }

    private function listOfCountries(): array
    {
        return [
            ['name' => 'United States', 'code' => 'US'],
            ['name' => 'Canada', 'code' => 'CA'],
            ['name' => 'United Kingdom', 'code' => 'GB'],
            ['name' => 'Australia', 'code' => 'AU'],
            ['name' => 'Germany', 'code' => 'DE'],
            ['name' => 'France', 'code' => 'FR'],
            ['name' => 'Italy', 'code' => 'IT'],
            ['name' => 'Spain', 'code' => 'ES'],
            ['name' => 'Japan', 'code' => 'JP'],
            ['name' => 'China', 'code' => 'CN'],
            // Add more countries as needed
            // Source: https://restcountries.com/v3.1/all
        ];
    }


}
