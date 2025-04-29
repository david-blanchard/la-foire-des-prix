<?php

namespace App\DataFixtures\Fixture;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixture extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('admin@lfdp.fr');
        $user->setName('Administrator');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'demo'));
        $user->setRole(User::ADMIN_ROLE);

        $manager->persist($user);
        $manager->flush();
    }
}
