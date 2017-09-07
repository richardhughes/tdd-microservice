<?php

namespace Tests\Unit\Http\Response;

use App\Http\Response\MetaResponse;
use Carbon\Carbon;
use TestCase;

class MetaResponseTest extends TestCase
{
    public function testMetaResponseExists()
    {
        $this->assertInstanceOf(MetaResponse::class, new MetaResponse());
    }

    public function testBodySetIsReturnedInGetBody()
    {
        $body = [
            'test' => 'data'
        ];

        $metaResponse = new MetaResponse();
        $metaResponse->setBody($body);

        $this->assertSame([
            $body,
            'meta' => [
                'time' => ''
            ]
        ], $metaResponse->getBody());
    }

    public function testMetaDataContainsTimeValue()
    {
        $metaResponse = new MetaResponse();
        $body = $metaResponse->getBody();
        $this->assertArrayHasKey('time', $body['meta']);
    }

    public function testMetaDataContainsTheCorrectTimeValue()
    {
        Carbon::setTestNow('2017-09-07 21:00:00');
        $metaResponse = new MetaResponse();
        $body = $metaResponse->getBody();
        $meta = $body['meta'];
        $this->assertSame('2017-09-07 21:00:00', $meta['time']);
    }
}