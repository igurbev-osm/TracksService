<?php
namespace org\osmap\utils;
class GpxUtils{
    public static function getBoundsCorners($minLat, $minLng, $maxLat, $maxLng) {
    return [
        'south_west' => ['lat' => $minLat, 'lng' => $minLng],
        'north_west' => ['lat' => $maxLat, 'lng' => $minLng],
        'north_east' => ['lat' => $maxLat, 'lng' => $maxLng],
        'south_east' => ['lat' => $minLat, 'lng' => $maxLng],
    ];
}
}