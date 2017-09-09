<?php

namespace App\Http\Response\Contract;

interface Response
{
    public function getBody(): array;

    public function setBody(array $body);

    public function toResponse(): array;
}