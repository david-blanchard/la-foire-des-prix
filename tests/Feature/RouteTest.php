<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RouteTest extends TestCase
{

    /**
     * Test Mode Femme page
     *
     * @return void
     */
    public function test_modeFemmePageIsFound()
    {
        $response = $this->get('/mode-femme/');

        $response->assertStatus(200);
    }

   /**
     * Test Mode Femme page
     *
     * @return void
     */
    public function test_modeFemmePageWithValidSlugVesteIsFound_1_of_3()
    {
        $response = $this->get('/mode-femme/veste');

        $response->assertStatus(200);
    }

    public function test_modeFemmePageWithValidSlugRobeIsFound_2_of_3()
    {
        $response = $this->get('/mode-femme/robe');

        $response->assertStatus(200);
    }

    public function test_modeFemmePageWithValidSlugMailleIsFound_3_of_3()
    {
        $response = $this->get('/mode-femme/maille');

        $response->assertStatus(200);
    }

    public function test_modeFemmePageWithInvalidSlugPantalonIs_404()
    {
        $response = $this->get('/mode-femme/pantalon');

        $response->assertStatus(404);
    }

    /**
     * Test Admin UI access with simple user role
     *
     * @return void
     */
    public function test_adminUiRedirectToLoginAsGuest()
    {
        $response = $this->get('/admin/');

        $response->assertRedirect('/login');
    }

    /**
     * Test Admin UI access with simple user role
     *
     * @return void
     */
    public function test_adminUiRequestAsAdminIsValid()
    {
        $admin = Auth::loginUsingId(1);
        $this->actingAs($admin);
        $response = $this->get('/admin/');

        $response->assertStatus(200);
    }

    /**
     * Test Admin UI access with simple user role
     *
     * @return void
     */
    public function test_adminUiEditProductOneIsValid()
    {
        $admin = Auth::loginUsingId(1);
        $this->actingAs($admin);
        $response = $this->get('/admin/products/1/edit');

        $response->assertStatus(200);
    }


}
