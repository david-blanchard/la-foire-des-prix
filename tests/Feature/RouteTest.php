<?php

namespace Tests\Feature;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RouteTest extends WebTestCase
{
    public function test_modeFemmePageIsFound(): void
    {
        $client = static::createClient();
        $client->request('GET', '/mode-femme/');

        $this->assertResponseIsSuccessful();
    }

    public function test_modeFemmePageWithValidSlugVesteIsFound(): void
    {
        $client = static::createClient();
        $client->request('GET', '/mode-femme/veste');

        $this->assertResponseIsSuccessful();
    }

    public function test_modeFemmePageWithValidSlugRobeIsFound(): void
    {
        $client = static::createClient();
        $client->request('GET', '/mode-femme/robe');

        $this->assertResponseIsSuccessful();
    }

    public function test_modeFemmePageWithValidSlugMailleIsFound(): void
    {
        $client = static::createClient();
        $client->request('GET', '/mode-femme/maille');

        $this->assertResponseIsSuccessful();
    }

    public function test_modeFemmePageWithInvalidSlugPantalonIs404(): void
    {
        $client = static::createClient();
        $client->request('GET', '/mode-femme/pantalon');

        $this->assertResponseStatusCodeSame(404);
    }

    public function test_adminUiRedirectToLoginAsGuest(): void
    {
        $client = static::createClient();
        $client->request('GET', '/admin/');

        $this->assertResponseRedirects('/login');
    }

    public function test_adminUiRequestAsAdminIsValid(): void
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin@example.com',
            'PHP_AUTH_PW'   => 'password',
        ]);
        $client->request('GET', '/admin/');

        $this->assertResponseIsSuccessful();
    }

    public function test_adminUiEditProductOneIsValid(): void
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin@example.com',
            'PHP_AUTH_PW'   => 'password',
        ]);
        $client->request('GET', '/admin/products/1/edit');

        $this->assertResponseIsSuccessful();
    }
}
