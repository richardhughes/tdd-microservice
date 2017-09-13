<?php

namespace Tests\Acceptance\Http\Controllers;

use Illuminate\Hashing\BcryptHasher;
use Mockery;
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

        $this->seeInDatabase('users', [
            'username' => 'test@example.com',
            'password' => 'securePassword'
        ]);
    }

    /**
     * @dataProvider hashedPasswordDataProvider
     * @param $password
     */
    public function testUsersPasswordIsHashed($password)
    {
        $hash = Mockery::mock(BcryptHasher::class);

        $hashedPassword = app('hash')->make($password);
        $hash
            ->shouldReceive('make')
            ->once()
            ->with($password)
            ->andReturn($hashedPassword);

        $this->app->instance(BcryptHasher::class, $hash);

        $this
            ->json('POST', '/register', [
                'username' => 'test@example.com',
                'password' => $password
            ])
            ->assertResponseOk();

        $this->seeInDatabase('users', [
            'username' => 'test@example.com',
            'password' => $hashedPassword
        ]);
    }

    public function hashedPasswordDataProvider(): array
    {
        return [
            ['securePassword'],
            ['testing123'],
            ['anotherHashedPassword'],
        ];
    }
}