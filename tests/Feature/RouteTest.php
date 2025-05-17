<?php

namespace App\Tests\Feature;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RouteTest extends WebTestCase
{
    private KernelBrowser $client;

    private const string ADMIN_EMAIL = 'admin@lfdp.fr';
    private const string ADMIN_PASSWORD = 'demo';

    private User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = self::createClient();

        /** @var UserRepository $userRepository */
        $userRepository = $this->client->getContainer()->get(UserRepository::class);
        /* @var User $user */
        $this->adminUser = $userRepository->findOneBy(['email' => self::ADMIN_EMAIL]);
    }

    public function testModeFemmePageIsFound(): void
    {
        $this->client->request('GET', '/mode-femme/');

        $this->assertResponseIsSuccessful();
    }

    public function testModeFemmePageWithValidSlugVesteIsFound(): void
    {
        $this->client->request('GET', '/mode-femme/veste');

        $this->assertResponseIsSuccessful();
    }

    public function testModeFemmePageWithValidSlugRobeIsFound(): void
    {
        $this->client->request('GET', '/mode-femme/robe');

        $this->assertResponseIsSuccessful();
    }

    public function testModeFemmePageWithValidSlugMailleIsFound(): void
    {
        $this->client->request('GET', '/mode-femme/maille');

        $this->assertResponseIsSuccessful();
    }

    public function testModeFemmePageWithInvalidSlugPantalonIs404(): void
    {
        $this->client->request('GET', '/mode-femme/pantalon');

        $this->assertResponseStatusCodeSame(404);
    }

    public function testAdminUiRedirectToLoginAsGuest(): void
    {
        $this->client->request('GET', '/admin');

        $this->assertResponseRedirects('/login');
    }

    public function testLoginWithValidCredentials(): void
    {
        $this->client->loginUser($this->adminUser);

        $csrfToken = self::getContainer()->get('security.csrf.token_manager')->getToken('authenticate')->getValue();

        $this->client->request('POST', '/login', [
            '_username' => self::ADMIN_EMAIL,
            '_password' => self::ADMIN_PASSWORD,
            '_csrf_token' => $csrfToken,
        ]);

        $this->assertResponseRedirects('/admin'); // Vérifie la redirection après connexion
        $this->client->followRedirect();

        $this->assertResponseIsSuccessful(); // Vérifie que la page cible est accessible
    }

    public function testLoginWithInvalidCredentials(): void
    {
        $csrfToken = self::getContainer()->get('security.csrf.token_manager')->getToken('authenticate')->getValue();

        $this->client->request('POST', '/login', [
            '_username' => 'invalid@example.com',
            '_password' => 'wrongpassword',
            '_csrf_token' => $csrfToken,
        ]);

        $this->assertResponseStatusCodeSame(401); // Vérifie que l'accès est refusé
    }

    //    public function test_adminUiRequestAsAdminIsValid(): void
    //    {
    //        $csrfToken = self::getContainer()->get('security.csrf.token_manager')->getToken('authenticate')->getValue();
    //
    //        $this->client->request('POST', '/login', [
    //            '_username' => self::ADMIN_EMAIL,
    //            '_password' => self::ADMIN_PASSWORD,
    //            '_csrf_token' => $csrfToken,
    //        ]);
    //        $this->assertResponseRedirects();
    //        $this->client->followRedirect(); // Suivre la redirection après le login
    //
    //        $this->client->request('GET', '/admin');
    //
    //        $this->assertResponseIsSuccessful();
    //    }
    //
    //    public function test_adminUiEditProductOneIsValid(): void
    //    {
    //        $this->client = self::createClient([], [
    //            'email' => self::ADMIN_EMAIL,
    //            'password'   => self::ADMIN_PASSWORD,
    //        ]);
    //        $this->client->request('POST', '/admin/products/1/edit');
    //
    //        $this->assertResponseIsSuccessful();
    //    }
    //
    //    public function test_adminUiInvalidCredentials(): void
    //    {
    //        $this->client = self::createClient([], [
    //            'email' => 'invalid@example.com',
    //            'password'   => 'wrongpassword',
    //        ]);
    //        $this->client->request('POST', '/admin/');
    //
    //        $this->assertResponseStatusCodeSame(401);
    //    }
}
