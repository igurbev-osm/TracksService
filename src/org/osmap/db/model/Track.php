<?php
namespace Org\Osmap\Db\Model;
    class Track{
        public $id;
        public $title;
        public $userid;
        public $gpx;
        public $creation_date;
        public $update_date ;
        public $max_lat;
        public $max_lng;
        public $min_lat;
        public $min_lng;
        public $is_active;
       
        public function __construct($id = null,$title = null,$userid = null,$gpx = null,$max_lat = null,$max_lng = null,$min_lat = null,$min_lng = null,$is_active = true,$creation_date=null,$update_date=null){
            $this->id = $id;
            $this->title = $title;
            $this->userid = $userid;
            $this->gpx = $gpx;            
            $this->max_lat = $max_lat;
            $this->max_lng = $max_lng;
            $this->min_lat = $min_lat;
            $this->min_lng = $min_lng;
            $this->is_active = $is_active;
            $this->creation_date = $creation_date;
            $this->update_date = $update_date;
        }
    }