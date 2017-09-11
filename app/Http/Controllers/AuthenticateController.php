<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class AuthenticateController extends Controller
{
    public function index()
    {
        return $this->withSuccessResponse([
            'token' => 'this-is-a-token',
            'meta' => [
                'time' => Carbon::now()->toDateTimeString()
            ]
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        return $this->withSuccessResponse([
            'token' => 'this-is-a-token',
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'meta' => [
                'time' => Carbon::now()->toDateTimeString()
            ]
        ]);
    }
}
