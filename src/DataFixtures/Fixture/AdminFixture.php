<?php

namespace App\DataFixtures\Fixture;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixture implements CustomFixtureInterface
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function execute(ObjectManager $manager): void
    {
        $existingUser = $manager->getRepository(User::class)->findOneBy(['email' => 'admin@lfdp.fr']);

        if (!$existingUser) {
            $user = new User();
            $user->setEmail('admin@lfdp.fr');
            $user->setName('Administrator');
            $user->setPassword($this->passwordHasher->hashPassword($user, 'demo'));
            $user->setRole(User::ADMIN_ROLE);
            $user->setRoles([User::ADMIN_ROLE]);

            $manager->persist($user);
            $manager->flush();
        }
    }
}
