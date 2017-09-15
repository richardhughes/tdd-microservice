<?php

namespace App\Http\Controllers;

use App\Http\Response\MetaResponse;
use App\User;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;

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
     * RegisterController constructor.
     * @param User $user
     * @param BcryptHasher $hash
     */
    public function __construct(User $user, BcryptHasher $hash)
    {
        $this->user = $user;
        $this->hasher = $hash;
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
        $response->setBody(true);
        return $this->successResponse($response);
    }
}
