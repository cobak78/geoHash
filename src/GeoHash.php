<?php

namespace Cobak78\GeoHash;

/**
 * Class GeoHash
 * @package Cobak78\GeoHash
 */
class GeoHash
{
    /**
     * @param  float  $lat1
     * @param  float  $lon1
     * @param  float  $lat2
     * @param  float  $lon2
     * @param  string $unit
     * @return float
     */
    public function distance(
        float $lat1,
        float $lon1,
        float $lat2,
        float $lon2,
        string $unit = 'K'
    ) {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        switch (strtoupper($unit)) {
            case "K":
            case "KM":
                return ($miles * 1.609344);
            case "MN":
            case "N":
                return ($miles * 0.8684);
            default:
                return $miles;
        }
    }

    /**
     * geoBoundBox: [ top_left => [ lat => x, lon => y ], bottom_right => [ lat => x, lon => y ]
     *
     * @param  array      $geoBoundBox
     * @param  int        $squares
     * @return mixed
     * @throws \Exception
     */
    public function getGeoHashPrecision(array $geoBoundBox, int $squares)
    {
        $remainder = $squares % 2;
        $xQuotient = $squares / 2;
        $yQuotient = $xQuotient / 2;

        if (0 !== $remainder) {
            throw new \Exception('geoHash divisions must be multiple of 2');
        }

        // get x distance
        $xDist = $this->distance($geoBoundBox['top_left']['lat'], $geoBoundBox['top_left']['lon'], $geoBoundBox['bottom_right']['lat'], $geoBoundBox['top_left']['lon']);
        $xDist = $xDist * 1000;
        // get y distance
        $yDist = $this->distance($geoBoundBox['top_left']['lat'], $geoBoundBox['top_left']['lon'], $geoBoundBox['top_left']['lat'], $geoBoundBox['bottom_right']['lon']);
        $yDist = $yDist * 1000;

        // geohash distances
        $xGeohashDist = $xDist / $xQuotient;
        $yGeohashDist = $yDist / $yQuotient;

        return $this->getPrecisionFromArea($xGeohashDist, $yGeohashDist);

    }

    private function getPrecisionFromArea($width, $height)
    {
        // return
        $widthPrecision = [
            1 => 5009400,
            2 => 1252300,
            3 => 156500,
            4 => 39100,
            5 => 4900,
            6 => 1200,
            7 => 152.9,
            8 => 38.2,
            9 => 4.8,
            10 => 1.2,
            11 => 0.14,
            12 => 0.037,
        ];

        $heightPrecision = [
            1 => 4992000.6,
            2 => 624100,
            3 => 156000,
            4 => 19500,
            5 => 4900,
            6 => 609.4,
            7 => 152.4,
            8 => 19,
            9 => 4.8,
            10 => 0.595,
            11 => 0.149,
            12 => 0.019,
        ];

        $xPrecision = 12;
        foreach ($widthPrecision as $key => $value) {
            if ($width > $value) {
                $xPrecision = $key;
                break;
            }
        }

        $yPrecision = 12;
        foreach ($heightPrecision as $key => $value) {
            if ($height > $value) {
                $yPrecision = $key;
                break;
            }
        }

        return min($xPrecision, $yPrecision);
    }
}
