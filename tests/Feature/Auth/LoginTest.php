<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;


class LoginTest extends TestCase
{

    public function test_example()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('login');
        $response->assertDontSee('todos');
    }

    public function testUserCanViewLoginForm()
    {
        //make request to /login
        $response = $this->get('/login');
        //if request successful
        //check if we have served the correct view
        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }

    public function testUserCannotViewLoginFormWhenAuthenticated()
    {
        $user = User::factory()->make();
        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/todo');
    }

    public function testUserLoginWithCorrectCredentials()
    {
        $password = "myPassword@2020";
        $user = User::factory()->create([
            'password' => bcrypt($password),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/todo');
        $this->assertAuthenticatedAs($user);
    }


//    public function testCannotLoginIfUserDontExist()
//    {
//
//        $response = $this->post(route('login'), [
//                'email' => 'funn@gmail.com',
//                'password' => 'mastercard',
//            ]);
//
//        // Then
//        $response->assertRedirect(route('login'));
//        $response->assertSessionHasErrors('email');
//        $this->assertGuest();
//    }


    public function testUserLogout()
    {
        // Given
        $user = User::factory()->create();
        $this->be($user);

        // When
        $this->post(route('logout'));

        // Then
        $this->assertGuest();
    }


}
