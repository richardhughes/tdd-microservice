<?php

namespace App\Http\Controllers;

use App\Http\Response\MetaResponse;
use Illuminate\Http\Request;

class AuthenticateController extends Controller
{
    public function store(Request $request, MetaResponse $response)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $response->setBody([
            'token' => 'this-is-a-token',
            'username' => $request->input('username'),
            'password' => $request->input('password')]
        );

        return $this->successResponse($response);
    }
}
