<?php

namespace App\DataFixtures;

use App\Entity\Campaign;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CampaignsFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $campaigns = [
            [
                'name' => "Les Promos Printanières",
                'start' => new \DateTime("2021-03-21"),
                'end' => new \DateTime("2021-06-20"),
                'discount' => 15,
            ],
            [
                'name' => "C'est l'Été sur les Prix !",
                'start' => new \DateTime("2021-06-21"),
                'end' => new \DateTime("2021-09-20"),
                'discount' => 25,
            ],
        ];

        foreach ($campaigns as $data) {
            $campaign = new Campaign();
            $campaign->setName($data['name']);
            $campaign->setStart($data['start']);
            $campaign->setEnd($data['end']);
            $campaign->setDiscount($data['discount']);
            $manager->persist($campaign);
        }

        $manager->flush();
    }
}
