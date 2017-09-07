<?php
/**
 * Created by PhpStorm.
 * User: richie
 * Date: 06/09/17
 * Time: 21:02
 */

namespace App\Http\Controllers;

use Carbon\Carbon;
use Laravel\Lumen\Routing\Controller as BaseController;

class AuthenticateController extends BaseController
{

    public function index()
    {
        return response()->json([
            'token' => 'this-is-a-token',
            'meta' => [
                'time' => Carbon::now()->toDateTimeString()
            ]
        ]);
    }

}