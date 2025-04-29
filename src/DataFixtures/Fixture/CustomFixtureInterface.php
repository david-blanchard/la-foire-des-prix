<?php

namespace App\DataFixtures\Fixture;

use Doctrine\Persistence\ObjectManager;

interface CustomFixtureInterface
{
    public function execute(ObjectManager $manager): void;
}
