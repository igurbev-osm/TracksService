<?php
namespace Org\Osmap\Utils\Gpx;
use Psr\Http\Message\ServerRequestInterface;
use Org\Osmap\Utils\Gpx\Point;
class Bounds{
    public $maxLat;
    public $maxLng;
    public $minLat;
    public $minLng;

    public function __construct(Point $point1, Point $point2){
        $this->minLat = min($point1->lat, $point2->lat);
        $this->maxLat = max($point1->lat, $point2->lat);
        $this->minLng = min($point1->lng, $point2->lng);
        $this->maxLng = max($point2->lng, $point2->lng);
    }

    public static function create(array $points):Bounds{
        return new Bounds(new Point($points[0], $points[1]), new Point($points[2], $points[3]));
    }

    public static function getBountsFromQuery(ServerRequestInterface $request) : Bounds{
        $query = $request->getQueryParams();
        $points = $query["bounds"];
        return Bounds::create(explode(";", $points));
    }
}