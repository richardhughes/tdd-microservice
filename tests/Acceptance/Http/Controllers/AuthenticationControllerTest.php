<?php

namespace Tests\Acceptance\Http\Controllers;

use App\User;
use Illuminate\Hashing\BcryptHasher;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Mockery;
use TestCase;
use Tymon\JWTAuth\JWTAuth;

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
        $this->passwordHashExpectation(false);

        factory(User::class)->create([
            'username' => 'eeuc40'
        ]);

        $this->authenticateRequest('eeuc40', 'testing123')
            ->seeStatusCode(200)
            ->seeJson([
                'payload' => false
            ]);
    }

    public function testTokenFromJWTLibraryIsGeneratedWhenLoginSuccessful()
    {
        $this->passwordHashExpectation(true);

        $token = 'this-is-a-jwt-token';

        $jwt = Mockery::mock(JWTAuth::class);
        $jwt
            ->shouldReceive('fromUser')
            ->once()
            ->andReturn($token);

        $this->app->instance(JWTAuth::class, $jwt);

        factory(User::class)->create([
            'username' => 'eeuc40'
        ]);

        $this->authenticateRequest('eeuc40', 'testing123')
            ->seeStatusCode(200)
            ->seeJson([
                'payload' => [
                    'token' => $token
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

    private function passwordHashExpectation(bool $return)
    {
        $hash = Mockery::mock(BcryptHasher::class);
        $hash
            ->shouldReceive('check')
            ->once()
            ->andReturn($return);

        $this->app->instance(BcryptHasher::class, $hash);
    }
}