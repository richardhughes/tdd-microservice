<?php

namespace App\Http\Response\Contract;

interface Response
{
    const HTTP_OK = 200;

    public function getBody();

    public function setBody($body);

    public function toResponse(): array;
}
