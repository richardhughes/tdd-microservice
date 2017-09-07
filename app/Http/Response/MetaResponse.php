<?php

namespace App\Http\Response;

class MetaResponse
{
    private $body;

    public function getBody(): array
    {
        return [
            $this->body,
            'meta' => []
        ];
    }

    public function setBody(array $body)
    {
        $this->body = $body;
    }
}