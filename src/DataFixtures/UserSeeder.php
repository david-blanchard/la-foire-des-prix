<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('dblanchard1@bbox.fr');
        $user->setName('David Blanchard');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'demo'));
        $user->setRole(User::USER_ROLE);

        $manager->persist($user);
        $manager->flush();
    }
}
