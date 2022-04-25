<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testUserCanViewLoginForm()
    {
        $response = $this->get($this->baseUrl.'/login');
        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }

    public function testUserCannotViewLoginFormWhenAuthenticated()
    {
        $user = factory(User::class)->make();
        $response = $this->actingAs($user)->get($this->baseUrl.'/login');
        $response->assertRedirect($this->baseUrl.'/dashboard');
    }
    public function testUserCanLoginWithCorrectCredentials()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt($password = '12345678'),
        ]);

        $response = $this->post($this->baseUrl.'/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect($this->baseUrl.'/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function testUserCannotLoginWithIncorrectPassword()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('12345678'),
        ]);

        $response = $this->from($this->baseUrl.'/login')->post($this->baseUrl.'/login', [
            'email' => $user->email,
            'password' => 'invalid-password',
        ]);

        $response->assertRedirect($this->baseUrl.'/login');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }
    public function testRememberMeFunctionality()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt($password = '12345678'),
        ]);

        $response = $this->post($this->baseUrl.'/login', [
            'email' => $user->email,
            'password' => $password,
            'remember' => 'on',
        ]);

        $response->assertRedirect($this->baseUrl.'/dashboard');
        // cookie assertion goes here
        $this->assertAuthenticatedAs($user);
    }
}
