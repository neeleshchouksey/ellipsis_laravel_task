<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker;
class RegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserCanRegister()
    {
        $faker = Faker\Factory::create();

        $name = $faker->name;
        $email = $faker->email;
        $password = '12345678';
        $st = 'Indore';
        $ct = 'Indore';
        $stt = 'MP';
        $cut = 'India';

        $response = $this->post($this->baseUrl . '/register', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
            'streetaddress' => $st,
            'city' => $ct,
            'state' => $stt,
            'country' =>$cut,
            'zipcode' => 123456,
        ]);

        $response->assertRedirect($this->baseUrl.'/dashboard');

        $user = User::where("email",$email)->first();

        $this->assertNotNull($user);

        $this->assertAuthenticatedAs($user);

    }
}
