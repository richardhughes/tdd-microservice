<?php
/**
 * Created by PhpStorm.
 * User: richie
 * Date: 06/09/17
 * Time: 21:02
 */

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class AuthenticateController extends Controller
{

    public function index()
    {
        return $this->successJsonResponse([
            'token' => 'this-is-a-token',
            'meta' => [
                'time' => Carbon::now()->toDateTimeString()
            ]
        ]);
    }

    public function store(Request $request)
    {
        return $this->successJsonResponse([
            'token' => 'this-is-a-token',
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'meta' => [
                'time' => Carbon::now()->toDateTimeString()
            ]
        ]);
    }

}