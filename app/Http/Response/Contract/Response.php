<?php

namespace App\Http\Response\Contract;

interface Response
{
    public function getBody();

    public function setBody($body);

    public function toResponse(): array;
}
