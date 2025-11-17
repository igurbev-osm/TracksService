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
       
    }