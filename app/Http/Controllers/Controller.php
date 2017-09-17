<?php

namespace App\Http\Controllers;

use App\Http\Response\Contract\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function successResponse(Response $data)
    {
        return response()
            ->json($data->toResponse())
            ->setStatusCode(Response::HTTP_OK);
    }
}
