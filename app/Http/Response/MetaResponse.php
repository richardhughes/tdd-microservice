<?php

namespace App\Http\Response;

use App\Http\Response\Contract\Response;
use Carbon\Carbon;

class MetaResponse implements Response
{
    private $body;

    public function getBody()
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

    public function setBody($body)
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
