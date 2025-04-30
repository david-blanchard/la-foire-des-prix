<?php

namespace App\Tests\Feature;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserModelTest extends WebTestCase
{
//    private KernelBrowser $client;

//    protected function setUp(): void
//    {
//        parent::setUp();
//        $this->client = self::createClient();
//    }

//    public function test_registrationWithEmailIsValid(): void
//    {
//        $faker = \Faker\Factory::create();
//        $email = $faker->unique()->email;
//
//        // Compter les utilisateurs avant l'inscription
//        $usersCountBefore = $this->getUserCount();
//
//        // Effectuer une requête POST pour l'inscription
//        $this->client->request('POST', '/register', [
//            "name" => "test",
//            "email" => $email,
//            "password" => "@demo1234#",
//            "password_confirmation" => "@demo1234#",
//        ]);
//
//        // Compter les utilisateurs après l'inscription
//        $usersCountAfter = $this->getUserCount();
//
//        $this->assertEquals($usersCountBefore + 1, $usersCountAfter);
//
//        // Supprimer l'utilisateur créé
//        $this->deleteUser($email);
//    }

//    public function test_registrationWithoutEmailIsInvalid(): void
//    {
//        // Compter les utilisateurs avant l'inscription
//        $usersCountBefore = $this->getUserCount();
//
//        // Effectuer une requête POST pour l'inscription
//        $this->client->request('POST', '/register', [
//            "name" => "test",
//            "email" => "",
//            "password" => "@demo1234#",
//            "password_confirmation" => "@demo1234#",
//        ]);
//
//        // Compter les utilisateurs après l'inscription
//        $usersCountAfter = $this->getUserCount();
//
//        $this->assertEquals($usersCountBefore, $usersCountAfter);
//    }

//    private function getUserCount(): int
//    {
//        // Simuler une méthode pour compter les utilisateurs
//        $this->client->request('GET', '/api/users/count'); // Remplacez par une route réelle
//        $response = $this->client->getResponse();
//
//        return json_decode($response->getContent(), true)['count'] ?? 0;
//    }

//    private function deleteUser(string $email): void
//    {
//        // Simuler une méthode pour supprimer un utilisateur
//        $this->client->request('DELETE', '/api/users', ['email' => $email]); // Remplacez par une route réelle
//    }
}
