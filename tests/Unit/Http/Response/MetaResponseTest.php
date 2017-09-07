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

    public function testGetBodyContainsMetaData()
    {
        $metaResponse = new MetaResponse();
        $this->assertSame([
            'meta' => []
        ], $metaResponse->getBody());
    }

    public function testWeCanSetDataOnTheResponse()
    {
        $metaResponse = new MetaResponse();
        $this->assertSame([], $metaResponse->setBody([]));
    }

}