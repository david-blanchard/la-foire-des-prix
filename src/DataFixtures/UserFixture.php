<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class UserFixture extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        // Create one main user
        $user = new User();
        $user->setEmail('dblanchard1@bbox.fr');
        $user->setName('David Blanchard');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'demo'));
        $user->setRole(User::USER_ROLE);

        $manager->persist($user);

        // Create 10 random users
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setName($faker->name());
            $user->setEmail($faker->unique()->safeEmail());
            $user->setEmailVerifiedAt(new \DateTime());
            $user->setPassword(
                $this->passwordHasher->hashPassword($user, 'password')
            );
            $user->setRememberToken(bin2hex(random_bytes(10)));

            $manager->persist($user);
        }

        $manager->flush();
    }
}
