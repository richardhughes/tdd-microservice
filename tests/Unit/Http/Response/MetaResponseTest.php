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

        $this->assertSame($body, $this->metaResponse->getBody());
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

    /**
     * @dataProvider highLevelStructureDataProvider
     */
    public function testToResponseHasCorrectHighLevelStructure($key)
    {
        $this->metaResponse->setBody([]);
        $response = $this->metaResponse->toResponse();

        $this->assertArrayHasKey($key, $response);
    }

    public function highLevelStructureDataProvider(): array
    {
        return [
            ['payload'],
            ['meta']
        ];
    }


    public function testMetaDataContainsHash()
    {
        $meta = $this->metaResponse->getMeta();
        $this->assertArrayHasKey('hash', $meta);
    }
}