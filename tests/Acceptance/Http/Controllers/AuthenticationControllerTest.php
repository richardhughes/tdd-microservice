<?php

namespace Tests\Acceptance\Http\Controllers;

use App\Http\Response\Contract\Response;
use Carbon\Carbon;
use Mockery;
use TestCase;

class AuthenticationControllerTest extends TestCase
{
    public function testGetAuthenticationTokenFromAuthenticationEndpoint()
    {
        $this
            ->json('GET', '/authenticate')
            ->seeStatusCode(200)
            ->seeJson([
                'token' => 'this-is-a-token'
            ]);
    }

    public function testGetAuthenticationTokenContainsRequestedTime()
    {
        Carbon::setTestNow('2017-09-07 21:00:00');
        $this
            ->json('GET', '/authenticate')
            ->seeStatusCode(200)
            ->seeJson([
                'token' => 'this-is-a-token',
                'meta' => [
                    'time' => Carbon::now()->toDateTimeString()
                ]
            ]);
    }

    public function testCreateAuthenticationTokenEndpointReturnsToken()
    {
        Carbon::setTestNow('2017-09-07 21:00:00');
        $this
            ->json('POST', '/authenticate')
            ->seeStatusCode(200)
            ->seeJson([
                'token' => 'this-is-a-token',
                'meta' => [
                    'time' => Carbon::now()->toDateTimeString()
                ]
            ]);
    }

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
}