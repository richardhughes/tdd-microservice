<?php

namespace Tests\Unit\Http\Response;

use App\Http\Response\MetaResponse;
use TestCase;

class MetaResponseTest extends TestCase
{
    public function testMetaResponseExists()
    {
        $this->assertInstanceOf(MetaResponse::class, new MetaResponse());
    }

    public function testGetBodyReturnsArray()
    {
        $metaResponse = new MetaResponse();
        $this->assertSame([], $metaResponse->getBody());
    }

}