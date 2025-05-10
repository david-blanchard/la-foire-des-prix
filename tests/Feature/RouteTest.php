<?php

namespace App\Tests\Feature;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RouteTest extends WebTestCase
{
    private KernelBrowser $client;

    private const ADMIN_EMAIL = 'admin@lfdp.fr';
    private const ADMIN_PASSWORD = 'demo';

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

    public function test_adminUiRedirectToLoginAsGuest(): void
    {
        $this->client->request('GET', '/admin/');

        $this->assertResponseRedirects('/login');
    }

    public function test_adminUiRequestAsAdminIsValid(): void
    {
        $this->client = self::createClient([], [
            'email' => self::ADMIN_EMAIL,
            'password'   => self::ADMIN_PASSWORD,
        ]);
        $this->client->request('POST', '/admin/');

        $this->assertResponseIsSuccessful();
    }

    public function test_adminUiEditProductOneIsValid(): void
    {
        $this->client = self::createClient([], [
            'email' => self::ADMIN_EMAIL,
            'password'   => self::ADMIN_PASSWORD,
        ]);
        $this->client->request('POST', '/admin/products/1/edit');

        $this->assertResponseIsSuccessful();
    }

    public function test_adminUiInvalidCredentials(): void
    {
        $this->client = self::createClient([], [
            'email' => 'invalid@example.com',
            'password'   => 'wrongpassword',
        ]);
        $this->client->request('POST', '/admin/');

        $this->assertResponseStatusCodeSame(401);
    }
}
