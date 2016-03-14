<?php
class Timetable extends CI_Model {

    protected $xml = null;
    protected $days = array();
    protected $periods = array();
    protected $courses = array();

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();

        $this->xml = simplexml_load_file(DATAPATH . '/schedule.xml');

        $this->initializeDays();
        $this->initializeCourses();
        $this->initializePeriods();
    }

    function initializeDays(){
        foreach($this->xml->days->day as $day){
            $specDay = (string) $day["name"];
            foreach($day->booking as $booking){
                $building = (string) $booking->room->building;
                $number = (string) $booking->room->number;
                $room = new Room($building,$number);

                $time =  (string) $booking["time"];
                $course =  (string) $booking["course"];
                $type =  (string) $booking["type"];
                $instructor = (string) $booking->instructor;
                $timeEnd = (string) $booking->timeEnd;
                
                $booking = new Booking($time,$course,$type,$specDay, $room,$instructor, $timeEnd);
                $this->days[] = $booking;
            }
        }
    }

    function initializeCourses(){
        foreach($this->xml->courses->course as $course){
            $specCourse = (string) $course["id"];
            foreach($course->booking as $booking){
                $building = (string) $booking->room->building;
                $number = (string) $booking->room->number;
                $room = new Room($building,$number);

                $time =  (string) $booking["time"];
                $specDay =  (string) $booking["day"];
                $type =  (string) $booking["type"];
                $instructor = (string) $booking->instructor;
                $timeEnd = (string) $booking->timeEnd;
                
                // changed
                $booking = new Booking($time,$specCourse,$type,$specDay, $room,$instructor, $timeEnd);
                $this->courses[] = $booking;
            }
        }
    }

    function initializePeriods(){
        foreach($this->xml->periods->timeslot as $timeslot){
            $specTimeSlot = (string) $timeslot["time"];
            foreach($timeslot->booking as $booking){
                $specDay = $booking["day"];
                $building = (string) $booking->room->building;
                $number = (string) $booking->room->number;
                $room = new Room($building,$number);

                $time =  (string) $booking["time"];
                $course =  (string) $booking["course"];
                $type =  (string) $booking["type"];
                $instructor = (string) $booking->instructor;
                $timeEnd = (string) $booking->timeEnd;
                
                $booking = new Booking($specTimeSlot,$course,$type,$specDay, $room,$instructor, $timeEnd);
                $this->periods[] = $booking;
            }
        }
    }
    
    function getDays(){
        return $this->days;
    }
    
    function getCourses(){
        return $this->courses;
    }
    
    function getPeriods(){
        return $this->periods;
    }
    
    function getListOfDays(){
        $listOfDays = array('Monday' => 'Monday', 'Tuesday' => 'Tuesday', 'Wednesday' => 'Wednesday', 'Thursday' => 'Thursday', 'Friday' => 'Friday');
        return $listOfDays;
    }
    
    function getListOfPeriods(){
        $periods = array (
            "8:30-10:30"    => "8:30 to 10:30",
            "9:30-11:30"    => "9:30 to 11:30",
            "10:30-12:20"   => "10:30 to 12:20",
            "11:30-12:30"   => "11:30 to 12:30",
            "12:30-14:20"   => "12:30 to 14:20",
            "14:30-15:30"   => "14:30 to 13:30",
            "14:30-17:20"   => "14:30 to 17:20"
        ); 
        
        return $periods;
    }
    
    
    function checkCourses($specDay, $specTimeSlot){
        $times = explode("-", $specTimeSlot);
        
        foreach($this->courses as $booking){
            if($booking->day == $specDay && $booking->time == $times[0] 
                && $booking->timeEnd == $times[1]){
                return $booking;       
            }
        }
        return null;
    }
    
    function checkPeriods($specDay, $specTimeSlot){
                $times = explode("-", $specTimeSlot);
        
        foreach($this->periods as $booking){
            if($booking->day == $specDay && $booking->time == $times[0] 
                && $booking->timeEnd == $times[1]){
                return $booking;       
            }
        }
        return null;
    }
    
    function checkDays($specDay, $specTimeSlot){
        $times = explode("-", $specTimeSlot);
        
        foreach($this->days as $booking){
            if($booking->day == $specDay && $booking->time == $times[0] 
                && $booking->timeEnd == $times[1]){
                return $booking;       
            }
        }
        return null;
    }
    
    function compareBooking($booking1, $booking2){
        if($booking1->day == $booking2->day 
            && $booking1->time == $booking2->time
            && $booking1->course == $booking2->course
            && $booking1->instructor == $booking2->instructor
            && $booking1->building == $booking2->building
            && $booking1->room == $booking2->room
            && $booking1->type == $booking2->type
            && $booking1->timeEnd == $booking2->timeEnd){
                return true;
            }
        return false;
    }
}

class Booking extends CI_Model {
    // Attributes
    public $time;
    public $course;
    public $type;
    public $day;
    public $room;
    public $instructor;
    public $timeEnd;
    public $building;
    
    function __construct($time, $course, $type, $day,$room, $instructor, $timeEnd)
    {
        $this->time             = $time;
        $this->course           = $course;
        $this->type             = $type;
        $this->day              = $day;
        $this->room             = $room->number;
        $this->instructor       = $instructor;
        $this->timeEnd          = $timeEnd; 
        $this->building         = $room->building; 
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

