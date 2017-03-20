<?php

namespace Cobak78\GeoHash\Tests;

use Cobak78\GeoHash\GeoHash;

/**
 * Class GeoHashTest
 * @package Cobak78\GeoHash\Tests
 */
class GeoHashTest extends \PHPUnit_Framework_TestCase
{
    const
        TOP_LEFT = ['lat' => 41.5926176, 'lon' => 2.1693494],
        BOTTOM_RIGHT = ['lat' => 41.3326176, 'lon' => 2.0693494],
        OPEN_TOP_LEFT = ['lat' => 45.5926176, 'lon' => 2.5693494],
        OPEN_BOTTOM_RIGHT = ['lat' => 35.3326176, 'lon' => 1.5693494],
        SQUARES = 4,
        KM_DISTANCE = 30.086138600645093,
        KM_DISTANCE_OPEN = 1143.9106866432,
        MILES_DISTANCE = 18.694659812101,
        MILES_DISTANCE_OPEN = 710.7931471725,
        NAUTICAL_MILES_DISTANCE = 16.234442580828,
        NAUTICAL_MILES_DISTANCE_OPEN = 617.2527690046
    ;

    /**
     * @var GeoHash
     */
    private $geoClass;

    public function setUp()
    {
        $this->geoClass = new GeoHash();
    }


    public function testDistance()
    {
        //KM
        $result = $this->geoClass->distance(static::TOP_LEFT['lat'], static::TOP_LEFT['lon'], static::BOTTOM_RIGHT['lat'], static::BOTTOM_RIGHT['lon'], "K");

        $this->assertEquals(static::KM_DISTANCE, $result);

        $result_open = $this->geoClass->distance(static::OPEN_TOP_LEFT['lat'], static::OPEN_TOP_LEFT['lon'], static::OPEN_BOTTOM_RIGHT['lat'], static::OPEN_BOTTOM_RIGHT['lon'], "K");

        $this->assertEquals(static::KM_DISTANCE_OPEN, $result_open);
        $this->assertGreaterThan($result, $result_open);

        //MILES
        $result = $this->geoClass->distance(static::TOP_LEFT['lat'], static::TOP_LEFT['lon'], static::BOTTOM_RIGHT['lat'], static::BOTTOM_RIGHT['lon'], "M");

        $this->assertEquals(static::MILES_DISTANCE, $result);

        $result_open = $this->geoClass->distance(static::OPEN_TOP_LEFT['lat'], static::OPEN_TOP_LEFT['lon'], static::OPEN_BOTTOM_RIGHT['lat'], static::OPEN_BOTTOM_RIGHT['lon'], "M");

        $this->assertEquals(static::MILES_DISTANCE_OPEN, $result_open);
        $this->assertGreaterThan($result, $result_open);

        //NAUTICAL MILES
        $result = $this->geoClass->distance(static::TOP_LEFT['lat'], static::TOP_LEFT['lon'], static::BOTTOM_RIGHT['lat'], static::BOTTOM_RIGHT['lon'], "N");

        $this->assertEquals(static::NAUTICAL_MILES_DISTANCE, $result);

        $result_open = $this->geoClass->distance(static::OPEN_TOP_LEFT['lat'], static::OPEN_TOP_LEFT['lon'], static::OPEN_BOTTOM_RIGHT['lat'], static::OPEN_BOTTOM_RIGHT['lon'], "N");

        $this->assertEquals(static::NAUTICAL_MILES_DISTANCE_OPEN, $result_open);
        $this->assertGreaterThan($result, $result_open);
    }

    public function testGetGeoHashPrecision()
    {
        $result = $this->geoClass->getGeoHashPrecision(['top_left' => static::TOP_LEFT, 'bottom_right' => static::BOTTOM_RIGHT], static::SQUARES);

        $this->assertEquals(5, $result);

        $result = $this->geoClass->getGeoHashPrecision(['top_left' => static::OPEN_TOP_LEFT, 'bottom_right' => static::OPEN_BOTTOM_RIGHT], static::SQUARES);

        $this->assertEquals(3, $result);

    }
}
