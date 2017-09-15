<?php

namespace Tests\Acceptance\Http\Controllers;

use Carbon\Carbon;
use TestCase;

class AuthenticationControllerTest extends TestCase
{
    public function testCreateAuthenticationTokenEndpointReturnsUsernameAndPassword()
    {
        $this
            ->json('POST', '/authenticate', [
                'username' => 'richardhughes',
                'password' => 'securePassword'
            ])
            ->seeStatusCode(200)
            ->seeJson([
                'username' => 'richardhughes',
                'password' => 'securePassword',
            ]);
    }

    public function testCreateAuthenticationTokenEndpointReturnsErrorWhenRequiredParametersAreEmpty()
    {
        $this
            ->json('POST', '/authenticate', [
                'username' => '',
                'password' => ''
            ])
            ->seeStatusCode(422)
            ->seeJson([
                'username' => [
                    'The username field is required.'
                ],
                'password' => [
                    'The password field is required.'
                ]
            ]);
    }
}