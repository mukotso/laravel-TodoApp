<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Class RegisterTest
 * @package Tests\Feature\Auth
 *
 * @group auth
 */
class RegisterTest extends TestCase
{



    public function it_can_register_a_user()
    {
        // Given
        Event::fake();

        // When
        $response = $this->post(route('register'), [
            'name' => 'daniel',
            'email' => 'dan.dious@email.com',
            'password' => 'february2020',
            'password_confirmation' => 'february2020'
        ]);

        // Then
        $users = User::all();
        $user = $users->first();
        $this->assertCount(1, $users);
        $this->assertAuthenticatedAs($user);
        $this->assertEquals('John Smith', $user->name);
        $this->assertEquals('john.smith@email.com', $user->email);
        $this->assertTrue(Hash::check('password', $user->password));
        Event::assertDispatched(Registered::class, function ($e) use ($user) {
            return $e->user->id === $user->id;
        });
    }

    /** @test */
    public function it_validates_a_user_without_name()
    {
        // Given
        Event::fake();

        // When
        $response = $this->post(route('register'), [
            'name' => '',
            'email' => 'dan.dious@email.com',
            'password' => 'february2020',
            'password_confirmation' => 'february2020'
        ]);

        // Then
        $users = User::all();
        $this->assertCount(0, $users);
        $this->assertGuest();
        $response->assertSessionHasErrors('name');
        Event::assertNotDispatched(Registered::class);
    }

    /** @test */
    public function it_validates_a_user_without_email()
    {
        // Given
        Event::fake();

        // When
        $response = $this->post(route('register'), [
            'name' => 'daniel',
            'email' => '',
            'password' => 'february2020',
            'password_confirmation' => 'february2020'
        ]);

        // Then
        $users = User::all();
        $this->assertCount(0, $users);
        $this->assertGuest();
        $response->assertSessionHasErrors('email');
        Event::assertNotDispatched(Registered::class);

    }

    /** @test */
    public function it_validates_a_user_without_password()
    {
        // Given
        Event::fake();

        // When
        $response = $this->post(route('register'), [
            'name' => 'daniel',
            'email' => 'dan.dious@email.com',
            'password' => '',
            'password_confirmation' => 'february2020'
        ]);

        // Then
        $users = User::all();
        $this->assertCount(0, $users);
        $this->assertGuest();
        $response->assertSessionHasErrors('password');
        Event::assertNotDispatched(Registered::class);

    }

    /** @test */
    public function it_validates_a_user_without_password_confirmation()
    {
        // Given
        Event::fake();

        // When
        $response = $this->post(route('register'), [
            'name' => 'daniel',
            'email' => 'dan.dious@email.com',
            'password' => 'february2020',
            'password_confirmation' => ''
        ]);

        // Then
        $users = User::all();
        $this->assertCount(0, $users);
        $this->assertGuest();
        $response->assertSessionHasErrors('password');
        Event::assertNotDispatched(Registered::class);

    }

    /** @test */
    public function it_validates_a_user_without_matching_password()
    {
        // Given
        Event::fake();

        // When
        $response = $this->post(route('register'), [
            'name' => 'daniel',
            'email' => 'dan.dious@email.com',
            'password' => 'february2020',
            'password_confirmation' => 'baloziii2019'
        ]);

        // Then
        $users = User::all();
        $this->assertCount(0, $users);
        $this->assertGuest();
        $response->assertSessionHasErrors('password');
        Event::assertNotDispatched(Registered::class);

    }


}
