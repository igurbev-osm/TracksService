<?php
    class Track{
        public $id;
        public $title;
        public $gpx;
        public $bounds;
        public $active;
        public function __construct($id,$title,$gpx,$active, $bounds){
            $this->id = $id;
            $this->title = $title;
            $this->gpx = $gpx;
            $this->active = $active;                
            $this->bounds = $bounds;
        }
    }