<?php

namespace App\Http\Response;

class MetaResponse
{
    public function getBody(): array
    {
        return [
            'meta' => []
        ];
    }

    public function setBody(array $data)
    {
        return $data;
    }
}