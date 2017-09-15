<?php

namespace Tests\Acceptance\Http\Controllers;

use Illuminate\Hashing\BcryptHasher;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Mockery;
use TestCase;

class RegisterControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testRegisterEndpointRequiredParameters()
    {
        $this->validationFailedExpectation()
            ->seeJson([
                'username' => [
                    'The username field is required.'
                ],
                'password' => [
                    'The password field is required.'
                ]
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

        $this->successfulRegisterRequest($password);

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

    private function successfulRegisterRequest($password)
    {
        return $this
            ->json('POST', '/register', [
                'username' => 'test@example.com',
                'password' => $password
            ])
            ->seeStatusCode(200);
    }

    private function validationFailedExpectation()
    {
        return $this
            ->json('POST', '/register')
            ->seeStatusCode(422);
    }
}