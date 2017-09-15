<?php

namespace Tests\Acceptance\Http\Controllers;

use App\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
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

    public function testAuthenticationEndpointReturnsTrueWhenUserIsFound()
    {
        factory(User::class)->create([
            'username' => 'eeuc40'
        ]);

        $this->authenticateRequest('eeuc40', 'testing123')
            ->seeStatusCode(200)
            ->seeJson([
                'payload' => true
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