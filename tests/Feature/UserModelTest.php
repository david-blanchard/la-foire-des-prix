<?php

namespace Tests\Feature;

use App\Models\User;
use Faker\Factory;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    // use RefreshDatabase;

    /**
     * Test if registration is valid.
     *
     * @return void
     */
    public function test_registrationWithEmailIsValid()
    {
        $faker = Factory::create();
        $email = $faker->unique()->email;
        $usersCountBefore = User::count();

        $this->post("/register", [
            "name" => "test",
            "email" => $email,
            "password" => "@demo1234#",
            "password_confirmation" => "@demo1234#",
        ]);

        $usersCountAfter = User::count();
        
        $this->assertEqualsWithDelta($usersCountAfter, $usersCountBefore, 1.0);

        $this->deleteUser($email);
    }

    /**
     * Test if registration is invalid.
     *
     * @return void
     */
    public function test_registrationWithoutEmailIsInvalid()
    {
        $usersCountBefore = User::count();

        $this->post("/register", [
            "name" => "test",
            "email" => "",
            "password" => "@demo1234#",
            "password_confirmation" => "@demo1234#",
        ]);

        $usersCountAfter = User::count();
        
        $this->assertEqualsWithDelta($usersCountAfter, $usersCountBefore, 0);

    }


    public function deleteUser($email)
    {
        $user = DB::table('users')->where('email', '=',  $email)->delete();
    }
}
