<?php

namespace App\Http\Controllers;

use App\Http\Response\Contract\Response;
use Carbon\Carbon;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @var Carbon
     */
    private $carbon;

    public function __construct(Carbon $carbon)
    {
        $this->carbon = $carbon;
    }

    protected function successResponse(Response $data)
    {
        return response()
            ->json($data->toResponse())
            ->setStatusCode(200);
    }
}
