<?php

namespace App\Http\Controllers;

use App\Http\Response\MetaResponse;
use App\User;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class RegisterController extends Controller
{
    /**
     * @var User
     */
    private $user;
    /**
     * @var BcryptHasher
     */
    private $hasher;
    /**
     * @var JWTAuth
     */
    private $jwt;

    /**
     * RegisterController constructor.
     * @param User $user
     * @param BcryptHasher $hash
     * @param JWTAuth $jwt
     */
    public function __construct(User $user, BcryptHasher $hash, JWTAuth $jwt)
    {
        $this->user = $user;
        $this->hasher = $hash;
        $this->jwt = $jwt;
    }

    public function store(Request $request, MetaResponse $response)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = [
            'username' => $request->input('username'),
            'password' => $this->hasher->make($request->input('password'))
        ];

        $this->user->create($user);
$response->setBody($user);
        return $this->successResponse($response);
    }
}
