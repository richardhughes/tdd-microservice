<?php

namespace Tests\Acceptance\Http\Controllers;

use TestCase;

class RegisterControllerTest extends TestCase
{
    public function testRegisterEndpointExists()
    {
        $this
            ->json('POST', '/register')
        ->assertResponseOk();
    }
}