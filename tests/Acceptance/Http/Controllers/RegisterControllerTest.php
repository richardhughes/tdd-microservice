<?php

namespace Tests\Acceptance\Http\Controllers;

use TestCase;

class RegisterControllerTest extends TestCase
{
    public function testRegisterEndpointExists()
    {
        $this
            ->json('POST', '/register', [
                'username' => 'test@example.com',
                'password' => 'securePassword'
            ])
            ->assertResponseOk();
    }

    public function testRegisterEndpointRequiresEmail()
    {
        $this
            ->json('POST', '/register')
            ->assertResponseStatus(422);
    }

    public function testRegisterEndpointRequiredParameters()
    {
        $this
            ->json('POST', '/register')
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

    public function testUserIsCreatedWhenRegistrationIsSuccessful()
    {
        $this
            ->json('POST', '/register', [
                'username' => 'test@example.com',
                'password' => 'securePassword'
            ])
            ->assertResponseOk();

        $this->seeInDatabase('users',[
            'username' => 'test@example.com',
            'password' => 'securePassword'
        ]);
    }

    public function testUsersPasswordIsHashed()
    {
        $this
            ->json('POST', '/register', [
                'username' => 'test@example.com',
                'password' => 'securePassword'
            ])
            ->assertResponseOk();

        $this->seeInDatabase('users',[
            'username' => 'test@example.com',
            'password' => app('hash')->make('securePassword')
        ]);
    }
}