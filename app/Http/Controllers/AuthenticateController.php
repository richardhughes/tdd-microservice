<?php

namespace App\Http\Controllers;

use App\Http\Response\MetaResponse;
use App\User;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;

class AuthenticateController extends Controller
{
    /**
     * @var User
     */
    private $user;
    /**
     * @var BcryptHasher
     */
    private $hasher;

    public function __construct(User $user, BcryptHasher $hasher)
    {
        $this->user = $user;
        $this->hasher = $hasher;
    }

    public function store(Request $request, MetaResponse $response)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $token = '';
        $credentials = $request->only('username', 'password');

        $response->setBody(false);
        $user = $this->user
            ->where('username', $request->input('username'))
            ->first();

        if (!empty($user)) {
            $passwordValid = $this->hasher->check($request->input('password'), $user->password);
            $responseArray = $passwordValid;
            if($passwordValid){
                $responseArray = [
                    'token' => 'this-is-a-token'
                ];
            }
            $response->setBody($responseArray);
        }

        return $this->successResponse($response);
    }
}
