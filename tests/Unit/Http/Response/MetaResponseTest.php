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
        $body = $this->metaResponse->getBody();
        $this->assertArrayHasKey('time', $body['meta']);
    }

    /**
     * @dataProvider timeDataProvider
     * @param $time
     */
    public function testMetaDataInBodyContainsTheCorrectTimes($time)
    {
        Carbon::setTestNow($time);
        $body = $this->metaResponse->getBody();
        $meta = $body['meta'];
        $this->assertSame($time, $meta['time']);
    }

    /**
     * @dataProvider timeDataProvider
     * @param $time
     */
    public function testGetMetaDataHasCorrectTime($time)
    {
        Carbon::setTestNow($time);
        $meta = $this->metaResponse->getMeta();
        $this->assertSame($time, $meta['time']);
    }

    public function timeDataProvider(): array
    {
        return [
            ['2016-09-07 21:00:00'],
            ['2017-09-07 21:00:00'],
            ['2018-09-07 21:00:00'],
            ['2019-09-07 21:00:00']
        ];
    }
}