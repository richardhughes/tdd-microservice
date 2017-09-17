<?php

namespace Tests\Acceptance\Http\Controllers;

use App\User;
use Illuminate\Hashing\BcryptHasher;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Mockery;
use TestCase;

class AuthenticationControllerTest extends TestCase
{
    use DatabaseMigrations;

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

    public function testAuthenticationEndpointReturnsFalseWhenUserNotFound()
    {
        $this->authenticateRequest('invalid-user', 'testing123')
            ->seeStatusCode(200)
            ->seeJson([
                'payload' => false
            ]);
    }

    public function testAuthenticationEndpointReturnsFalseOnWrongPassword()
    {
        $hash = Mockery::mock(BcryptHasher::class);
        $hash
            ->shouldReceive('check')
            ->once()
            ->andReturn(false);

        $this->app->instance(BcryptHasher::class, $hash);

        factory(User::class)->create([
            'username' => 'eeuc40'
        ]);

        $this->authenticateRequest('eeuc40', 'testing123')
            ->seeStatusCode(200)
            ->seeJson([
                'payload' => false
            ]);
    }

    public function testSuccessfulLoginProvidesJWTToken()
    {
        $hash = Mockery::mock(BcryptHasher::class);
        $hash
            ->shouldReceive('check')
            ->once()
            ->andReturn(true);

        $this->app->instance(BcryptHasher::class, $hash);

        factory(User::class)->create([
            'username' => 'eeuc40'
        ]);

        $this->authenticateRequest('eeuc40', 'testing123')
            ->seeStatusCode(200)
            ->seeJson([
                'payload' => [
                    'token' => 'this-is-a-token'
                ]
            ]);
    }

    /**
     * @param $username
     * @param $password
     * @return $this
     */
    private function authenticateRequest($username, $password)
    {
        return $this
            ->json('POST', '/authenticate', [
                'username' => $username,
                'password' => $password
            ]);
    }
}