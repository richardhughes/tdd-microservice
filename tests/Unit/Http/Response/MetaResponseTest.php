<?php

namespace Tests\Unit\Http\Response;

use App\Http\Response\MetaResponse;
use Carbon\Carbon;
use Mockery;
use TestCase;

class MetaResponseTest extends TestCase
{
    private $metaResponse;

    public function setUp()
    {
        parent::setUp();
        $this->metaResponse = new MetaResponse();
    }

    public function testMetaResponseExists()
    {
        $this->assertInstanceOf(MetaResponse::class, $this->metaResponse);
    }

    public function testBodySetIsReturnedInGetBody()
    {
        $body = [
            'test' => 'data'
        ];

//        $metaResponse = new MetaResponse();
        $this->metaResponse->setBody($body);

        $this->assertSame([
            $body,
            'meta' => [
                'time' => '2017-09-07 21:00:00'
            ]
        ], $this->metaResponse->getBody());
    }

    public function testMetaDataContainsTimeValue()
    {
//        $metaResponse = new MetaResponse();
        $body = $this->metaResponse->getBody();
        $this->assertArrayHasKey('time', $body['meta']);
    }

    public function testMetaDataContainsTheCorrectTimeValue()
    {
        Carbon::setTestNow('2017-09-07 21:00:00');
//        $metaResponse = new MetaResponse();
        $body = $this->metaResponse->getBody();
        $meta = $body['meta'];
        $this->assertSame('2017-09-07 21:00:00', $meta['time']);
    }

    public function testGetMetaDataContainsTheCorrectTimeValue()
    {
        Carbon::setTestNow('2017-09-07 21:00:00');
//        $metaResponse = new MetaResponse();
        $meta = $this->metaResponse->getMeta();
        $this->assertSame('2017-09-07 21:00:00', $meta['time']);
    }

    public function testGetMetaDataContainsFutureTimeValue()
    {
        Carbon::setTestNow('2019-09-07 21:00:00');
//        $metaResponse = new MetaResponse();
        $meta = $this->metaResponse->getMeta();
        $this->assertSame('2019-09-07 21:00:00', $meta['time']);
    }
}