<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Address;
use App\Enum\UserGender;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Récupérer toutes les adresses disponibles
        $addresses = $manager->getRepository(Address::class)->findAll();

        if (empty($addresses)) {
            throw new \Exception('Aucune adresse disponible. Assurez-vous que AddressFixtures a été exécuté.');
        }

        $existingUser = $manager->getRepository(User::class)->findOneBy(['email' => 'david.b@lfdp.fr']);

        if (!$existingUser) {
            // Create one main user
            $user = new User();
            $user->setGender($faker->randomElement([UserGender::MALE, UserGender::FEMALE]));
            $user->setFirstName('David');
            $user->setLastName('Blanchard');
            $user->setEmail('david.b@lfdp.fr');
            $user->setPassword($this->passwordHasher->hashPassword($user, 'demo'));
            $user->setRoles();

            // Ajouter une adresse aléatoire
            $randomAddress = $faker->randomElement($addresses);
            $user->addAddress($randomAddress);

            $manager->persist($user);
            $manager->flush();
        }

        // Create 10 random users
        for ($i = 0; $i < 150; ++$i) {
            $firstName = $faker->firstName();
            $lastName = $faker->lastName();
            $userEmail = strtolower($firstName . '.' . $lastName . '@lfdp.fr');

            $existingUser = $manager->getRepository(User::class)->findOneBy(['email' => $userEmail]);

            if (!$existingUser) {
                $user = new User();
                $user->setGender($faker->randomElement([UserGender::MALE, UserGender::FEMALE]));
                $user->setFirstName($firstName);
                $user->setLastName($lastName);
                $user->setEmail($userEmail);
                $user->setPassword(
                    $this->passwordHasher->hashPassword($user, 'password')
                );
                $user->setRoles();

                // Ajouter une adresse aléatoire
                $randomAddress = $faker->randomElement($addresses);
                $user->addAddress($randomAddress);

                $manager->persist($user);
                $manager->flush();
            }
        }
    }

    public function getDependencies(): array
    {
        return [
            AddressFixtures::class,
        ];
    }
}
