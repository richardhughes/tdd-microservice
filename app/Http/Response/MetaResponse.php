<?php

namespace App\Http\Response;

class MetaResponse
{
    private $body;

    public function getBody(): array
    {
        return [
            $this->body,
            'meta' => [
                'time' => '2017-09-07 21:00:00'
            ]
        ];
    }

    public function setBody(array $body)
    {
        $this->body = $body;
    }
}