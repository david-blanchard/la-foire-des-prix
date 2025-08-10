<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $existingUser = $manager->getRepository(User::class)->findOneBy(['email' => 'dblanchard1@lfdp.fr']);

        if (!$existingUser) {
            // Create one main user
            $user = new User();
            $user->setEmail('david.b@lfdp.fr');
            $user->setPassword($this->passwordHasher->hashPassword($user, 'demo'));
            $user->setRoles();

            $manager->persist($user);
            $manager->flush();
        }

        // Create 10 random users
        $faker = Factory::create();

        for ($i = 0; $i < 10; ++$i) {
            $userName = $faker->unique()->userName();
            $userEmail = $faker->unique()->safeEmail();

            $existingUser = $manager->getRepository(User::class)->findOneBy(['email' => $userEmail]);

            if (!$existingUser) {
                $user = new User();
                $user->setEmail($userEmail);
                $user->setPassword(
                    $this->passwordHasher->hashPassword($user, 'password')
                );
                $user->setRoles();

                $manager->persist($user);
                $manager->flush();
            }
        }
    }
}
