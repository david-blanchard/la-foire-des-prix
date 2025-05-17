<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixture extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $existingUser = $manager->getRepository(User::class)->findOneBy(['email' => 'admin@lfdp.fr']);

        if (!$existingUser) {
            $user = new User();
            $user->setEmail('admin@lfdp.fr');
            $user->setPassword($this->passwordHasher->hashPassword($user, 'demo'));
            $user->setRoles([User::ADMIN_ROLE]);

            $manager->persist($user);
            $manager->flush();
        }
    }
}
