<?php

namespace App\Http\Response;

use Carbon\Carbon;

class MetaResponse
{
    private $body;

    public function getBody(): array
    {
        return $this->body;
    }

    public function toResponse(): array
    {
        return [
            'payload' => $this->getBody(),
            'meta' => $this->getMeta()
        ];
    }

    public function setBody(array $body)
    {
        $this->body = $body;
    }

    public function getMeta(): array
    {
        return [
            'time' => Carbon::now()->toDateTimeString(),
            'hash' => md5(json_encode($this->body))
        ];
    }
}