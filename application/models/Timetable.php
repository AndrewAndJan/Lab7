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

    function __construct($time, $course, $type, $day,$room, $instructor, $timeEnd)
    {
        $this->time         = $time;
        $this->course       = $course;
        $this->type         = $type;
        $this->day          = $day;
        $this->room         = $room;
        $this->instructor   = $instructor;
        $this->timeEnd      = $timeEnd;
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

