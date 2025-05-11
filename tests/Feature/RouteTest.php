<?php

namespace App\Tests\Feature;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RouteTest extends WebTestCase
{
    private KernelBrowser $client;

    private const string ADMIN_EMAIL = 'admin@lfdp.fr';
    private const string ADMIN_PASSWORD = 'demo';

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = self::createClient();
    }

    public function test_modeFemmePageIsFound(): void
    {
        $this->client->request('GET', '/mode-femme/');

        $this->assertResponseIsSuccessful();
    }

    public function test_modeFemmePageWithValidSlugVesteIsFound(): void
    {
        $this->client->request('GET', '/mode-femme/veste');

        $this->assertResponseIsSuccessful();
    }

    public function test_modeFemmePageWithValidSlugRobeIsFound(): void
    {
        $this->client->request('GET', '/mode-femme/robe');

        $this->assertResponseIsSuccessful();
    }

    public function test_modeFemmePageWithValidSlugMailleIsFound(): void
    {
        $this->client->request('GET', '/mode-femme/maille');

        $this->assertResponseIsSuccessful();
    }

    public function test_modeFemmePageWithInvalidSlugPantalonIs404(): void
    {
        $this->client->request('GET', '/mode-femme/pantalon');

        $this->assertResponseStatusCodeSame(404);
    }
//
    public function test_adminUiRedirectToLoginAsGuest(): void
    {
        $this->client->request('GET', '/admin');

        $this->assertResponseRedirects('/login');
    }
//
    public function test_adminUiRequestAsAdminIsValid(): void
    {
        $csrfToken = self::getContainer()->get('security.csrf.token_manager')->getToken('authenticate')->getValue();

        $this->client->request('POST', '/login', [
            '_username' => self::ADMIN_EMAIL,
            '_password' => self::ADMIN_PASSWORD,
            '_csrf_token' => $csrfToken,
        ]);
        $this->assertResponseRedirects();
        $this->client->followRedirect(); // Suivre la redirection après le login

        $this->client->request('GET', '/admin');

        $this->assertResponseIsSuccessful();
    }
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
