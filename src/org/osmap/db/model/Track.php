<?php
namespace org\osmap\db\model;

use DateTime;
use PhpParser\Node\Expr\Cast\Double;
    class Track{
        public ?int $id;
        public ?string $title;
        public ?int $userid;
        public ?string $gpx;
        public ?string $creation_date;
        public ?string $update_date ;
        public ?float $max_lat;
        public ?float $max_lng;
        public ?float $min_lat;
        public ?float $min_lng;
        public ?bool $is_active;
       
        public static function Create($title, $userid, $gpx, $max_lat,$max_lng,$min_lat,$min_lng):Track{
            $track = new Track();
            $track->title = $title;
            $track->userid = $userid;
            $track->gpx = $gpx;
            $track->max_lat = $max_lat;
            $track->max_lng = $max_lng;
            $track->min_lat = $min_lat;
            $track->min_lng = $min_lng;
            return $track;
        }
    }