<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CityFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            CountryFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->listOfCities() as $cityData) {
            $existingCity = $manager->getRepository(City::class)->findOneBy([
                'name' => $cityData['name'],
                'zipcode' => $cityData['zipcode']
            ]);

            if (!$existingCity) {
                $city = new City();
                $city->setName($cityData['name']);
                $city->setZipcode($cityData['zipcode']);

                // Récupérer le pays existant (créé par CountryFixtures)
                $country = $manager->getRepository(Country::class)->find($cityData['country_code']);

                if ($country) {
                    $city->setCountry($country);
                }

                $manager->persist($city);
            }
        }
        $manager->flush();
    }

    private function listOfCities(): array
    {
        return [
            ['name' => 'New York', 'country_code' => 'US', 'zipcode' => '10001'],
            ['name' => 'Los Angeles', 'country_code' => 'US', 'zipcode' => '90001'],
            ['name' => 'Chicago', 'country_code' => 'US', 'zipcode' => '60601'],
            ['name' => 'Houston', 'country_code' => 'US', 'zipcode' => '77001'],
            ['name' => 'Phoenix', 'country_code' => 'US', 'zipcode' => '85001'],
            ['name' => 'Philadelphia', 'country_code' => 'US', 'zipcode' => '19019'],
            ['name' => 'San Antonio', 'country_code' => 'US', 'zipcode' => '78201'],
            ['name' => 'San Diego', 'country_code' => 'US', 'zipcode' => '92101'],
            ['name' => 'Dallas', 'country_code' => 'US', 'zipcode' => '75201'],
            ['name' => 'San Jose', 'country_code' => 'US', 'zipcode' => '95101'],
            ['name' => 'Toronto', 'country_code' => 'CA', 'zipcode' => 'M5H'],
            ['name' => 'Vancouver', 'country_code' => 'CA', 'zipcode' => 'V5K'],
            ['name' => 'Montreal', 'country_code' => 'CA', 'zipcode' => 'H1A'],
            ['name' => 'Calgary', 'country_code' => 'CA', 'zipcode' => 'T1Y'],
            ['name' => 'Ottawa', 'country_code' => 'CA', 'zipcode' => 'K1A'],
            ['name' => 'Edmonton', 'country_code' => 'CA', 'zipcode' => 'T5A'],
            ['name' => 'Mississauga', 'country_code' => 'CA', 'zipcode' => 'L4T'],
            ['name' => 'Winnipeg', 'country_code' => 'CA', 'zipcode' => 'R2C'],
            ['name' => 'Quebec City', 'country_code' => 'CA', 'zipcode' => 'G1A'],
            ['name' => 'Hamilton', 'country_code' => 'CA', 'zipcode' => 'L8K'],
            ['name' => 'London', 'country_code' => 'GB', 'zipcode' => 'EC1A'],
            ['name' => 'Birmingham', 'country_code' => 'GB', 'zipcode' => 'B1'],
            ['name' => 'Leeds', 'country_code' => 'GB', 'zipcode' => 'LS1'],
            ['name' => 'Glasgow', 'country_code' => 'GB', 'zipcode' => 'G1'],
            ['name' => 'Sheffield', 'country_code' => 'GB', 'zipcode' => 'S1'],
            ['name' => 'Bradford', 'country_code' => 'GB', 'zipcode' => 'BD1'],
            ['name' => 'Liverpool', 'country_code' => 'GB', 'zipcode' => 'L1'],
            ['name' => 'Edinburgh', 'country_code' => 'GB', 'zipcode' => 'EH1'],
            ['name' => 'Manchester', 'country_code' => 'GB', 'zipcode' => 'M1'],
            ['name' => 'Bristol', 'country_code' => 'GB', 'zipcode' => 'BS1'],
            ['name' => 'Sydney', 'country_code' => 'AU', 'zipcode' => '2000'],
            ['name' => 'Melbourne', 'country_code' => 'AU', 'zipcode' => '3000'],
            ['name' => 'Brisbane', 'country_code' => 'AU', 'zipcode' => '4000'],
            ['name' => 'Perth', 'country_code' => 'AU', 'zipcode' => '6000'],
            ['name' => 'Adelaide', 'country_code' => 'AU', 'zipcode' => '5000'],
            ['name' => 'Gold Coast', 'country_code' => 'AU', 'zipcode' => '4217'],
            ['name' => 'Canberra', 'country_code' => 'AU', 'zipcode' => '2600'],
            ['name' => 'Newcastle', 'country_code' => 'AU', 'zipcode' => '2300'],
            ['name' => 'Wollongong', 'country_code' => 'AU', 'zipcode' => '2500'],
            ['name' => 'Logan City', 'country_code' => 'AU', 'zipcode' => '4114'],
            ['name' => 'Berlin', 'country_code' => 'DE', 'zipcode' => '10115'],
            ['name' => 'Hamburg', 'country_code' => 'DE', 'zipcode' => '20095'],
            ['name' => 'Munich', 'country_code' => 'DE', 'zipcode' => '80331'],
            ['name' => 'Cologne', 'country_code' => 'DE', 'zipcode' => '50667'],
            ['name' => 'Frankfurt', 'country_code' => 'DE', 'zipcode' => '60311'],
            ['name' => 'Stuttgart', 'country_code' => 'DE', 'zipcode' => '70173'],
            ['name' => 'Düsseldorf', 'country_code' => 'DE', 'zipcode' => '40213'],
            ['name' => 'Dortmund', 'country_code' => 'DE', 'zipcode' => '44135'],
            ['name' => 'Essen', 'country_code' => 'DE', 'zipcode' => '45127'],
            ['name' => 'Leipzig', 'country_code' => 'DE', 'zipcode' => '04109'],
            ['name' => 'Paris', 'country_code' => 'FR', 'zipcode' => '75001'],
            ['name' => 'Marseille', 'country_code' => 'FR', 'zipcode' => '13001'],
            ['name' => 'Lyon', 'country_code' => 'FR', 'zipcode' => '69001'],
            ['name' => 'Toulouse', 'country_code' => 'FR', 'zipcode' => '31000'],
            ['name' => 'Nice', 'country_code' => 'FR', 'zipcode' => '06000'],
            ['name' => 'Nantes', 'country_code' => 'FR', 'zipcode' => '44000'],
            ['name' => 'Strasbourg', 'country_code' => 'FR', 'zipcode' => '67000'],
            ['name' => 'Montpellier', 'country_code' => 'FR', 'zipcode' => '34000'],
            ['name' => 'Bordeaux', 'country_code' => 'FR', 'zipcode' => '33000'],
            ['name' => 'Lille', 'country_code' => 'FR', 'zipcode' => '59000'],
            // Ajout de villes françaises supplémentaires
            ['name' => 'Rennes', 'country_code' => 'FR', 'zipcode' => '35000'],
            ['name' => 'Reims', 'country_code' => 'FR', 'zipcode' => '51100'],
            ['name' => 'Le Havre', 'country_code' => 'FR', 'zipcode' => '76600'],
            ['name' => 'Saint-Étienne', 'country_code' => 'FR', 'zipcode' => '42000'],
            ['name' => 'Toulon', 'country_code' => 'FR', 'zipcode' => '83000'],
            ['name' => 'Grenoble', 'country_code' => 'FR', 'zipcode' => '38000'],
            ['name' => 'Dijon', 'country_code' => 'FR', 'zipcode' => '21000'],
            ['name' => 'Angers', 'country_code' => 'FR', 'zipcode' => '49000'],
            ['name' => 'Nîmes', 'country_code' => 'FR', 'zipcode' => '30000'],
            ['name' => 'Villeurbanne', 'country_code' => 'FR', 'zipcode' => '69100'],
            ['name' => 'Clermont-Ferrand', 'country_code' => 'FR', 'zipcode' => '63000'],
            ['name' => 'Le Mans', 'country_code' => 'FR', 'zipcode' => '72000'],
            ['name' => 'Aix-en-Provence', 'country_code' => 'FR', 'zipcode' => '13100'],
            ['name' => 'Brest', 'country_code' => 'FR', 'zipcode' => '29200'],
            ['name' => 'Limoges', 'country_code' => 'FR', 'zipcode' => '87000'],
            ['name' => 'Tours', 'country_code' => 'FR', 'zipcode' => '37000'],
            ['name' => 'Amiens', 'country_code' => 'FR', 'zipcode' => '80000'],
            ['name' => 'Perpignan', 'country_code' => 'FR', 'zipcode' => '66000'],
            ['name' => 'Boulogne-Billancourt', 'country_code' => 'FR', 'zipcode' => '92100'],
            ['name' => 'Metz', 'country_code' => 'FR', 'zipcode' => '57000'],
            // Préfectures françaises (capitales de département)
            ['name' => 'Ain', 'country_code' => 'FR', 'zipcode' => '01000'], // Bourg-en-Bresse
            ['name' => 'Laon', 'country_code' => 'FR', 'zipcode' => '02000'],
            ['name' => 'Moulins', 'country_code' => 'FR', 'zipcode' => '03000'],
            ['name' => 'Digne-les-Bains', 'country_code' => 'FR', 'zipcode' => '04000'],
            ['name' => 'Gap', 'country_code' => 'FR', 'zipcode' => '05000'],
            ['name' => 'Privas', 'country_code' => 'FR', 'zipcode' => '07000'],
            ['name' => 'Charleville-Mézières', 'country_code' => 'FR', 'zipcode' => '08000'],
            ['name' => 'Foix', 'country_code' => 'FR', 'zipcode' => '09000'],
            ['name' => 'Troyes', 'country_code' => 'FR', 'zipcode' => '10000'],
            ['name' => 'Carcassonne', 'country_code' => 'FR', 'zipcode' => '11000'],
            ['name' => 'Rodez', 'country_code' => 'FR', 'zipcode' => '12000'],
            ['name' => 'Chambéry', 'country_code' => 'FR', 'zipcode' => '73000'],
            ['name' => 'Annecy', 'country_code' => 'FR', 'zipcode' => '74000'],
            ['name' => 'Melun', 'country_code' => 'FR', 'zipcode' => '77000'],
            ['name' => 'Versailles', 'country_code' => 'FR', 'zipcode' => '78000'],
            ['name' => 'Le Mesnil Le Roi', 'country_code' => 'FR', 'zipcode' => '78600'],
            ['name' => 'Niort', 'country_code' => 'FR', 'zipcode' => '79000'],
            ['name' => 'Amiens', 'country_code' => 'FR', 'zipcode' => '80000'], // déjà présent mais on garde
            ['name' => 'Albi', 'country_code' => 'FR', 'zipcode' => '81000'],
            ['name' => 'Montauban', 'country_code' => 'FR', 'zipcode' => '82000'],
            ['name' => 'Draguignan', 'country_code' => 'FR', 'zipcode' => '83300'],
            ['name' => 'Avignon', 'country_code' => 'FR', 'zipcode' => '84000'],
            ['name' => 'La Roche-sur-Yon', 'country_code' => 'FR', 'zipcode' => '85000'],
            ['name' => 'Poitiers', 'country_code' => 'FR', 'zipcode' => '86000'],
            ['name' => 'Auxerre', 'country_code' => 'FR', 'zipcode' => '89000'],
            ['name' => 'Belfort', 'country_code' => 'FR', 'zipcode' => '90000'],
            ['name' => 'Évry', 'country_code' => 'FR', 'zipcode' => '91000'],
            ['name' => 'Nanterre', 'country_code' => 'FR', 'zipcode' => '92000'],
            ['name' => 'Bobigny', 'country_code' => 'FR', 'zipcode' => '93000'],
            ['name' => 'Créteil', 'country_code' => 'FR', 'zipcode' => '94000'],
            ['name' => 'Pontoise', 'country_code' => 'FR', 'zipcode' => '95000'],
            ['name' => 'Gueret', 'country_code' => 'FR', 'zipcode' => '23000'],
            ['name' => 'Périgueux', 'country_code' => 'FR', 'zipcode' => '24000'],
            ['name' => 'Besançon', 'country_code' => 'FR', 'zipcode' => '25000'],
            ['name' => 'Valence', 'country_code' => 'FR', 'zipcode' => '26000'],
            ['name' => 'Évreux', 'country_code' => 'FR', 'zipcode' => '27000'],
            ['name' => 'Chartres', 'country_code' => 'FR', 'zipcode' => '28000'],
            ['name' => 'Quimper', 'country_code' => 'FR', 'zipcode' => '29000'],
            ['name' => 'Lons-le-Saunier', 'country_code' => 'FR', 'zipcode' => '39000'],
            ['name' => 'Mont-de-Marsan', 'country_code' => 'FR', 'zipcode' => '40000'],
            ['name' => 'Blois', 'country_code' => 'FR', 'zipcode' => '41000'],
            ['name' => 'Saint-Étienne', 'country_code' => 'FR', 'zipcode' => '42000'], // déjà présent
            ['name' => 'Le Puy-en-Velay', 'country_code' => 'FR', 'zipcode' => '43000'],
            ['name' => 'Saint-Lô', 'country_code' => 'FR', 'zipcode' => '50000'],
            ['name' => 'Orléans', 'country_code' => 'FR', 'zipcode' => '45000'],
            ['name' => 'Cahors', 'country_code' => 'FR', 'zipcode' => '46000'],
            ['name' => 'Agen', 'country_code' => 'FR', 'zipcode' => '47000'],
            ['name' => 'Mende', 'country_code' => 'FR', 'zipcode' => '48000'],
            ['name' => 'Alençon', 'country_code' => 'FR', 'zipcode' => '61000'],
            ['name' => 'Arras', 'country_code' => 'FR', 'zipcode' => '62000'],
            ['name' => 'Pau', 'country_code' => 'FR', 'zipcode' => '64000'],
            ['name' => 'Tarbes', 'country_code' => 'FR', 'zipcode' => '65000'],
            ['name' => 'Mâcon', 'country_code' => 'FR', 'zipcode' => '71000'],
            ['name' => 'Vesoul', 'country_code' => 'FR', 'zipcode' => '70000'],
            ['name' => 'Rouen', 'country_code' => 'FR', 'zipcode' => '76000'],
            ['name' => 'Mont Saint Aignan', 'country_code' => 'FR', 'zipcode' => '76300'],
            ['name' => 'Saint Etienne du Rouvray', 'country_code' => 'FR', 'zipcode' => '76800'],
            ['name' => 'Épinal', 'country_code' => 'FR', 'zipcode' => '88000'],
            ['name' => 'Ajaccio', 'country_code' => 'FR', 'zipcode' => '20000'],
            ['name' => 'Bastia', 'country_code' => 'FR', 'zipcode' => '20200'],
            ['name' => 'Saint-Denis', 'country_code' => 'FR', 'zipcode' => '97400'], // La Réunion
            ['name' => 'Fort-de-France', 'country_code' => 'FR', 'zipcode' => '97200'], // Martinique
            ['name' => 'Basse-Terre', 'country_code' => 'FR', 'zipcode' => '97100'], // Guadeloupe
            ['name' => 'Cayenne', 'country_code' => 'FR', 'zipcode' => '97300'], // Guyane
            ['name' => 'Mamoudzou', 'country_code' => 'FR', 'zipcode' => '97600'], // Mayotte
        ];
    }

}
