<?php

namespace App\DataFixtures\Fixture;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class UserFixture implements CustomFixtureInterface
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function execute(ObjectManager $manager): void
    {
        $existingUser = $manager->getRepository(User::class)->findOneBy(['email' => 'admin@lfdp.fr']);

        if (!$existingUser) {
            // Create one main user
            $user = new User();
            $user->setEmail('dblanchard1@lfdp.fr');
            $user->setName('David Blanchard');
            $user->setPassword($this->passwordHasher->hashPassword($user, 'demo'));
            $user->setRole(User::USER_ROLE);

            $manager->persist($user);
            $manager->flush();
        }

        // Create 10 random users
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {

            $userName = $faker->unique()->userName();
            $userEmail = $faker->unique()->safeEmail();

            $existingUser = $manager->getRepository(User::class)->findOneBy(['email' => $userEmail]);

            if (!$existingUser) {

                $user = new User();
                $user->setName($userName);
                $user->setEmail($userEmail);
                $user->setEmailVerifiedAt(new \DateTime());
                $user->setPassword(
                    $this->passwordHasher->hashPassword($user, 'password')
                );
                $user->setRole(User::USER_ROLE);
                $user->setRememberToken(bin2hex(random_bytes(10)));

                $manager->persist($user);
                $manager->flush();
            }

        }

    }
}
