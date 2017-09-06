<?php

namespace Tests\Acceptance\Http\Controllers;

use TestCase;

class AuthenticationControllerTest extends TestCase
{
    public function testGetAuthenticationTokenFromAuthenticationEndpoint()
    {
        $this
            ->json('GET', '/authenticate')
            ->seeJson([
                'token' => 'this-is-a-token'
            ]);
    }
}