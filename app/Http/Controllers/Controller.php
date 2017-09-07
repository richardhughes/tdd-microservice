<?php

namespace App\Http\Controllers;

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

    protected function successJsonResponse(array $data)
    {
        return response()
            ->json($data)
            ->setStatusCode(200);
    }
}
