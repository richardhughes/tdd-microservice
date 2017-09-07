<?php

namespace Tests\Acceptance\Http\Controllers;

use Carbon\Carbon;
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

    public function testGetAuthenticationTokenContainsRequestedTime()
    {
        Carbon::setTestNow('2017-09-07 21:00:00');
        $this
            ->json('GET', '/authenticate')
            ->seeJson([
                'token' => 'this-is-a-token',
                'meta' => [
                    'time' => Carbon::now()->toDateTimeString()
                ]
            ]);
    }

    public function testCreateAuthenticationTokenEndpointExists()
    {
        $this
            ->json('POST', '/authenticate')
            ->seeStatusCode(200);
    }

    public function testCreateAuthenticationTokenEndpointReturnsToken()
    {
        Carbon::setTestNow('2017-09-07 21:00:00');
        $this
            ->json('POST', '/authenticate')
            ->seeJson([
                'token' => 'this-is-a-token',
                'meta' => [
                    'time' => Carbon::now()->toDateTimeString()
                ]
            ]);
    }
}