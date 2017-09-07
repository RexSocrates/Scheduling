<?php
namespace App\CustomClass;

class OnReservation {
    $day = 0;
    $location = '';
    $dayOrNight = '';
    doctorsID = [];
    
    function __construct($day = 0, $location = '', $dayOrNight = '', $doctors = []) {
        $this->day = $day;
        $this->location = $location;
        $this->dayOrNight = $dayOrNight;
        $this->doctorsID = $doctors;
    }
}