<?php
/**
 * Created by PhpStorm.
 * User: richie
 * Date: 06/09/17
 * Time: 21:02
 */

namespace App\Http\Controllers;

use Carbon\Carbon;

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

    public function store()
    {
        return $this->successJsonResponse([]);
    }

}