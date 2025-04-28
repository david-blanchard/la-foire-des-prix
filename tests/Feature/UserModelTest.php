<?php

namespace Tests\Feature;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserModelTest extends WebTestCase
{
    public function test_registrationWithEmailIsValid(): void
    {
        $client = static::createClient();
        $faker = \Faker\Factory::create();
        $email = $faker->unique()->email;

        // Compter les utilisateurs avant l'inscription
        $usersCountBefore = $this->getUserCount();

        // Effectuer une requête POST pour l'inscription
        $client->request('POST', '/register', [
            "name" => "test",
            "email" => $email,
            "password" => "@demo1234#",
            "password_confirmation" => "@demo1234#",
        ]);

        // Compter les utilisateurs après l'inscription
        $usersCountAfter = $this->getUserCount();

        $this->assertEquals($usersCountBefore + 1, $usersCountAfter);

        // Supprimer l'utilisateur créé
        $this->deleteUser($email);
    }

    public function test_registrationWithoutEmailIsInvalid(): void
    {
        $client = static::createClient();

        // Compter les utilisateurs avant l'inscription
        $usersCountBefore = $this->getUserCount();

        // Effectuer une requête POST pour l'inscription
        $client->request('POST', '/register', [
            "name" => "test",
            "email" => "",
            "password" => "@demo1234#",
            "password_confirmation" => "@demo1234#",
        ]);

        // Compter les utilisateurs après l'inscription
        $usersCountAfter = $this->getUserCount();

        $this->assertEquals($usersCountBefore, $usersCountAfter);
    }

    private function getUserCount(): int
    {
        // Simuler une méthode pour compter les utilisateurs
        $client = static::createClient();
        $client->request('GET', '/api/users/count'); // Remplacez par une route réelle
        $response = $client->getResponse();

        return json_decode($response->getContent(), true)['count'] ?? 0;
    }

    private function deleteUser(string $email): void
    {
        // Simuler une méthode pour supprimer un utilisateur
        $client = static::createClient();
        $client->request('DELETE', '/api/users', ['email' => $email]); // Remplacez par une route réelle
    }
}
