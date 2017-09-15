<?php

namespace App\Http\Controllers;

use App\Http\Response\MetaResponse;
use App\User;
use Illuminate\Http\Request;

class AuthenticateController extends Controller
{
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function store(Request $request, MetaResponse $response)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $response->setBody(true);
        $user = $this->user
            ->where('username', $request->input('username'))
            ->first();

        if (empty($user)) {
            $response->setBody(false);
        }

        return $this->successResponse($response);
    }
}
