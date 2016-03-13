<?php 
class Booking extends CI_Model {
    // Attributes
    public $time;
    public $course;
    public $type;
    public $day;
    public $room;
    
    function __construct($time, $course, $type, $day,$room)
    {
        $this->time     = $time;
        $this->course   = $course;
        $this->type     = $type;
        $this->day      = $day;
        $this->room     = $room;
    }

}

class Room extends CI_Model{
    public $building;
    public $number;
    
    
    function __construct($building, $number){
        $this->building = $building;
        $this->number   = $number;
    }
}
