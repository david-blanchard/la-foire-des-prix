<?php

namespace App\DataFixtures;

use App\Entity\Campaign;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CampaignsFixture extends Fixture
{
    public const string CAMPAIGN_LABEL_1 = 'Les Promos Printanières';
    public const string CAMPAIGN_LABEL_2 = "C'est l'Été sur les Prix !";

    public function load(ObjectManager $manager): void
    {
        $campaigns = [
            [
                'name' => self::CAMPAIGN_LABEL_1,
                'start' => new \DateTimeImmutable('2021-03-21'),
                'end' => new \DateTimeImmutable('2021-06-20'),
                'discount' => 15,
            ],
            [
                'name' => self::CAMPAIGN_LABEL_2,
                'start' => new \DateTimeImmutable('2021-06-21'),
                'end' => new \DateTimeImmutable('2021-09-20'),
                'discount' => 25,
            ],
        ];

        foreach ($campaigns as $key => $data) {
            $campaign = new Campaign();
            $campaign->setName($data['name']);
            $campaign->setStartsAt($data['start']);
            $campaign->setEndsAt($data['end']);
            $campaign->setDiscount($data['discount']);
            $manager->persist($campaign);
        }

        $manager->flush();
    }
}
