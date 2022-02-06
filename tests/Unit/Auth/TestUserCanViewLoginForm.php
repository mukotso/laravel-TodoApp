<?php

namespace Tests\Unit\Auth;


use PHPUnit\Framework\TestCase;

class TestUserCanViewLoginForm extends TestCase
{

    public function testUserCanViewLoginForm()
    {
        //make request to /login
        $response = $this->get('/login');
        //if request successful
        //check if we have served the correct view
        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }
}
